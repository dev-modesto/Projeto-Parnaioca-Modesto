<?php
    include '../../../config/conexao.php';

    $nome = trim($_POST['nome']);
    $cpf = trim($_POST['cpf']);
    $telefone = trim($_POST['telefone']);
    $id_cargo = trim($_POST['id_cargo']);
    $senha = trim($_POST['cpf']);

    // $hash = password_hash($senhaNoHash,PASSWORD_DEFAULT);

    $sql = "INSERT INTO tbl_funcionario
        (id_funcionario,nome,cpf,telefone,id_cargo,senha) 
        VALUES (null,'$nome','$cpf','$telefone','$id_cargo','$senha')";

    if(mysqli_query($con, $sql)){
        echo "Gravado com sucesso!";
    } else {
        echo "Erro ao gravar: " . mysqli_error($con);
    }

    mysqli_close($con);
?>