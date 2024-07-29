<?php

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL_RESERVA;
    include PASTA_FUNCOES . '/converter.php';

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        $idReservaSessao = $_SESSION['id-reserva'];
    }
    
    if (isset($_POST['id-reserva'])) {
        $idReservaPost = $_POST['id-reserva'];
        $idFormaPagamento = $_POST['id-forma-pagamento'];
        $novoPagamento = $_POST['valor'];
        $array = consultaInfoReserva($con, $idReservaPost);

        $novoPagamentoConvertido = converterMonetario($novoPagamento);

        if(is_numeric($idReservaPost)) {
            $idReserva = intval($idReservaPost);
                
            try {
                
                $sql = mysqli_prepare($con, "INSERT INTO tbl_pagamento(id_reserva, valor, id_metodo_pag) VALUES(?,?,?)");
                mysqli_stmt_bind_param($sql, 'idi', $idReservaPost, $novoPagamentoConvertido, $idFormaPagamento);
                mysqli_stmt_execute($sql);

                $mensagem = "Pagamento realizado com sucesso!";
                header('location: ../index.php?msg=' . $mensagem);
                mysqli_close($con);
                
            } catch (Exception $e) {
                $mensagem = "Houve um problema ao efetuar o pagamento.";
                header('location: ../index.php?msg=' . $mensagem);
            }

        } else {
            $mensagem = "Não foi possível realizar o pagamento.";
            header('location: ../index.php?msg=' . $mensagem);
        }
     
    } else {
        $msg = "O ID da reserva não foi enviado.";
        header('location: ../index.php?msgInvalida=' . $msg);
    }
?>
