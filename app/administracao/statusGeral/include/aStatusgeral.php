<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' ) {
        $id = $_POST['idStatusGeral'];
        $nomeStatus =trim($_POST['nomeStatusGeral']);
        
        $stmt = mysqli_prepare($con,"UPDATE tbl_status_geral SET nome_status = ? WHERE id_status = '$id'");
        mysqli_stmt_bind_param($stmt, 's', $nomeStatus);

        if(mysqli_stmt_execute($stmt)) {
            // log operações
                $nomeTabela = 'tbl_status_geral';
                $idRegistro = $id;
                $tpOperacao = 'atualizacao';
                $descricao = 'Status geral atualizado ID: ' . $idRegistro;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            header('location: ./../index.php?msg=Atualizado com sucesso!');
        } else {
            echo "Error ao gravar" . mysqli_error($con);
        }
        
    }
    
?>