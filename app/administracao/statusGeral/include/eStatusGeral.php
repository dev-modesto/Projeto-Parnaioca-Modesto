<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if(isset($_POST['idStatusGeral'])) {
        $id = $_POST['idStatusGeral'];
        echo 'Identificacao' . $id;

        $sql = "DELETE FROM tbl_status_geral WHERE id_status = '$id'";

        if(mysqli_query($con, $sql)){
            $mensagem = "status exluido com sucesso!";
            header('location: ../index.php?msg=Deletado com sucesso!');
        } else {
            $mensagem = "Não foi possivel excluir o setor!";
        }

    }

?>
