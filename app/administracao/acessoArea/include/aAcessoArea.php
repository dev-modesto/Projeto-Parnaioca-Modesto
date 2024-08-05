<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $idFuncionario = $_POST['id-funcionario'];

        $sac = isset($_POST['sac']) ? $_POST['sac'] : 0;
        $logistica = isset($_POST['logistica']) ? $_POST['logistica'] : 0;
        $administracao = isset($_POST['administracao']) ? $_POST['administracao'] : 0;

        $nivelAcessoLogado = verificaNivelAcesso($con, $idLogado);
        $nivelLogado = $nivelAcessoLogado['nivel_acesso'];
        $idFuncionarioNivelLogado = $nivelAcessoLogado['id_funcionario'];

        $nivelAcessoFuncionarioAtualizar = verificaNivelAcesso($con, $idFuncionario);
        $nivelFuncionarioAtualizar = $nivelAcessoFuncionarioAtualizar['nivel_acesso'];

        if ($nivelFuncionarioAtualizar > 0 && $nivelLogado == 0) {
            $mensagem = "Você não possui autorização para atualizar as informações deste funcionário.";
            header('location: ../index.php?msgInvalida=' . $mensagem);
            die();
        } 

        mysqli_begin_transaction($con);

        try {

            $sql = 
                "UPDATE tbl_acesso_area 
                SET 
                    sac = $sac, 
                    logistica = $logistica, 
                    administracao = $administracao 
                WHERE id_funcionario = $idFuncionario
            ";

            mysqli_query($con, $sql);
                            
            // log operações
                $nomeTabela = 'tbl_acesso_area';
                $idRegistro = $idLogado;
                $tpOperacao = 'atualizacao';
                $descricao = 'Funcionário atualizado ID: ' . $idFuncionario;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 

            mysqli_commit($con);
            header('location: ../index.php?msg=Atualizado com sucesso!');

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