<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST['id'];
        $idAcomodacao = $_POST['id-numero-acomodacao'];
        $numeroVaga = trim($_POST['numero-vaga-estacionamento']);

        $stmt = 
                mysqli_prepare(
                $con, 
                "UPDATE tbl_estacionamento 
                SET id_acomodacao = ?, numero_vaga = ? 
                WHERE id_estacionamento = '$id'"
        );
        
        mysqli_stmt_bind_param($stmt, 'is', $idAcomodacao, $numeroVaga);

        if(mysqli_stmt_execute($stmt)){
            // log operações
                $nomeTabela = 'tbl_estacionamento';
                $idRegistro = $id;
                $tpOperacao = 'atualizacao';
                $descricao = 'Vaga estacionamento atualizada ID: ' . $idRegistro;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            header('location: ../index.php?msg=Alterado com sucesso!');
        } else {
            echo "Error ao gravar" . mysqli_error($con);
        }
    }

?>