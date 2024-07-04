<?php

    $local = 'localhost';
    $usuario = 'root';
    $senha = '';
    $banco = 'parnaiocamodesto';
    // echo 'conexao estabelecida com sucesso!';
    $con = mysqli_connect($local,$usuario,$senha,$banco);

    header("Content-Type:text/html; charset=utf-8");
    mysqli_query($con,"SET NAMES 'utf8'");
    mysqli_query($con,"SET character_set_connection = utf8");
    mysqli_query($con,"SET character_set_client = utf8");
    mysqli_query($con,"SET character_set_results = utf8");

?>