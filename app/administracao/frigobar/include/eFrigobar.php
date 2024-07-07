<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if(isset($_POST['id-frigobar'])){
        $id = $_POST['id-frigobar'];
        // echo 'recebemos o id: ' .  $id;
        // die();
        $sql = "DELETE FROM tbl_frigobar where id_frigobar = '$id'";
        if(mysqli_query($con, $sql)){
            $mensagem = "Frigobar exluido com sucesso!";
            header('location: ../index.php?msg=Deletado com sucesso!');
        
        } else {
            $mensagem = "Não foi possivel excluir.";
        }

    }

?>