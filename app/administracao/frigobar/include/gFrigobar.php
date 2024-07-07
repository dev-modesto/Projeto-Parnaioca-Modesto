<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

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
            header('location: ../index.php?msg=Adicionado com sucesso!');
        }  

        mysqli_close($con);
    }

?>