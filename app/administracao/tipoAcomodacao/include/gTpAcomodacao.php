<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $nomeTpAcomodacao = trim($_POST['nome-tp-acomodacao']);

        $sql = mysqli_prepare($con, "INSERT INTO tbl_tp_acomodacao (id_tp_acomodacao, nome_tp_acomodacao) VALUES (null, ?)");
        mysqli_stmt_bind_param($sql, 's', $nomeTpAcomodacao);

        if(mysqli_stmt_execute($sql)){
            header('location: ../index.php?msg=Adicionado com sucesso!');
        } else {
            echo "Error ao gravar" . mysqli_error($con);
        }

    } else {
        $mensagem = "";
    }


?>