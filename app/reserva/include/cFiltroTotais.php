<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include_once(ARQUIVO_CONEXAO);
    include_once(ARQUIVO_FUNCAO_SQL);
    include_once(ARQUIVO_FUNCAO_SQL_RESERVA);

    date_default_timezone_set('America/Sao_Paulo');
    $extraiData = new DateTimeImmutable();
    $dataAtual = date_format($extraiData, "Y-m-d");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $dataInicio = $_POST['data-inicio'];
        $dataFinal = $_POST['data-final'];

        // ID de status das reservas
            $pendente = 1;
            $confirmado = 2;
            $cancelado = 3;
            $checkIn = 4;
            $checkOut = 5;
            $finalizado = 6;
        // 

        $sqlTotalHospedes = 
            "SELECT COALESCE(SUM(total_hospedes), 0) as total_hospedes 
            FROM tbl_reserva 
            WHERE ((dt_reserva_inicio <= '$dataFinal 23:59:59' AND dt_reserva_fim >= '$dataInicio 00:00:00')
            OR (dt_reserva_inicio >= '$dataInicio 00:00:00' AND dt_reserva_fim <= '$dataFinal 23:59:00'))
            AND id_status_reserva = '$checkIn'
        ";

        $consultaHospedes = mysqli_query($con, $sqlTotalHospedes);
        $arrayTotalHospedes = mysqli_fetch_assoc($consultaHospedes);
        $totalHospedes = $arrayTotalHospedes['total_hospedes'];

        $totalPendentes = totalStatusReservaFiltro($con, $dataInicio, $dataFinal, $pendente);
        $totalConfirmados = totalStatusReservaFiltro($con, $dataInicio, $dataFinal, $confirmado);
        $totalFinalizados = totalStatusReservaFiltro($con, $dataInicio, $dataFinal, $finalizado);
        $totalCheckIn = totalStatusReservaFiltro($con, $dataInicio, $dataFinal, $checkIn);
        $totalCheckOut = totalStatusReservaFiltro($con, $dataInicio, $dataFinal, $checkOut);
        $totalCancelados = totalStatusReservaFiltro($con, $dataInicio, $dataFinal, $cancelado);

        $arrayTotalStatus = [
            "totalPendentes" => $totalPendentes,
            "totalConfirmados" => $totalConfirmados,
            "totalFinalizados" => $totalFinalizados,
            "totalCheckIn" => $totalCheckIn,
            "totalCheckOut" => $totalCheckOut,
            "totalCancelados" => $totalCancelados,
            "totalHospedes" => $totalHospedes
        ];
        
        header('Content-Type: application/json');
        echo json_encode($arrayTotalStatus);
        exit;
    }

?>