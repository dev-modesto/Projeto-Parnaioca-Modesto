<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if(isset($_POST['setor'])){
        $id = $_POST['id'];
        $nomeSetor = $_POST['setor'];

        $stmt = mysqli_prepare($con, "UPDATE tbl_setor SET nome_setor = ? WHERE id_setor = ? ");
        mysqli_stmt_bind_param($stmt, 'si', $nomeSetor, $id);

        if(mysqli_stmt_execute($stmt)){
            header('location: ../index.php?msg=Alterado com sucesso!');
        } else {
            echo "Error ao gravar" . mysqli_error($con);
        }
    }

?>