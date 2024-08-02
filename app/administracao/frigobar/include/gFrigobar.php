<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $idNumeroAcomodacao = $_POST['id-acomodacao'];
        $nomeFrigobar = $_POST['nome-frigobar'];
        $capacidade = $_POST['capacidade'];

        mysqli_begin_transaction($con);

        try {

            $stmt = 
                mysqli_prepare(
                $con, 
                "INSERT INTO tbl_frigobar(
                    id_frigobar, 
                    id_acomodacao, 
                    nome_frigobar, 
                    capacidade_itens) 
                VALUES 
                    (NULL, ?, ?, ?)
            ");
            
            mysqli_stmt_bind_param($stmt, "isi", $idNumeroAcomodacao, $nomeFrigobar, $capacidade);

            mysqli_stmt_execute($stmt);

            // log operações
                $nomeTabela = 'tbl_frigobar';
                $idRegistro = mysqli_insert_id($con);
                $tpOperacao = 'insercao';
                $descricao = 'Frigobar adicionado ID: ' . $idRegistro;
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
        
    } else {
        $mensagem = "";
    }

?>