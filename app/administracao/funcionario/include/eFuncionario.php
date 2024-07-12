<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if(isset($_POST['idFuncionario'])){
        $id = $_POST['idFuncionario'];
        // echo 'recebemos o id: ' .  $id;
        excluirNivelAcessoPadrao($con, $id);
        $sql = "DELETE FROM tbl_funcionario where id_funcionario = '$id'";

        if(mysqli_query($con, $sql)){
            
            // log operações
                $nomeTabela = 'tbl_funcionario';
                $idRegistro = $id;
                $tpOperacao = 'exclusao';
                $descricao = 'Funcionário excluído ID: ' . $id;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            
            $mensagem = "Funcionário exluido com sucesso!";
            header('location: ../index.php?msg=Deletado com sucesso!');
        
        } else {
            $mensagem = "Não foi possivel excluir o funcionário!";
        }

    }
?>
