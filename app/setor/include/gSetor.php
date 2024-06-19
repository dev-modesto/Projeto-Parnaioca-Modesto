<?php
    include '../../../config/conexao.php';

    $setor = $_POST['setor'];
    $sql = "INSERT INTO tbl_setor(id_setor,nome_setor) VALUES(NULL,'$setor')";

    if(mysqli_query($con, $sql)){
        echo "gravado com sucesso!";
    }else {
        echo "erro ao gravar";
    }
    mysqli_close($con);
?>