<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if(isset($_POST['idTpAcomodacao'])) {
        $id = $_POST['idTpAcomodacao'];
        $sql = "DELETE FROM tbl_tp_acomodacao WHERE id_tp_acomodacao = '$id'";
        if(mysqli_query($con, $sql)){
            // log operações
                $nomeTabela = 'tbl_tp_acomodacao';
                $idRegistro = $id;
                $tpOperacao = 'exclusao';
                $descricao = 'Tipo acomodação excluída ID: ' . $idRegistro;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            header('location: ../index.php?msg=Deletado com sucesso!');
        
        } else {
            $mensagem = "Não foi possivel excluir a acomodação!";
        }
        
    }

?>