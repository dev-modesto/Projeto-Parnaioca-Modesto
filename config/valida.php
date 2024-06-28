<?php
    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION['id'])){
        echo 'Voce precisa realizar o login!';
        header('location: ../../app/login/');
    }

?>