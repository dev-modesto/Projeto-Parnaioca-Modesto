<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if(isset($_POST['idSetor'])){
        $id = $_POST['idSetor'];
        // echo 'recebemos o id: ' .  $id;
        $sql = "DELETE FROM tbl_setor where id_setor = '$id'";
        if(mysqli_query($con, $sql)){
            // log operações
                $nomeTabela = 'tbl_setor';
                $idRegistro = $id;
                $tpOperacao = 'exclusao';
                $descricao = 'Setor excluído ID: ' . $idRegistro;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            $mensagem = "Setor exluido com sucesso!";
            header('location: ../index.php?msg=Deletado com sucesso!');
        
        } else {
            $mensagem = "Não foi possivel excluir o setor!";
        }

    }

?>