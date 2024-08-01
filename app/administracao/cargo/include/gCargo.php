<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include './../../../funcao/converter.php';
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if(isset($_POST['cargo'])){
        
        mysqli_begin_transaction($con);
        
        try {

            $cargo = trim($_POST['cargo']);
            $salario = trim($_POST['salario']);
            $idSetor = $_POST['idSetor'];
            $salarioConvertido = converterMonetario($salario);

            $stmt = mysqli_prepare(
                $con, 
                "INSERT INTO tbl_cargo(
                    id_cargo, 
                    nome_cargo, 
                    salario, 
                    id_setor) 
                VALUES (NULL, ?, ?, ?)
            ");

            mysqli_stmt_bind_param($stmt, 'sdi',$cargo,$salarioConvertido,$idSetor);

            mysqli_stmt_execute($stmt);
        
            // log operações
                $nomeTabela = 'tbl_cargo';
                $idRegistro = mysqli_insert_id($con);
                $tpOperacao = 'insercao';
                $descricao = 'Cargo adicionado ID: ' . $idRegistro;
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
