<?php
    $criterioSenha = '/^(?=.*[a-z])(?=.*[0-9])(?=.*[*!@#$%&])[A-Z][a-zA-Z0-9*!@#$%&]{7,15}$/';
    function verificaCriterioSenha($criterioSenha, $senha){

        if(preg_match($criterioSenha, $senha)){
            return true;
        }else{
            return false;
        }
    }
?>