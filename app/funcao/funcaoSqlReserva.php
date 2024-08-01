<?php

    function totalStatusReservaAtual($con, $dataAtual ,$valorIdStatus) {
        $sql = 
            "SELECT count(id_reserva) as total 
            FROM tbl_reserva 
            WHERE (dt_reserva_inicio <= '$dataAtual 23:59:59' AND dt_reserva_fim >= '$dataAtual 00:00:00')
            AND id_status_reserva = '$valorIdStatus'";
        $consulta = mysqli_query($con, $sql);
        $array = mysqli_fetch_assoc($consulta);
        return $array['total'];
    }

    function totalStatusReservaFiltro($con, $dataInicio, $dataFinal, $valorIdStatus) {
        $sql = 
            "SELECT count(id_reserva) as total 
            FROM tbl_reserva 
            WHERE ((dt_reserva_inicio <= '$dataFinal 23:59:59' and dt_reserva_fim >= '$dataInicio 00:00:00')
            OR (dt_reserva_inicio >= '$dataInicio 00:00:00' AND dt_reserva_fim <= '$dataFinal 23:59:00'))
            AND id_status_reserva = '$valorIdStatus'";
        $consulta = mysqli_query($con, $sql);
        $array = mysqli_fetch_assoc($consulta);
        return $array['total'];
    }

    function consultaInfoReserva($con, $idReserva) {
        $sql = 
            mysqli_prepare($con, "SELECT * FROM tbl_reserva WHERE id_reserva = ? ");
            mysqli_stmt_bind_param($sql, 'i', $idReserva);
            mysqli_stmt_execute($sql);
        $consulta = mysqli_stmt_get_result($sql);
        $array = mysqli_fetch_assoc($consulta);
        return $array;
    }

    function consultaInfoPagamentoReserva($con, $idReserva) {
        $sql = 
            mysqli_prepare($con, "SELECT * FROM tbl_pagamento WHERE id_reserva = ? ");
            mysqli_stmt_bind_param($sql, 'i', $idReserva);
            mysqli_stmt_execute($sql);
        $consulta = mysqli_stmt_get_result($sql);
        $array = mysqli_fetch_all($consulta, MYSQLI_ASSOC);
        return $array;
    }

    function consultaTotalPagamentoReserva($con, $idReserva) {
        $sql = 
            mysqli_prepare($con, "SELECT COALESCE(SUM(valor), 0) as valor_total FROM tbl_pagamento WHERE id_reserva = ? ");
            mysqli_stmt_bind_param($sql, 'i', $idReserva);
            mysqli_stmt_execute($sql);
        $consulta = mysqli_stmt_get_result($sql);
        $array = mysqli_fetch_assoc($consulta);
        return $array;
    }

    function consultaConsumoReserva ($con, $idReserva) {
        $sql = 
            mysqli_prepare($con, 
            "SELECT 
                r.id_reserva, 
                r.id_frigobar, 
                r.id_item,
                i.nome_item,
                SUM(r.quantidade) AS total_quantidade,
                r.preco_unit,
                SUM(r.valor_total) AS total_consumido
            FROM tbl_consumo_item_frigobar r 
            INNER JOIN tbl_item i
            ON r.id_item = i.id_item 
            WHERE id_reserva = ? 
        ");
            mysqli_stmt_bind_param($sql, 'i', $idReserva);
            mysqli_stmt_execute($sql);
        $consulta = mysqli_stmt_get_result($sql);
        return $consulta;
    }

    function consultaTotalConsumoReserva ($con, $idReserva) {
        $sql = 
            mysqli_prepare($con, "SELECT SUM(quantidade) AS quantidade, SUM(valor_total) AS total_consumo FROM tbl_consumo_item_frigobar WHERE id_reserva = ? ");
            mysqli_stmt_bind_param($sql, 'i', $idReserva);
            mysqli_stmt_execute($sql);
        $consulta = mysqli_stmt_get_result($sql);
        $array = mysqli_fetch_assoc($consulta);
        return $array;
    }

?>

