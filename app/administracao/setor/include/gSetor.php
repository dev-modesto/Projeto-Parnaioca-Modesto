<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if(isset($_POST['setor'])){
        
        $nomeSetor = trim($_POST['setor']);

        $sqlVerifica = mysqli_prepare($con, "SELECT * FROM tbl_setor WHERE nome_setor = ? ");
        mysqli_stmt_bind_param($sqlVerifica, "s", $nomeSetor);
        mysqli_stmt_execute($sqlVerifica);
        $result = mysqli_stmt_get_result($sqlVerifica);
        $msg = "";

        if (mysqli_num_rows($result) > 0) {
            $msg .= "Este setor já foi cadastrado.";
            header('location: ../index.php?msgInvalida=' . $msg);
            mysqli_close($con);

        } else {

            $stmt = mysqli_prepare($con, "INSERT INTO tbl_setor(id_setor, nome_setor) VALUES (NULL, ?)");
            mysqli_stmt_bind_param($stmt, "s", $nomeSetor);

            if(mysqli_stmt_execute($stmt)){

                // log operações
                    $nomeTabela = 'tbl_setor';
                    $idRegistro = mysqli_insert_id($con);
                    $tpOperacao = 'insercao';
                    $descricao = 'Setor adicionado ID: ' . $idRegistro;
                    logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
                //
                
                $msg = "Adicionado com sucesso!";
                header('location: ../index.php?msg=' . $msg);
    
            } else {
                echo "Error ao gravar" . mysqli_error($con);
                
            }
    
            mysqli_close($con);

        }

    }

?>