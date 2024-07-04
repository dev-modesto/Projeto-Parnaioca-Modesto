<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $nomeStatus = trim($_POST['status']);
        
        $stmt = mysqli_prepare($con, "INSERT INTO tbl_status_geral (id_status, nome_status) VALUE (null, ?)");
        mysqli_stmt_bind_param($stmt, 's', $nomeStatus);
        
        if(mysqli_stmt_execute($stmt)){
            header('location: ../index.php?msg=Adicionado com sucesso!');
        } else {
            echo "Error ao gravar" . mysqli_error($con);
        }
    }

?>