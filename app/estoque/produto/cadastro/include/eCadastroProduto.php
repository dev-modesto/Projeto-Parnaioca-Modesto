<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if (isset($_POST['id-item'])) {
        $idItem = $_POST['id-item'];
        $idSku = $_POST['id-sku'];

        $sql = "DELETE FROM tbl_item WHERE id_item = $idItem";
        
        if(mysqli_query($con, $sql)){
            // log operações
                $nomeTabela = 'tbl_item';
                $idRegistro = $idItem;
                $tpOperacao = 'exclusao';
                $descricao = 'Item excluído ID: ' . $idSku;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            header('location: ../index.php?msg=Deletado com sucesso!');
        
        } else {
            $mensagem = "Não foi possivel excluir o item!";
        }
        

    }

?>