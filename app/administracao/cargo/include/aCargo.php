<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include './../../../funcao/converter.php';
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $idCargo = $_POST['idCargo'];
        $cargo = trim($_POST['cargo']);
        $salario = trim($_POST['salario']);
        $idSetor = trim($_POST['idSetor']);
        $salarioConvertido = converterMonetario($salario);

        mysqli_begin_transaction($con);

        try {
        
            $sql = mysqli_prepare(
                $con, 
                "UPDATE tbl_cargo 
                SET 
                    nome_cargo=?,
                    salario=?,
                    id_setor=? 
                WHERE id_cargo = ?
            ");
            
            mysqli_stmt_bind_param($sql, "sdii",$cargo,$salarioConvertido,$idSetor, $idCargo);

            mysqli_stmt_execute($sql);

            // log operações
                $nomeTabela = 'tbl_cargo';
                $idRegistro = $idCargo;
                $tpOperacao = 'atualizacao';
                $descricao = 'Cargo atualizado ID: ' . $idRegistro;
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
    }

?>