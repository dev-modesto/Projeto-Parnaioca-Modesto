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
        $totalHospede = $_POST['total-hospede'];
        $dataCheckIn = $_POST['data-inicio'];
        $dataCheckOut = $_POST['data-final'];
        $horarioCheckInPadrao = "13:00";
        $horarioCheckOutPadrao = "11:00";

        $dateTimeCheckIn = new DateTime($dataCheckIn);
        $dateTimeCheckOut = new DateTime($dataCheckOut);
        $intervalo = $dateTimeCheckIn->diff($dateTimeCheckOut);
        $qntNoites = $intervalo->days;

        $dataHorarioCheckIn = ($dataCheckIn ." ".  $horarioCheckInPadrao);
        $dataHorarioCheckOut = ($dataCheckOut ." ". $horarioCheckOutPadrao);
        
        $valorEntrada = $_POST['valor-entrada'];
        $valorEntradaConvertido = converterMonetario($valorEntrada);
        
        $retornoInfoAcomodacao = consultaInfoAcomodacao($con, 0, $idAcomodacao);
        $arrayInfoAcomodacao = mysqli_fetch_assoc($retornoInfoAcomodacao);
        $valorDiaria = $arrayInfoAcomodacao['valor'];
        
        $valorReservaTotal = $valorDiaria * $qntNoites;

        $array = [
            "ID acomodacao: ". $idAcomodacao,
            "ID cliente: " . $idCliente,
            "Total hospedes: " . $totalHospede,
            "Data check-in: " . $dataHorarioCheckIn,
            "Data check-out: " .  $dataHorarioCheckOut,
            "Valor diaria: " . $valorDiaria,
            "Valor entrada: " . $valorEntradaConvertido, 
            "Valor total reserva: " . $valorReservaTotal, 
            "ID logado: " . $idLogado
        ];
        print_r($array);


    }   


?>