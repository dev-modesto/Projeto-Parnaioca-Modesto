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

        $idItem = $_POST['id-item'];
        $idSku = $_POST['id-sku'];
        $quantidade = $_POST['quantidade'];
        $valorUnitario = $_POST['valor-unitario'];
        $valorTotal = $_POST['valor-total'];
        $notaFiscal = $_POST['nota-fiscal'];

        $valorUnitarioFormatado = converterMonetario($valorUnitario);
        $valorTotalFormatado = converterMonetario($valorTotal);

        $sql = 
            mysqli_prepare(
                $con, 
                "INSERT INTO tbl_entrada_item_estoque(
                    id_item, 
                    id_sku, 
                    quantidade, 
                    valor_unit, 
                    valor_total, 
                    nota_fiscal, 
                    id_funcionario) 
                VALUES (?,?,?,?,?,?,?)
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

        if(mysqli_stmt_execute($sql)){
                // id gerado ao gravar
                $idGerado = mysqli_insert_id($con);

            // log operações
                $nomeTabela = 'tbl_entrada_item_estoque';
                $idRegistro = $idGerado;
                $tpOperacao = 'insercao';
                $descricao = 'Item adicionado ID: ' . $idGerado;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            header('location: ../index.php?msg=Adicionado com sucesso!');

        } else {
            echo "Error ao gravar" . mysqli_error($con);
        }

        mysqli_close($con);
        
    } else {
        echo "";

    }

?>