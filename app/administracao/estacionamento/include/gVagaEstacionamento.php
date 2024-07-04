<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

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
            header('location: ../index.php?msg=Adicionado com sucesso!');
        }  

        mysqli_close($con);
    }

?>