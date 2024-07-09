<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if(isset($_POST['setor'])){
        
        $setor = trim($_POST['setor']);
        $sql = "INSERT INTO tbl_setor(id_setor,nome_setor) VALUES(NULL,'$setor')";
        
        $stmt = mysqli_prepare($con, "INSERT INTO tbl_setor(id_setor, nome_setor) VALUES (NULL, ?)");
        mysqli_stmt_bind_param($stmt, "s", $setor);

        if(mysqli_stmt_execute($stmt)){
            // log operações
                $nomeTabela = 'tbl_setor';
                $idRegistro = mysqli_insert_id($con);
                $tpOperacao = 'insercao';
                $descricao = 'Setor adicionado ID: ' . $idRegistro;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            header('location: ../index.php?msg=Adicionado com sucesso!');
        } else {
            echo "Error ao gravar" . mysqli_error($con);
        }

        mysqli_close($con);
    }

?>