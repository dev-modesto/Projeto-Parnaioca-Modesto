<?php
include '../../../config/conexao.php';

$nome = $_POST['nome'];
$salario = $_POST['salario'];
$id_setor = $_POST['id_setor'];

$sql = "INSERT INTO tbl_cargo(nome_cargo, salario, id_setor) VALUES('$nome', '$salario', '$id_setor')";

    if(mysqli_query($con, $sql)){
        echo "Gravado com sucesso!";
    } else {
        echo "Erro ao gravar: " . mysqli_error($con);
    }

    mysqli_close($con);
?>
