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
    
    function consultaNivelAcessoPadrao($con, $idFuncionario) {
        $sql = "SELECT * FROM tbl_acesso_area WHERE id_funcionario = '$idFuncionario'";
        $consulta = mysqli_query($con, $sql);
        $array = mysqli_fetch_assoc($consulta);
        return $array;
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

    function entradasFrigobar ($con, $idFrigobar) {
        // tototal  frigobar
        $sqlEntradaFrigobar = "SELECT id_item, SUM(quantidade) as quantidade FROM tbl_entrada_item_frigobar WHERE id_frigobar = $idFrigobar";
        $consultaEntradaFrigobar = mysqli_query($con, $sqlEntradaFrigobar);
        $arrayEntradaFrigobar = mysqli_fetch_assoc($consultaEntradaFrigobar);
        return $arrayEntradaFrigobar;
    }

    function saidasFrigobar ($con, $idFrigobar) {
        // saidas frigobar
        $sqlConsumoFrigobar = "SELECT id_consumo_item_f, id_reserva, id_frigobar, id_item, SUM(quantidade) as quantidade FROM tbl_consumo_item_frigobar WHERE id_frigobar = $idFrigobar";
        $consultaConsumoFrigobar = mysqli_query($con, $sqlConsumoFrigobar);
        $arrayConsumoFrigobar = mysqli_fetch_assoc($consultaConsumoFrigobar);
        return $arrayConsumoFrigobar;
    }

    function totalItensFrigobar ($con, $idFrigobar) {
        // total item no frigobar
        $arrayFrigobar = entradasFrigobar($con, $idFrigobar);
        $quantidadeEntradaFrigobar = $arrayFrigobar['quantidade'];
        
        $arraySaidaFrigobar = saidasFrigobar($con, $idFrigobar);
        $quantidadeTotalSaidaFrigobar = $arraySaidaFrigobar['quantidade'];

        $totalItensFrigobar = $quantidadeEntradaFrigobar - $quantidadeTotalSaidaFrigobar;
        return $totalItensFrigobar;

    }

    function totalItensEspecificoFrigobar($con, $idItem, $idFrigobar) {
        $sql = 
            "SELECT 
                i.id_item,
                i.nome_item,
                i.preco_unit,
                COALESCE(e.total_entrada, 0) AS total_entrada,
                COALESCE(s.total_saida, 0) AS total_saida,
                (COALESCE(e.total_entrada, 0) - COALESCE(s.total_saida, 0)) AS total_disponivel

            FROM (
                SELECT 
                    id_item,
                    id_frigobar,
                    SUM(quantidade) AS total_entrada
                FROM tbl_entrada_item_frigobar
                WHERE id_frigobar = '$idFrigobar' AND id_item = '$idItem'
                GROUP BY id_item, id_frigobar
            ) AS e
            
            LEFT JOIN (
                SELECT 
                    id_item,
                    id_frigobar,
                    SUM(quantidade) AS total_saida
                FROM tbl_consumo_item_frigobar
                WHERE id_frigobar = '$idFrigobar' AND id_item = '$idItem'
                GROUP BY id_item, id_frigobar
            ) AS s 

            ON e.id_item = s.id_item AND e.id_frigobar = s.id_frigobar
            INNER JOIN tbl_item i 
            ON e.id_item = i.id_item
            WHERE e.id_frigobar = $idFrigobar AND e.id_item = '$idItem'
            HAVING total_disponivel > 0
        ";

        $consulta = mysqli_query($con, $sql);
        $array = mysqli_fetch_assoc($consulta);
        return $array;
    }

    function consultaInfoFrigobar($con, $idFrigobar, $idAcomodacao) {
        $sql = "SELECT * FROM tbl_frigobar WHERE (id_frigobar = $idFrigobar) OR (id_acomodacao = $idAcomodacao)";
        $consulta = mysqli_query($con, $sql);
        $array = mysqli_fetch_assoc($consulta);
        return $array;
    }

    // pesquisa na tabela de acomodacao pelo id tipo ou id da acomodação
    function consultaInfoAcomodacao ($con, $idTipoAcomodacao, $idAcomodacao) {
        $sql = "SELECT * FROM tbl_acomodacao WHERE (id_tp_acomodacao = $idTipoAcomodacao) OR (id_acomodacao = $idAcomodacao)";
        $consulta = mysqli_query($con, $sql);
        return $consulta;
    }

    // funções de consulta reservas na tabela reserva
    function consultaAcomodacaoDisponivel ($con, $idAcomodacao, $dataInicioFormatado, $dataFimFormatado) {
        $sqlAcomodacaoDisponivel = 
            "SELECT * FROM tbl_reserva 
            WHERE id_acomodacao = $idAcomodacao 
            AND ((dt_reserva_inicio <= '$dataFimFormatado' AND dt_reserva_fim >= '$dataInicioFormatado' ) 
            OR (dt_reserva_inicio >= '$dataFimFormatado' AND dt_reserva_fim <= '$dataInicioFormatado' )
            OR (dt_reserva_inicio <= '$dataInicioFormatado' AND dt_reserva_fim >= '$dataFimFormatado'))
        ";
                                    
        $acomodacaoDisponivel = mysqli_query($con, $sqlAcomodacaoDisponivel);
        return $acomodacaoDisponivel;
    }

    function consultaAcomodacaoReservada($con, $idAcomodacao, $dataFimFormatado, $dataInicioFormatado) {
        $sqlAcomodacaoReservada = 
            "SELECT * FROM tbl_reserva 
            WHERE id_acomodacao = $idAcomodacao 
            AND ((dt_reserva_inicio <= '$dataFimFormatado' AND dt_reserva_fim >= '$dataInicioFormatado') 
            OR (dt_reserva_inicio >= '$dataFimFormatado' AND dt_reserva_fim <= '$dataInicioFormatado')
            OR (dt_reserva_inicio <= '$dataInicioFormatado' AND dt_reserva_fim >= '$dataFimFormatado'))
        ";

        $acomodacaoReservada = mysqli_query($con, $sqlAcomodacaoReservada);
        return $acomodacaoReservada;
    }

    function consultaInfoCliente ($con, $idCliente, $cpfCliente) {
        $sql = "SELECT * FROM tbl_cliente WHERE (id_cliente = $idCliente) OR (cpf = $cpfCliente)";
        $consulta = mysqli_query($con, $sql);
        $array = mysqli_fetch_assoc($consulta);
        return $array;
    }
?>