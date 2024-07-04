<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if(isset($_POST['idAcomodacao'])){
        $idAcomodacao = $_POST['idAcomodacao'];
        $sql = "DELETE FROM tbl_acomodacao WHERE id_acomodacao = $idAcomodacao";

        if(mysqli_query($con, $sql)) {
            $mensagem = "Deletado com sucesso!";
            header("location: ./../index.php?msg=Deletado com sucesso!");
        } else {
            $mensagem = "Não foi possivel excluir a acomodação.";
        }
    }
?>