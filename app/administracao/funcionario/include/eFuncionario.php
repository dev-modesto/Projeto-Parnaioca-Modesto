<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if(isset($_POST['idFuncionario'])){
        $idFuncionario = $_POST['idFuncionario'];
        $nivelAcessoLogado = verificaNivelAcesso($con, $idLogado);
        $nivelLogado = $nivelAcessoLogado['nivel_acesso'];
        $idFuncionarioNivelLogado = $nivelAcessoLogado['id_funcionario'];

        $nivelAcessoFuncionarioExcluir = verificaNivelAcesso($con, $idFuncionario);
        $nivelFuncionarioExcluir = $nivelAcessoFuncionarioExcluir['nivel_acesso'];

        if ($nivelFuncionarioExcluir > 0 && $nivelLogado == 0) {
            $mensagem = "Não é possível excluir este funcionário.";
            header('location: ../index.php?msgInvalida=' . $mensagem);
            die();
        } 

        if ($nivelLogado > 0 && $idLogado == $idFuncionario ) {
            $sql = "SELECT * FROM tbl_nivel_acesso WHERE nivel_acesso > 0";
            $consulta = mysqli_query($con, $sql);

            if(mysqli_num_rows($consulta) > 1) {
            } else {
                $mensagem = "Você é o único administrador do sistema. Atribua outro administrador para poder executar esta operação.";
                header('location: ../index.php?msgInvalida=' . $mensagem);
                die();
            }
        }

        mysqli_begin_transaction($con);

        try {

            excluirAcessoArea($con, $idFuncionario);
            excluirNivelAcesso($con, $idFuncionario);

            $sql = "DELETE FROM tbl_funcionario where id_funcionario = '$idFuncionario'";

            mysqli_query($con, $sql);
                
            // log operações
                $nomeTabela = 'tbl_funcionario';
                $idRegistro = $idFuncionario;
                $tpOperacao = 'exclusao';
                $descricao = 'Funcionário excluído ID: ' . $idFuncionario;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            
            mysqli_commit($con);
            $mensagem = "Funcionário exluido com sucesso!";
            header('location: ../index.php?msg=' . $mensagem);

        } catch (Exception $e) {
            mysqli_rollback($con);
            $mensagem = "Ocorreu um erro. Não foi possível realizar a operação.";
            header('location: ../index.php?msgInvalida=' . $mensagem);

        } finally {
            mysqli_close($con);
        }

    } else {
        $mensagem = "";
    }
?>
