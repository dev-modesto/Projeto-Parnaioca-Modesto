<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if($_SERVER['REQUEST_METHOD'] == "POST") {
        
        $cpf = $_POST['cpf'];
        $idAcomodacao = $_POST['id-acomodacao'];
        $idCliente = $_POST['id-cliente'];
        $nome = $_POST['nome'];
        $totalHospede = $_POST['total-hospede'];
        $acomodacao = $_POST['acomodacao'];
        $numeroAcomodacao = $_POST['numero-acomodacao'];
        $dataInicio = $_POST['data-inicio'];
        $dataFim = $_POST['data-final'];
        $valorDiaria = $_POST['valor-diaria'];
        $valorReservaTotal = $_POST['valor-reserva-total'];
        
        echo "<pre>";
        $arry = [$idAcomodacao, $idCliente, $cpf, $nome, $totalHospede, $acomodacao, $numeroAcomodacao, $dataInicio, $dataFim, $valorDiaria, $valorReservaTotal];
        print_r($arry);

    }   


?>