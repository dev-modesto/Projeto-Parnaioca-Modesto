<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $idNumeroAcomodacao = $_POST['id-numero-acomodacao'];
        $numeroVagaEstacionamento = trim($_POST['numero-vaga-estacionamento']);

        $stmt = 
            mysqli_prepare(
            $con, 
            "INSERT INTO 
                tbl_estacionamento (id_estacionamento, id_acomodacao, numero_vaga) 
            VALUES 
                (NULL, ?, ?)"
        );
        
        mysqli_stmt_bind_param($stmt, "is", $idNumeroAcomodacao, $numeroVagaEstacionamento);

        if(mysqli_stmt_execute($stmt)){
            // log operações
                $nomeTabela = 'tbl_estacionamento';
                $idRegistro = mysqli_insert_id($con);
                $tpOperacao = 'insercao';
                $descricao = 'Vaga estacionamento adicionada ID: ' . $idRegistro;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            header('location: ../index.php?msg=Adicionado com sucesso!');
        }  

        mysqli_close($con);
    }

?>