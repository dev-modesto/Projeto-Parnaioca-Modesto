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
        $nomeSetor = trim($_POST['setor']);

        $sqlVerifica = mysqli_prepare($con, "SELECT * FROM tbl_setor WHERE nome_setor = ? AND id_setor != ? ");
        mysqli_stmt_bind_param($sqlVerifica, "si", $nomeSetor, $id);
        mysqli_stmt_execute($sqlVerifica);
        $result = mysqli_stmt_get_result($sqlVerifica);
        $msg = "";

        if (mysqli_num_rows($result) > 0) {
            $msg .= "Este setor já foi cadastrado.";
            header('location: ../index.php?msgInvalida=' . $msg);
            mysqli_close($con);

        } else {

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

                $msg = "Adicionado com sucesso!";
                header('location: ../index.php?msg=' . $msg);

            } else {
                echo "Error ao gravar" . mysqli_error($con);
            }
        }
    }

?>