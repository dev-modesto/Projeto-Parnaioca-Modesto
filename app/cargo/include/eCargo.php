<?php
    include __DIR__  . '/../../../config/conexao.php';

    if(isset($_POST['idCargo'])){
        $id = $_POST['idCargo'];
        // echo 'recebemos o id: ' .  $id;
        $sql = "DELETE FROM tbl_cargo where id_cargo = '$id'";
        if(mysqli_query($con, $sql)){
            $mensagem = "Cargo exluido com sucesso!";
            header('location: ../index.php?msg=Deletado com sucesso!');
        
        } else {
            $mensagem = "Não foi possivel excluir o cargo!";
        }

    }
?>


