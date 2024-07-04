<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include './../../../funcao/converter.php';

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $numero = $_POST['numero'];
        $idTpAcomodacao = $_POST['id-tp-acomodacao'];
        $nomeAcomodacao = trim($_POST['nome-titulo']);
        $valor = $_POST['valor'];
        $valorConvertido = converterMonetario($valor); 
        
        $capacidade = $_POST['capacidade'];
        $status = $_POST['id-status'];

            // $array = [$numero, $idTpAcomodacao, $nomeAcomodacao, $valor, $capacidade, $status];
            // echo "<pre>";
            // print_r($array);
            // die();

            $sql = mysqli_prepare($con, 
        "INSERT INTO tbl_acomodacao 
            (id_acomodacao, 
            numero_acomodacao, 
            id_tp_acomodacao, 
            nome_acomodacao, 
            valor, 
            capacidade_max, 
            id_status) 
        VALUES 
            (null, ?, ?, ?, ?, ?, ?)");

        mysqli_stmt_bind_param($sql, 'iisdis', $numero, $idTpAcomodacao, $nomeAcomodacao, $valorConvertido, $capacidade, $status);

        if(mysqli_stmt_execute($sql)){
            header('location: ../index.php?msg=Adicionado com sucesso!');
        } else {
            echo "Error ao gravar" . mysqli_error($con);
        }

    } else {
        $mensagem = "";
    }


?>