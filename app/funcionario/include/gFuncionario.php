<?php
    include '../../../config/conexao.php';

    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $id_cargo = $_POST['id_cargo'];
    $senha = $_POST['senha']

    $hash = password_hash($senha,PASSWORD_DEFAULT);

    $sql = "INSERT INTO tbl_funcionario
        (id_funcionario,nome,cpf,telefone,id_cargo,senha) 
        VALUES ('$nome','$cpf','$telefone','$id_cargo','$hash')";

    if(mysqli_query($con, $sql)){
        echo "Gravado com sucesso!";
    } else {
        echo "Erro ao gravar: " . mysqli_error($con);
    }

    mysqli_close($con);
?>