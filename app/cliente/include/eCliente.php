<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if(isset($_POST['id-cliente'])){
        $id = $_POST['id-cliente'];
        // echo 'recebemos o id: ' .  $id;
        $sql = "DELETE FROM tbl_cliente where id_cliente = '$id'";
        if(mysqli_query($con, $sql)){
            $mensagem = "Cliente exluido com sucesso!";
            header('location: ../index.php?msg=Deletado com sucesso!');
        
        } else {
            $mensagem = "Não foi possivel excluir o cliente!";
        }

    }
?>
