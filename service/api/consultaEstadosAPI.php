<?php
    $ch = curl_init();
    $urlEstados = 'https://servicodados.ibge.gov.br/api/v1/localidades/estados';
    curl_setopt($ch, CURLOPT_URL, $urlEstados);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $retorno = curl_exec($ch);
    curl_close($ch);
    
    $arrayEstados = json_decode($retorno, true);
    
    function Estados($arrayEstados) {
        $novoArrayEstados = [];
        foreach($arrayEstados as $valorEstados) {
            $id = $valorEstados['id'];
            $uf = $valorEstados['sigla'];
            $nomeEstado = $valorEstados['nome'];
        
            $novoArrayEstados[] = [
                'id' => $id,
                'uf' => $uf,
                'estado' => $nomeEstado,
            ];
        }    
        return $novoArrayEstados;
    }
    
    $retornoEstados = Estados($arrayEstados);
?>