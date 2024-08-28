<?php

function cFuncionario($con, $idFuncionario) {
    $sql = 
        "SELECT 
            f.id_funcionario,
            f.nome,
            c.nome_cargo 
        FROM tbl_funcionario f 
        INNER JOIN tbl_cargo c 
        ON f.id_cargo = c.id_cargo 
        WHERE id_funcionario = '$idFuncionario'
    ";
    $consulta = mysqli_query($con, $sql);
    return $consulta;
}

function cFuncionarioAcessoArea($con, $idFuncionario) {
    $sql = "SELECT * FROM tbl_acesso_area WHERE id_funcionario = '$idFuncionario'";
    $consulta = mysqli_query($con, $sql);
    return $consulta;
}

?>