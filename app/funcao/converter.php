<?php

    function converterMonetario($valor){
        $stringPesquisa = '/[,]/';
        $valorSemPonto = str_replace(".","",$valor);
        $valorSemVirgula = preg_replace($stringPesquisa,'.',$valorSemPonto);
        $valorSemVirgula = floatval($valorSemVirgula);
        return $valorSemVirgula;
    };

?>