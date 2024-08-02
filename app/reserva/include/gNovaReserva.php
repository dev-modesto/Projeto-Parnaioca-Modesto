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

        } else if ($valorEntradaConvertido > 0) {
            $idStatusPagamento = 2; //parcial

        } else {
            $valorEntradaConvertido = 0;
            $idStatusPagamento = 1; //pendente
        }

        mysqli_begin_transaction($con);

        try {

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

            mysqli_stmt_execute($sql);
            $idReserva = mysqli_insert_id($con);

            // log operações
                $nomeTabela = 'tbl_reserva';
                $idRegistro = $idReserva;
                $tpOperacao = 'insercao';
                $descricao = 'Reserva realizada ID: ' . $idReserva;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 

            if($valorEntradaConvertido > 0 ) {
                $sqlPagamento = mysqli_prepare($con, "INSERT INTO tbl_pagamento(id_reserva, valor, id_metodo_pag) VALUES(?,?,?)");
                mysqli_stmt_bind_param($sqlPagamento, 'idi', $idReserva, $valorEntradaConvertido, $idFormaPagamento);
                mysqli_stmt_execute($sqlPagamento);

                // log operações
                    $nomeTabela = 'tbl_pagamento';
                    $idRegistro = $idReserva;
                    $tpOperacao = 'insercao';
                    $descricao = 'Pagamento realizado ID reserva: ' . $idReserva;
                    logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
                // 
            }

            $mensagem = "Reserva realizada com sucesso!";
            header('location: ../index.php?msg=' . $mensagem);
            mysqli_commit($con);

        } catch (Exception $e) {
            mysqli_rollback($con);
            unset($_SESSION['id-reserva']);
            $mensagem = "Ocorreu um erro. Não foi possível realizar a reserva.";
            header('location: ../index.php?msgInvalida=' . $mensagem);

        } finally {
            mysqli_close($con);
        }
    
    } else {
        $msg = "O ID da reserva não foi enviado.";
        unset($_SESSION['id-reserva']);
        header('location: ../index.php?msgInvalida=' . $msg);
    } 
?>