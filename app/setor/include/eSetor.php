<?php
    include __DIR__  . '/../../../config/conexao.php';

    if(isset($_GET['id'])){
        
        $id = $_GET['id'];
        $stmt = mysqli_prepare($con, "DELETE FROM tbl_setor WHERE id_setor = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id);

        if(mysqli_stmt_execute($stmt)){
            echo 'executado com sucesso!!';
            header('location: ../index.php?msg=Removido com sucesso!');
        } else {
            echo "ocorreu um error". mysqli_error($con);
        }
        mysqli_close($con);

    } 

?>