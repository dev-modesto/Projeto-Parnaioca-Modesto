<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if(isset($_POST['setor'])){
        
        $setor = trim($_POST['setor']);
        $sql = "INSERT INTO tbl_setor(id_setor,nome_setor) VALUES(NULL,'$setor')";
        
        $stmt = mysqli_prepare($con, "INSERT INTO tbl_setor(id_setor, nome_setor) VALUES (NULL, ?)");
        mysqli_stmt_bind_param($stmt, "s", $setor);

        if(mysqli_stmt_execute($stmt)){
            header('location: ../index.php?msg=Adicionado com sucesso!');
        } else {
            echo "Error ao gravar" . mysqli_error($con);
        }

        mysqli_close($con);
    }

?>