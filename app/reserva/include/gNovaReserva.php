<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;
    include PASTA_FUNCOES . "/converter.php";

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        
        $idAcomodacao = $_POST['id-acomodacao'];
        $idCliente = $_POST['id-cliente'];
        $totalHospedes = $_POST['total-hospedes'];
        $dataCheckIn = $_POST['data-inicio'];
        $dataCheckOut = $_POST['data-final'];
        $horarioCheckInPadrao = "13:00";
        $horarioCheckOutPadrao = "11:00";
        $idStatusReserva = 1; //pendente
        $idFormaPagamento = $_POST['id-forma-pagamento'];

        $dateTimeCheckIn = new DateTime($dataCheckIn);
        $dateTimeCheckOut = new DateTime($dataCheckOut);
        $intervalo = $dateTimeCheckIn->diff($dateTimeCheckOut);
        $qntNoites = $intervalo->days;

        $dataHorarioCheckIn = ($dataCheckIn ." ".  $horarioCheckInPadrao);
        $dataHorarioCheckOut = ($dataCheckOut ." ". $horarioCheckOutPadrao);
        
        $valorEntrada = $_POST['valor-entrada'];
        $valorEntradaConvertido = floatval(converterMonetario($valorEntrada));
        
        $retornoInfoAcomodacao = consultaInfoAcomodacao($con, 0, $idAcomodacao);
        $arrayInfoAcomodacao = mysqli_fetch_assoc($retornoInfoAcomodacao);
        $valorDiaria = $arrayInfoAcomodacao['valor'];
        
        $valorReservaTotal = $valorDiaria * $qntNoites;


        if ($valorEntradaConvertido == $valorReservaTotal){
            $idStatusPagamento = 3; //pago 

        } else if ($valorEntrada > 0) {
            $valorEntradaConvertido;
            $idStatusPagamento = 2; //parcial

        } else {
            $valorEntradaConvertido = 0;
            $idStatusPagamento = 1; //pendente
        }

        $array = [
            "ID acomodacao: ". $idAcomodacao,
            "Valor diaria: " . $valorDiaria,
            "ID cliente: " . $idCliente,
            "Total hospedes: " . $totalHospedes,
            "Data reserva check-in: " . $dataHorarioCheckIn,
            "Data reserva check-out: " .  $dataHorarioCheckOut,
            "Valor entrada: " . $valorEntradaConvertido, 
            "Valor total reserva: " . $valorReservaTotal, 
            "ID forma pagamento: " . $idFormaPagamento,
            "ID status pagamento: " . $idStatusPagamento,
            "ID status reserva: " . $idStatusReserva,
            "ID logado: " . $idLogado
        ];

        $sql = 
            mysqli_prepare(
            $con,
            "INSERT INTO tbl_reserva (
            id_acomodacao,
            valor,
            id_cliente,
            total_hospedes,
            dt_reserva_inicio,
            dt_reserva_fim,
            total_noites,
            total_pago,
            valor_total_reserva,
            id_metodo_pag,
            id_status_pag,
            id_status_reserva,
            id_funcionario) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)"
        );

        mysqli_stmt_bind_param(
            $sql, 
            "idiissiddiiii", 
            $idAcomodacao, 
            $valorDiaria, 
            $idCliente, 
            $totalHospedes,
            $dataHorarioCheckIn, 
            $dataHorarioCheckOut, 
            $qntNoites, 
            $valorEntradaConvertido,
            $valorReservaTotal,
            $idFormaPagamento,
            $idStatusPagamento,
            $idStatusReserva,
            $idLogado
        );

        if(mysqli_stmt_execute($sql)){

        }  else {
            echo "Error ao gravar" . mysqli_error($con);
        }

        mysqli_close($con);


    }   


?>