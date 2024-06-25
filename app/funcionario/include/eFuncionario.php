<?php
    include __DIR__  . '/../../../config/conexao.php';

    if($_GET['id']){
        $id = $_GET['id'];
        $sql = "DELETE FROM tbl_funcionario where id_funcionario = '$id'";

        if(mysqli_query($con, $sql)){
            $mensagem = "Usuario exluido com sucesso!";
            header('location: ../index.php?msg=Deletado com sucesso!');
        }else {
            $mensagem = "Não foi possivel excluir o usuario!";
            die;
        }
    }

?>