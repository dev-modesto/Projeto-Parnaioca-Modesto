<?php
    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION['id'])){
        // echo 'Voce precisa realizar o login!';
        echo"
        <script>
            alert('Área restrita a usuários logados. Informe o seu Login e Senha.');
            window.location = '../../app/login/';
        </script>
    ";
        header('location: ../../app/login/');
    }

?>