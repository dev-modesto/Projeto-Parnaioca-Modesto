<?php

    function diaSemanaPtbr($diaSemanaIngles){
        switch ($diaSemanaIngles) {
            case 'Monday':
                return "Segunda-feira";
            case 'Tuesday':
                return "Terça-feira";
            case 'Wednesday':
                return "Quarta-feira";
            case 'Thursday':
                return "Quinta-feira";
            case 'Friday':
                return "Sexta-feira";
            case 'Saturday':
                return "Sábado";
            case 'Sunday':
                return "Domingo";
        }
    }

?>