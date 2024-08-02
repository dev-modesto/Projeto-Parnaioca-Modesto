<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;
    include PASTA_FUNCOES . '/converter.php';

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['id-tabela'];
        $idItem = $_POST['id-item'];
        $idSku = $_POST['id-sku'];
        $quantidade = $_POST['quantidade'];
        $valorUnitario = $_POST['valor-unitario'];
        $valorTotal = $_POST['valor-total'];
        $notaFiscal = $_POST['nota-fiscal'];

        $valorUnitarioFormatado = converterMonetario($valorUnitario);
        $valorTotalFormatado = converterMonetario($valorTotal);

        mysqli_begin_transaction($con);

        try {

            $sql = 
                mysqli_prepare(
                $con, 
                "UPDATE tbl_entrada_item_estoque
                SET
                    id_item=?,
                    id_sku=?, 
                    quantidade=?, 
                    valor_unit=?, 
                    valor_total=?, 
                    nota_fiscal=?, 
                    id_funcionario=?
                WHERE id_e_item_e = '$id'
            ");

            mysqli_stmt_bind_param(
                $sql, 
                "isiddsi", 
                $idItem, 
                $idSku, 
                $quantidade, 
                $valorUnitarioFormatado, 
                $valorTotalFormatado, 
                $notaFiscal, 
                $idLogado
            );

            mysqli_stmt_execute($sql);

            // log operações
                $nomeTabela = 'tbl_entrada_item_estoque';
                $idRegistro = $id;
                $tpOperacao = 'atualizacao';
                $descricao = 'Item atualizado ID: ' . $idSku;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 

            mysqli_commit($con);
            header('location: ../index.php?msg=Alterado com sucesso!');

        } catch (Exception $e) {
            mysqli_rollback($con);
            $mensagem = "Ocorreu um erro. Não foi possível realizar a operação.";
            header('location: ../index.php?msgInvalida=' . $mensagem);

        } finally {
            mysqli_close($con);
        }

    } else {
        $mensagem = "";
    }

?>