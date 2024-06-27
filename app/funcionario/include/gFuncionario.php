<?php
    include __DIR__  . '/../../../config/conexao.php';

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        //enviou o formulario
        $nome = trim($_POST['nome']);
        $cpf = trim($_POST['cpf']);
        $telefone = trim($_POST['telefone']);
        $id_cargo = trim($_POST['id_cargo']);
        $senha = trim($_POST['cpf']);

        $hash = password_hash($senha,PASSWORD_DEFAULT);

         $sql = mysqli_prepare($con, "INSERT INTO tbl_funcionario (id_funcionario, nome, cpf, telefone, id_cargo, senha) VALUES (null, ?, ?, ?, ?, ?)");
         mysqli_stmt_bind_param($sql,"sssis",$nome,$cpf,$telefone,$id_cargo,$hash);
 
         if(mysqli_stmt_execute($sql)){
             header('location: ../index.php?msg=Adicionado com sucesso!');
         } else {
             echo "Error ao gravar" . mysqli_error($con);
         }
         mysqli_close($con);
    } else {
        $mensagem = "";
    }
?>