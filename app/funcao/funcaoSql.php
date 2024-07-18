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

    function infoItemArray ($con, $idItem) {
        // informacoes do item
        $sqlInfoItem = "SELECT * FROM tbl_item WHERE id_item = $idItem";
        $consultaInfoItem = mysqli_query($con, $sqlInfoItem);
        $arrayInfoItem = mysqli_fetch_assoc($consultaInfoItem);
        return $arrayInfoItem;
    }

    function totalEntradasEstoque ($con, $idItem) {
        // entradas
        $sqlEntrada = "SELECT id_item, id_sku, SUM(quantidade) FROM tbl_entrada_item_estoque where id_item = $idItem";
        $consultaEntradaItem = mysqli_query($con, $sqlEntrada);
        $arrayItem = mysqli_fetch_assoc($consultaEntradaItem);
        $totalEntrada = $arrayItem['SUM(quantidade)'] . "\n";
        return $totalEntrada;
    }

    function entradasEstoqueArray ($con, $idItem) {
        // entradas
        $sqlEntrada = "SELECT id_item, id_sku, SUM(quantidade) FROM tbl_entrada_item_estoque where id_item = $idItem";
        $consultaEntradaItem = mysqli_query($con, $sqlEntrada);
        $arrayItem = mysqli_fetch_assoc($consultaEntradaItem);
        return $arrayItem;

    }

    function totalSaidasEstoque ($con, $idItem) {
        // saidas
        $sqlSaida = "SELECT id_item, SUM(quantidade) FROM tbl_saida_item_estoque where id_item = $idItem";
        $consultaSaidaItem = mysqli_query($con, $sqlSaida);
        $arraySaidaItem = mysqli_fetch_assoc($consultaSaidaItem);
        $totalSaida = $arraySaidaItem['SUM(quantidade)'];
        return $totalSaida;
    }
    
?>