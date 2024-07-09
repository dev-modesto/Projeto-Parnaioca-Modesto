<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $idNumeroAcomodacao = $_POST['id-acomodacao'];
        $nomeFrigobar = $_POST['nome-frigobar'];
        $capacidade = $_POST['capacidade'];

        $stmt = 
            mysqli_prepare(
            $con, 
            "INSERT INTO 
                tbl_frigobar (id_frigobar, id_acomodacao, nome_frigobar, capacidade_itens) 
            VALUES 
                (NULL, ?, ?, ?)"
        );
        
        mysqli_stmt_bind_param($stmt, "isi", $idNumeroAcomodacao, $nomeFrigobar, $capacidade);

        if(mysqli_stmt_execute($stmt)){
            // log operações
                $nomeTabela = 'tbl_frigobar';
                $idRegistro = mysqli_insert_id($con);
                $tpOperacao = 'insercao';
                $descricao = 'Frigobar adicionado ID: ' . $idRegistro;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            header('location: ../index.php?msg=Adicionado com sucesso!');
        }  

        mysqli_close($con);
    }

?>