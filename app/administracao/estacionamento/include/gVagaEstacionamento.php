<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $idNumeroAcomodacao = $_POST['id-numero-acomodacao'];
        $numeroVagaEstacionamento = trim($_POST['numero-vaga-estacionamento']);

        mysqli_begin_transaction($con);

        try {

            $stmt = 
                mysqli_prepare(
                $con, 
                "INSERT INTO 
                    tbl_estacionamento(
                    id_estacionamento, 
                    id_acomodacao, 
                    numero_vaga) 
                VALUES 
                    (NULL, ?, ?)
            ");
            
            mysqli_stmt_bind_param($stmt, "is", $idNumeroAcomodacao, $numeroVagaEstacionamento);

            mysqli_stmt_execute($stmt);
            
            // log operações
                $nomeTabela = 'tbl_estacionamento';
                $idRegistro = mysqli_insert_id($con);
                $tpOperacao = 'insercao';
                $descricao = 'Vaga estacionamento adicionada ID: ' . $idRegistro;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 

            mysqli_commit($con);
            header('location: ../index.php?msg=Adicionado com sucesso!');

        } catch (Exception $e) {
            mysqli_rollback($con);
            $mensagem = "Ocorreu um erro. Não foi possível realizar a operação.";
            header('location: ../index.php?msgInvalida=' . $mensagem);

        } finally {
            mysqli_close($con);
        }
    }

?>