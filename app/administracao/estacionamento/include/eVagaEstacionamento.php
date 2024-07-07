<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if(isset($_POST['idVagaEstacionamento'])){
        $id = $_POST['idVagaEstacionamento'];
        // echo 'recebemos o id: ' .  $id;
        // die();
        $sql = "DELETE FROM tbl_estacionamento where id_estacionamento = '$id'";
        if(mysqli_query($con, $sql)){
            $mensagem = "Vaga exluida com sucesso!";
            header('location: ../index.php?msg=Deletado com sucesso!');
        
        } else {
            $mensagem = "Não foi possivel excluir a vaga!";
        }

    }

?>