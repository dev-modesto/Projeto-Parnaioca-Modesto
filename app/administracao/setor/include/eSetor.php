<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if(isset($_POST['idSetor'])){
        $id = $_POST['idSetor'];
        // echo 'recebemos o id: ' .  $id;
        $sql = "DELETE FROM tbl_setor where id_setor = '$id'";
        if(mysqli_query($con, $sql)){
            $mensagem = "Setor exluido com sucesso!";
            header('location: ../index.php?msg=Deletado com sucesso!');
        
        } else {
            $mensagem = "Não foi possivel excluir o setor!";
        }

    }

?>