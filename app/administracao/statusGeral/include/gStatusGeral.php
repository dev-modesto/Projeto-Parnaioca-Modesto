<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $nomeStatus = trim($_POST['status']);
        
        $stmt = mysqli_prepare($con, "INSERT INTO tbl_status_geral (id_status, nome_status) VALUE (null, ?)");
        mysqli_stmt_bind_param($stmt, 's', $nomeStatus);
        
        if(mysqli_stmt_execute($stmt)){
            // log operações
                $nomeTabela = 'tbl_status_geral';
                $idRegistro = mysqli_insert_id($con);
                $tpOperacao = 'insercao';
                $descricao = 'Status geral adicionado ID: ' . $idRegistro;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            header('location: ../index.php?msg=Adicionado com sucesso!');
        } else {
            echo "Error ao gravar" . mysqli_error($con);
        }
    }

?>