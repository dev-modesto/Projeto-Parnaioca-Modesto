<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include './../../../funcao/converter.php';
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $numero = $_POST['numero'];
        $idTpAcomodacao = $_POST['id-tp-acomodacao'];
        $nomeAcomodacao = trim($_POST['nome-titulo']);
        $valor = $_POST['valor'];
        $valorConvertido = converterMonetario($valor); 
        
        $capacidade = $_POST['capacidade'];
        $status = $_POST['id-status'];

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

        mysqli_stmt_bind_param(
            $sql, 
            'iisdis', 
            $numero, 
            $idTpAcomodacao, 
            $nomeAcomodacao, 
            $valorConvertido, 
            $capacidade, 
            $status
        );

        if(mysqli_stmt_execute($sql)){

            // log operações
                $nomeTabela = 'tbl_acomodacao';
                $idRegistro = mysqli_insert_id($con);
                $tpOperacao = 'insercao';
                $descricao = 'Acomodação adicionada ID: ' . $idRegistro;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 

            header('location: ../index.php?msg=Adicionado com sucesso!');
        } else {
            echo "Error ao gravar" . mysqli_error($con);
        }

    } else {
        $mensagem = "";
    }


?>