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
        $nomeFrigobar = $_POST['nome-frigobar'];
        $idAcomodacao = $_POST['id-acomodacao'];
        $capacidade = $_POST['capacidade'];

        $stmt = 
                mysqli_prepare(
                $con, 
                "UPDATE tbl_frigobar 
                SET nome_frigobar = ?, id_acomodacao = ?, capacidade_itens = ? 
                WHERE id_frigobar = '$id'"
        );
        
        mysqli_stmt_bind_param($stmt, 'sii', $nomeFrigobar, $idAcomodacao, $capacidade);

        if(mysqli_stmt_execute($stmt)){
            // log operações
                $nomeTabela = 'tbl_frigobar';
                $idRegistro = $id;
                $tpOperacao = 'atualizacao';
                $descricao = 'Frigobar atualizado ID: ' . $idRegistro;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            header('location: ../index.php?msg=Alterado com sucesso!');
        } else {
            echo "Error ao gravar" . mysqli_error($con);
        }
    }

?>