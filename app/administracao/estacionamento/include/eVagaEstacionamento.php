<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if(isset($_POST['idVagaEstacionamento'])){
        $id = $_POST['idVagaEstacionamento'];
        // echo 'recebemos o id: ' .  $id;
        // die();
        $sql = "DELETE FROM tbl_estacionamento where id_estacionamento = '$id'";
        if(mysqli_query($con, $sql)){
            // log operações
                $nomeTabela = 'tbl_estacionamento';
                $idRegistro = $id;
                $tpOperacao = 'exclusao';
                $descricao = 'Vaga estacionamento excluída ID: ' . $idRegistro;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            $mensagem = "Vaga exluida com sucesso!";
            header('location: ../index.php?msg=Deletado com sucesso!');
        
        } else {
            $mensagem = "Não foi possivel excluir a vaga!";
        }

    }

?>