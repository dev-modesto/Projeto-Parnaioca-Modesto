<?php

    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION['id'])){
        include $_SERVER['DOCUMENT_ROOT'] . 'Projeto-Parnaioca-Modesto/config/config.php';
        header('location: ' . BASE_URL . '/app/login/index.php');
        
        die();
        echo"
        <script>
            alert('Área restrita a usuários logados. Informe o seu Login e Senha.');
        </script>
        ";
    }

?>