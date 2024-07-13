<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if(isset($_POST['id_entrada-item-estoque'])){
        $id = $_POST['id_entrada-item-estoque'];

        $sql = "DELETE FROM tbl_entrada_item_estoque where id_e_item_e = '$id'";

        if(mysqli_query($con, $sql)){

            // log operações
                $nomeTabela = 'tbl_entrada_item_estoque';
                $idRegistro = $id;
                $tpOperacao = 'exclusao';
                $descricao = 'Item excluído ID: ' . $id;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 

            $mensagem = "Item exluido com sucesso!";
            header('location: ../index.php?msg=Deletado com sucesso!');
        
        } else {
            $mensagem = "Não foi possivel excluir o item!";
        }

    }
?>
