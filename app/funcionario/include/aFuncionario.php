<?php
    include __DIR__  . '/../../../config/conexao.php';
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $id = $_POST['id-funcionario'];
        $nome = trim($_POST['nome']);
        $cpf = trim($_POST['cpf']);
        $telefone = trim($_POST['telefone']);
        $id_cargo = trim($_POST['id_cargo']);
        
        $query = "UPDATE tbl_funcionario SET nome='$nome',cpf='$cpf',telefone='$telefone',id_cargo='$id_cargo' WHERE id_funcionario = '$id'";
        
        if($executeUpdate = mysqli_query($con, $query)){
            $mensagem = "Usuario atualizado com sucesso!";
            header('location: ../index.php?msg=Atualizado com sucesso!');
        }else {
            echo "Erro ao gravar: " . mysqli_error($con);
        };

        mysqli_close($con);

    }

?>