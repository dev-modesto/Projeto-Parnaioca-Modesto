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

    function dataHoraFormatada($dataOcorrencia) {
        $data = new DateTime($dataOcorrencia);
        $dataFormatada = date_format($data, "d/m/Y H:i:s");
        return $dataFormatada;
    }

?>