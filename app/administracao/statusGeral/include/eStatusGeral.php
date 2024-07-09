<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if(isset($_POST['idStatusGeral'])) {
        $id = $_POST['idStatusGeral'];
        echo 'Identificacao' . $id;

        $sql = "DELETE FROM tbl_status_geral WHERE id_status = '$id'";

        if(mysqli_query($con, $sql)){
            // log operações
                $nomeTabela = 'tbl_status_geral';
                $idRegistro = $id;
                $tpOperacao = 'exclusao';
                $descricao = 'Status geral excluído ID: ' . $idRegistro;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            $mensagem = "status exluido com sucesso!";
            header('location: ../index.php?msg=Deletado com sucesso!');
        } else {
            $mensagem = "Não foi possivel excluir o setor!";
        }

    }

?>
