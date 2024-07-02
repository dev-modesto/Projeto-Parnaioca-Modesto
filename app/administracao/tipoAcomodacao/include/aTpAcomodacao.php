<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if(isset($_POST['idTpAcomodacao'])){
        $id = $_POST['idTpAcomodacao'];
        $nomeTpAcomodacao = $_POST['nomeTpAcomodacao'];
        $sql = "UPDATE tbl_tp_acomodacao SET nome_tp_acomodacao = '$nomeTpAcomodacao' WHERE id_tp_acomodacao = '$id'";

        if(mysqli_query($con, $sql)){
            echo "atualizado com sucesso!!";
            $mensagem = "Cargo atualizado com sucesso!";
            header('location: ../index.php?msg=Atualizado com sucesso!');
        } else {
            echo "Erro ao gravar: " . mysqli_error($con);
        }

    } else {
        echo "Nada por aqui...";
    }


?>