<?php
    include __DIR__  . '/../../../config/conexao.php';
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $idCargo = $_POST['idCargo'];
        $cargo = trim($_POST['cargo']);
        $salario = trim($_POST['salario']);
        $idSetor = trim($_POST['idSetor']);
        
        $sql = mysqli_prepare($con, "UPDATE tbl_cargo SET nome_cargo=?,salario=?,id_setor=? WHERE id_cargo = ?");
        mysqli_stmt_bind_param($sql, "sdii",$cargo,$salario,$idSetor, $idCargo);

        if(mysqli_stmt_execute($sql)){
            echo 'gravado com sucesso';
            $mensagem = "Cargo atualizado com sucesso!";
            header('location: ../index.php?msg=Atualizado com sucesso!');
        } else {
            echo "Erro ao gravar: " . mysqli_error($con);
        }

        mysqli_close($con);
    }

?>