<?php
    include __DIR__  . '/../../../config/conexao.php';

    if(isset($_POST['idFuncionario'])){
        $id = $_POST['idFuncionario'];
        // echo 'recebemos o id: ' .  $id;
        $sql = "DELETE FROM tbl_funcionario where id_funcionario = '$id'";
        if(mysqli_query($con, $sql)){
            $mensagem = "Funcionário exluido com sucesso!";
            header('location: ../index.php?msg=Deletado com sucesso!');
        
        } else {
            $mensagem = "Não foi possivel excluir o funcionário!";
        }

    }
?>
