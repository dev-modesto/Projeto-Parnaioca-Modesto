<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if(isset($_POST['id-cliente'])){
        $id = $_POST['id-cliente'];

        $sql = "DELETE FROM tbl_cliente where id_cliente = '$id'";
        if(mysqli_query($con, $sql)){

            // log operações
                $nomeTabela = 'tbl_cliente';
                $idRegistro = $id;
                $tpOperacao = 'exclusao';
                $descricao = 'Cliente excluído ID: ' . $id;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 

            $mensagem = "Cliente exluido com sucesso!";
            header('location: ../index.php?msg=Deletado com sucesso!');
        
        } else {
            $mensagem = "Não foi possivel excluir o cliente!";
        }

    }
?>
