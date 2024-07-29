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

        $totalPago = $array['total_pago'];

        $novoPagamentoConvertido = converterMonetario($novoPagamento);
        $novoPagamentoTratado = floatval($novoPagamentoConvertido);
        $total = $totalPago + $novoPagamentoTratado;


        $sql = mysqli_prepare($con, "UPDATE tbl_reserva SET total_pago = ? WHERE id_reserva = ?");
        mysqli_stmt_bind_param($sql, 'di', $total, $idReservaPost);

        if(mysqli_stmt_execute($sql)) {
            $mensagem = "Pagamento realizado com sucesso!";
            header('location: ../index.php?msg=' . $mensagem);
            mysqli_close($con);

        } else {
            echo "Ocorreu um erro na operação. " . mysqli_error($con);
        }
     
    } else {
        $msg = "O ID da reserva não foi enviado.";
        header('location: ../index.php?msgInvalida=' . $msg);
        die();
    }
?>
