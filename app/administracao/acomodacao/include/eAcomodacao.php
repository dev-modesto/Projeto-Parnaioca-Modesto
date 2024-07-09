<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if(isset($_POST['idAcomodacao'])){
        $idAcomodacao = $_POST['idAcomodacao'];
        $sql = "DELETE FROM tbl_acomodacao WHERE id_acomodacao = $idAcomodacao";

        if(mysqli_query($con, $sql)) {
            // log operações
                $nomeTabela = 'tbl_acomodacao';
                $idRegistro = $idAcomodacao;
                $tpOperacao = 'exclusao';
                $descricao = 'Acomodação excluída ID: ' . $idRegistro;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 

            $mensagem = "Deletado com sucesso!";
            header("location: ./../index.php?msg=Deletado com sucesso!");
        } else {
            $mensagem = "Não foi possivel excluir a acomodação.";
        }
    }
?>