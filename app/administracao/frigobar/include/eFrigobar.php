<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if(isset($_POST['id-frigobar'])){
        $id = $_POST['id-frigobar'];
        $sql = "DELETE FROM tbl_frigobar where id_frigobar = '$id'";

        if(mysqli_query($con, $sql)){
            // log operações
                $nomeTabela = 'tbl_frigobar';
                $idRegistro = $id;
                $tpOperacao = 'exclusao';
                $descricao = 'Frigobar excluído ID: ' . $idRegistro;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            $mensagem = "Frigobar exluido com sucesso!";
            header('location: ../index.php?msg=Deletado com sucesso!');
        
        } else {
            $mensagem = "Não foi possivel excluir.";
        }

    }

?>