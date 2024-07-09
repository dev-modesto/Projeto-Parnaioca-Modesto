<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if(isset($_POST['setor'])){
        $id = $_POST['id'];
        $nomeSetor = $_POST['setor'];

        $stmt = mysqli_prepare($con, "UPDATE tbl_setor SET nome_setor = ? WHERE id_setor = ? ");
        mysqli_stmt_bind_param($stmt, 'si', $nomeSetor, $id);

        if(mysqli_stmt_execute($stmt)){
            // log operações
                $nomeTabela = 'tbl_setor';
                $idRegistro = $id;
                $tpOperacao = 'atualizacao';
                $descricao = 'Setor atualizado ID: ' . $idRegistro;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            header('location: ../index.php?msg=Alterado com sucesso!');
        } else {
            echo "Error ao gravar" . mysqli_error($con);
        }
    }

?>