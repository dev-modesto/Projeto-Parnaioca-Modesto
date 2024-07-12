<?php

    if (!defined('ARQUIVO_CONEXAO')) {
        include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
        include ARQUIVO_CONEXAO;
    }

    function nivelAcessoPadrao($con, $idFuncionario, $valorSac, $valorLog, $valorAdm){
        $sql = 
            "INSERT INTO tbl_acesso_area (
                id_funcionario, 
                sac, 
                logistica, 
                administracao) 
            VALUES (
                '$idFuncionario', 
                '$valorSac', 
                '$valorLog', 
                '$valorAdm')
        ";
        mysqli_query($con, $sql);
    }

    function excluirNivelAcessoPadrao($con, $idFuncionario){
        $sql = "DELETE FROM tbl_acesso_area WHERE id_funcionario = '$idFuncionario'";
        mysqli_query($con, $sql);
    }
    
    function logOperacao ($con, $idFuncionario, $nomeTbl, $idRegistro, $tpOperacao, $descricao){

        $stmt = 
                mysqli_prepare($con, 
                "INSERT INTO tbl_log_operacao (
                id_funcionario, 
                nome_tbl, 
                id_registro, 
                tp_operacao, 
                descricao) 
                VALUES (?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param($stmt, 'isiss', $idFuncionario, $nomeTbl, $idRegistro, $tpOperacao, $descricao);
        mysqli_stmt_execute($stmt);

    }

?>