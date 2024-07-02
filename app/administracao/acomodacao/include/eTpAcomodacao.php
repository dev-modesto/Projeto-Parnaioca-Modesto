<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if(isset($_POST['idTpAcomodacao'])) {
        $id = $_POST['idTpAcomodacao'];
        $sql = "DELETE FROM tbl_tp_acomodacao WHERE id_tp_acomodacao = '$id'";
        if(mysqli_query($con, $sql)){
            header('location: ../index.php?msg=Deletado com sucesso!');
        
        } else {
            $mensagem = "Não foi possivel excluir a acomodação!";
        }
        
    }

?>