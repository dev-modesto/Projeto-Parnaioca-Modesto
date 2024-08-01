<?php

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        $idReservaSessao = $_SESSION['id-reserva'];
    }
    
    if (isset($_POST['id-reserva'])) {
        $idReservaPost = $_POST['id-reserva'];

        if ($idReservaPost !== $idReservaSessao) { 
            $mensagem = "Ocorreu um erro. Não foi possível realizar o check-out.";
            header('location: ../index.php?msgInvalida=' . $mensagem);
            die();
        }
            
        // ID de status das reservas
            $pendente = 1;
            $confirmado = 2;
            $cancelado = 3;
            $checkIn = 4;
            $checkOut = 5;
            $finalizado = 6;
        // 

        mysqli_begin_transaction($con);

        try {

            $sql = 
                mysqli_prepare(
                $con, 
                "UPDATE tbl_reserva 
                SET dt_check_out = NOW(), id_status_reserva = $checkOut 
                WHERE id_reserva = ? 
            ");
                    
            mysqli_stmt_bind_param($sql, "i", $idReservaPost);
            mysqli_stmt_execute($sql);

            // log operações
                $nomeTabela = 'tbl_reserva';
                $idRegistro = $idReservaPost;
                $tpOperacao = 'atualizacao';
                $descricao = 'Check-out realizado ID: ' . $idReservaPost;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 

            unset($_SESSION['id-reserva']);
            mysqli_commit($con);
            $mensagem = "Check-out realizado com sucesso!";
            header('location: ../index.php?msg=' . $mensagem);

        } catch (Exception $e) {
            mysqli_rollback($con);
            unset($_SESSION['id-reserva']);
            $mensagem = "Ocorreu um erro. Não foi possível realizar o check-out.";
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
