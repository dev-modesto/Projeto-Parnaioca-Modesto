<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $idFrigobar = $_POST['id-frigobar'];
        $idAcomodacao = $_POST['id-acomodacao'];
        $idItem = $_POST['id-item-frigobar'];
        $sku = $_POST['sku'];
        $quantidade = $_POST['quantidade'];
        $capacidadeItens = $_POST['capacidade-itens'];

        $totalEntrada = totalEntradasEstoque($con, $idItem);
        $totalSaida = totalSaidasEstoque($con, $idItem);
        $totalEstoqueItem = ($totalEntrada - $totalSaida);

        $totalItensFrigobar = totalItensFrigobar($con, $idFrigobar);
        $totalLivreFrigobar = ($capacidadeItens - $totalItensFrigobar);
        
        if ($quantidade > $totalLivreFrigobar) {
            $mensagem = "Não há espaço no frigobar suficiente para esta quantidade de itens.";
            header("location: ../index.php?msgInvalida=" . $mensagem);
            die();
        } 
        
        if ($quantidade > $totalEstoqueItem) {
            $mensagem = "A quantidade de item informada é superior a quantidade disponível no estoque.";
            header("location: ../index.php?msgInvalida=" . $mensagem);
            die();
        }
        
        mysqli_begin_transaction($con);
        
        try {

            $sql = 
                mysqli_prepare(
                $con, 
                "INSERT INTO tbl_entrada_item_frigobar (
                    id_frigobar,
                    id_acomodacao,
                    id_item,
                    id_sku,
                    quantidade,
                    id_funcionario)
                VALUES (?,?,?,?,?,?)
            ");

            mysqli_stmt_bind_param(
                $sql, 
                "iiisii", 
                $idFrigobar, 
                $idAcomodacao,
                $idItem,
                $sku,
                $quantidade,
                $idLogado
            );

            mysqli_stmt_execute($sql);

            // id gerado ao gravar
            $idEntradaItemFrigobar = mysqli_insert_id($con);

            // log operações
                $nomeTabela = 'tbl_entrada_item_frigobar';
                $idRegistro = $sku;
                $tpOperacao = 'insercao';
                $descricao = 'Entrada item frigobar ID: ' . $sku;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 

            // sql tbl_saida_item_estoque
                $sqlSaidaEstoque = 
                    mysqli_prepare($con,
                    "INSERT INTO tbl_saida_item_estoque (
                        id_e_item_f,
                        id_item,
                        quantidade,
                        id_funcionario)
                    VALUES (?,?,?,?)
                ");
            //  

            mysqli_stmt_bind_param(
                $sqlSaidaEstoque,
                "iiii",
                $idEntradaItemFrigobar,
                $idItem,
                $quantidade,
                $idLogado
            );

            mysqli_stmt_execute($sqlSaidaEstoque);

            // log operações
                $nomeTabela = 'tbl_saida_item_estoque';
                $idRegistro = $sku;
                $tpOperacao = 'insercao';
                $descricao = 'Saida do produto ID: ' . $sku;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 

            mysqli_commit($con);
            header('location: ../index.php?msg=Adicionado com sucesso!');

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