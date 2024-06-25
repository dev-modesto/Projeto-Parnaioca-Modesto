<?php
    include __DIR__  . '/../../../config/conexao.php';
    

    if($_GET['id']){
        echo 'clicamoes e recebemos algo';
        $id = $_GET['id'];
    }else{
        echo 'nada';
    };

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        echo "tentativa de post realizada";

        // die;
        $nome = trim($_POST['nome']);
        $cpf = trim($_POST['cpf']);
        $telefone = trim($_POST['telefone']);
        $id_cargo = trim($_POST['id_cargo']);
    
        echo "<pre>";
        echo $nome . "\n";
        echo $cpf . "\n";
        echo $telefone . "\n";
        echo $id_cargo . "\n";
        echo $id;
        // die;
        $query = "UPDATE tbl_funcionario SET nome='$nome',cpf='$cpf',telefone='$telefone',id_cargo='$id_cargo' WHERE id_funcionario = '$id'";
        
        if($executeUpdate = mysqli_query($con, $query)){
            $mensagem = "Usuario atualizado com sucesso!";
            echo "Atualizado com sucesso!";
            header('location: ../index.php?msg=Atualizado com sucesso!');
        }else {
            echo "Erro ao gravar: " . mysqli_error($con);
        };

    }

?>