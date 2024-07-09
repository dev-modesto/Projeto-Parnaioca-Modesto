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
        
        $sql = mysqli_prepare($con, "UPDATE tbl_cargo SET nome_cargo=?,salario=?,id_setor=? WHERE id_cargo = ?");
        mysqli_stmt_bind_param($sql, "sdii",$cargo,$salarioConvertido,$idSetor, $idCargo);

        if(mysqli_stmt_execute($sql)){
            // log operações
                $nomeTabela = 'tbl_cargo';
                $idRegistro = $idCargo;
                $tpOperacao = 'atualizacao';
                $descricao = 'Cargo atualizado ID: ' . $idRegistro;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            $mensagem = "Cargo atualizado com sucesso!";
            header('location: ../index.php?msg=Atualizado com sucesso!');
        } else {
            echo "Erro ao gravar: " . mysqli_error($con);
        }

        mysqli_close($con);
    }

?>