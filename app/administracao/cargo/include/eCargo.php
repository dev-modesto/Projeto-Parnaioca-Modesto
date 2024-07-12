<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if(isset($_POST['idCargo'])){
        $id = $_POST['idCargo'];
        // echo 'recebemos o id: ' .  $id;
        $sql = "DELETE FROM tbl_cargo where id_cargo = '$id'";
        if(mysqli_query($con, $sql)){
            // log operações
                $nomeTabela = 'tbl_cargo';
                $idRegistro = $id;
                $tpOperacao = 'exclusao';
                $descricao = 'Cargo excluído ID: ' . $idRegistro;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            $mensagem = "Cargo exluido com sucesso!";
            header('location: ../index.php?msg=Deletado com sucesso!');
        
        } else {
            $mensagem = "Não foi possivel excluir o cargo!";
        }

    }
?>


