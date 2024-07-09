<?php
    $pastaProjeto = '/Projeto-Parnaioca-Modesto';

    // Pastas
    define('PASTA_CONFIG', $_SERVER['DOCUMENT_ROOT'] . $pastaProjeto . '/config');

    // Arquivos
    define('ARQUIVO_CONEXAO', PASTA_CONFIG . '/conexao.php');
    define('ARQUIVO_SEGURANCA', PASTA_CONFIG . '/seguranca.php');
    define('ARQUIVO_NAVBAR', $_SERVER['DOCUMENT_ROOT'] . $pastaProjeto . '/include/navbar/navbar.php');
    define('BASE_URL', '/Projeto-Parnaioca-Modesto');
    define('ARQUIVO_FOOTER', $_SERVER['DOCUMENT_ROOT'] . $pastaProjeto . '/include/footer.php');
    define('ARQUIVO_FUNCAO_SQL', $_SERVER['DOCUMENT_ROOT'] . $pastaProjeto . '/app/funcao/funcaoSql.php');    

    // if (file_exists(ARQUIVO_CONEXAO)) {
    //     echo "arquivo de conexao existe";
    // } else {
    //     echo 'arquivo de conexao nao encontrado';
    // }


?>