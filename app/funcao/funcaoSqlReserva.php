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

?>

