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
    
        if ($idReservaPost == $idReservaSessao) {

            // ID de status das reservas
                $pendente = 1;
                $confirmado = 2;
                $cancelado = 3;
                $checkIn = 4;
                $checkOut = 5;
                $finalizado = 6;
            // 

            $sql = 
                mysqli_prepare(
                    $con, 
                    "UPDATE tbl_reserva 
                    SET dt_check_in = NOW(), id_status_reserva = $checkIn 
                    WHERE id_reserva = ? 
            ");
                    
            mysqli_stmt_bind_param($sql, "i", $idReservaPost);
            mysqli_stmt_execute($sql);
            unset($_SESSION['id-reserva']);
            $mensagem = "Check-in realizado com sucesso!";
            header('location: ../index.php?msg=' . $mensagem);
            mysqli_close($con);

        } else {
            $msg = "Não foi possível realizar o check-in.";
            unset($_SESSION['id-reserva']);
            header('location: ../index.php?msgInvalida=' . $msg);
            die();
        }

    } else {
        $msg = "O ID da reserva não foi enviado.";
        unset($_SESSION['id-reserva']);
        header('location: ../index.php?msgInvalida=' . $msg);
        die();
    }
?>
