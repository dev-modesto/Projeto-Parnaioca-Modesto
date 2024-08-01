<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if(isset($_POST['setor'])){
        
        $nomeSetor = trim($_POST['setor']);

        $sqlVerifica = mysqli_prepare($con, "SELECT * FROM tbl_setor WHERE nome_setor = ? ");
        mysqli_stmt_bind_param($sqlVerifica, "s", $nomeSetor);
        mysqli_stmt_execute($sqlVerifica);
        $result = mysqli_stmt_get_result($sqlVerifica);

        if (mysqli_num_rows($result) > 0) {
            $mensagem = "Este setor já foi cadastrado.";
            header('location: ../index.php?msgInvalida=' . $mensagem);
            die();
        } 

        mysqli_begin_transaction($con);

        try {

            $stmt = mysqli_prepare($con, "INSERT INTO tbl_setor(id_setor, nome_setor) VALUES (NULL, ?)");
            mysqli_stmt_bind_param($stmt, "s", $nomeSetor);

            mysqli_stmt_execute($stmt);

            // log operações
                $nomeTabela = 'tbl_setor';
                $idRegistro = mysqli_insert_id($con);
                $tpOperacao = 'insercao';
                $descricao = 'Setor adicionado ID: ' . $idRegistro;
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