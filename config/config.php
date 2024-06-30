<?php
    $pastaProjeto = '/Projeto-Parnaioca-Modesto';

    // Pastas
    define('PASTA_CONFIG', $_SERVER['DOCUMENT_ROOT'] . $pastaProjeto . '/config');

    // Arquivos
    define('ARQUIVO_CONEXAO', PASTA_CONFIG . '/conexao.php');
    define('ARQUIVO_SEGURANCA', PASTA_CONFIG . '/seguranca.php');
    define('ARQUIVO_NAVBAR', $_SERVER['DOCUMENT_ROOT'] . $pastaProjeto . '/include/navbar/navbar.php');

    // if (file_exists(ARQUIVO_CONEXAO)) {
    //     echo "arquivo de conexao existe";
    // } else {
    //     echo 'arquivo de conexao nao encontrado';
    // }


?>