<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $nomeTpAcomodacao = trim($_POST['nome-tp-acomodacao']);

        $sql = mysqli_prepare($con, "INSERT INTO tbl_tp_acomodacao (id_tp_acomodacao, nome_tp_acomodacao) VALUES (null, ?)");
        mysqli_stmt_bind_param($sql, 's', $nomeTpAcomodacao);

        if(mysqli_stmt_execute($sql)){
            // log operações
                $nomeTabela = 'tbl_tp_acomodacao';
                $idRegistro = mysqli_insert_id($con);
                $tpOperacao = 'insercao';
                $descricao = 'Tipo acomodação adicionada ID: ' . $idRegistro;
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