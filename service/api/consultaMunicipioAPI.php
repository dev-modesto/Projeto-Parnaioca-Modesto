<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';

    if(isset($_POST['consultaMunicipio'])) {
        $uf = $_POST['estado'];

        try {
            $ch = curl_init();
            $urlMunicipios = "https://servicodados.ibge.gov.br/api/v1/localidades/estados/$uf/municipios";
            curl_setopt($ch, CURLOPT_URL, $urlMunicipios);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
            $retorno = curl_exec($ch);
            curl_close($ch);

            if ($retorno) {
                $arrayMunicipios = json_decode($retorno, true);

                function Municipios($arrayMunicipios) {
                    $novoArrayMunicipios = [];
                    foreach($arrayMunicipios as $valorMunicipios) {
                        $id = $valorMunicipios['id'];
                        $nomeMunicipio = $valorMunicipios['nome'];
                    
                        $novoArrayMunicipios[] = [
                            'id' => $id,
                            'municipio' => $nomeMunicipio,
                        ];
                    }    
                    return $novoArrayMunicipios;
                }
                
                $retornoMunicipios = Municipios($arrayMunicipios);
                header('Content-Type: application/json');
                echo json_encode($retornoMunicipios);

            } else {
                $mensagem['mensagem'] = 'Ocorreu algum erro na consulta da API.';
                header('Content-Type: application/json');
                echo json_encode($mensagem);
            }

        } catch (Exception $e) {
            $mensagem['mensagem'] = 'Houve um error: ' . $e->getMessage();
            header('Content-Type: application/json');
            echo json_encode($mensagem);
        }
    }
?>