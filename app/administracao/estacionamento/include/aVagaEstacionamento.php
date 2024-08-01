<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST['id'];
        $idAcomodacao = $_POST['id-numero-acomodacao'];
        $numeroVaga = trim($_POST['numero-vaga-estacionamento']);

        mysqli_begin_transaction($con);

        try {

            $stmt = 
                mysqli_prepare(
                $con, 
                "UPDATE tbl_estacionamento 
                SET id_acomodacao = ?, numero_vaga = ? 
                WHERE id_estacionamento = '$id'"
            );
            
            mysqli_stmt_bind_param($stmt, 'is', $idAcomodacao, $numeroVaga);

            mysqli_stmt_execute($stmt);

            // log operações
                $nomeTabela = 'tbl_estacionamento';
                $idRegistro = $id;
                $tpOperacao = 'atualizacao';
                $descricao = 'Vaga estacionamento atualizada ID: ' . $idRegistro;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 

            mysqli_commit($con);
            header('location: ../index.php?msg=Alterado com sucesso!');

        } catch (Exception $e) {
            mysqli_rollback($con);
            $mensagem = "Ocorreu um erro. Não foi possível realizar a operação.";
            header('location: ../index.php?msgInvalida=' . $mensagem);

        } finally {
            mysqli_close($con);
        }
    }

?>