<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if(isset($_POST['idTpAcomodacao'])){
        $id = $_POST['idTpAcomodacao'];
        $nomeTpAcomodacao = trim($_POST['nomeTpAcomodacao']);

        $stmt = mysqli_prepare($con ,"UPDATE tbl_tp_acomodacao SET nome_tp_acomodacao = ? WHERE id_tp_acomodacao = ?");
        mysqli_stmt_bind_param($stmt, 'si', $nomeTpAcomodacao, $id);

        if(mysqli_stmt_execute($stmt)){
            // log operações
                $nomeTabela = 'tbl_tp_acomodacao';
                $idRegistro = $id;
                $tpOperacao = 'atualizacao';
                $descricao = 'Tipo acomodação atualizada ID: ' . $idRegistro;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            header('location: ../index.php?msg=Atualizado com sucesso!');
        } else {
            echo "Erro ao gravar: " . mysqli_error($con);
        }

    } else {
        $mensagem = "";
    }


?>