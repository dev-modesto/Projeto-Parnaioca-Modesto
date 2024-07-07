<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if(isset($_POST['idTpAcomodacao'])){
        $id = $_POST['idTpAcomodacao'];
        $nomeTpAcomodacao = trim($_POST['nomeTpAcomodacao']);

        $stmt = mysqli_prepare($con ,"UPDATE tbl_tp_acomodacao SET nome_tp_acomodacao = ? WHERE id_tp_acomodacao = ?");
        mysqli_stmt_bind_param($stmt, 'si', $nomeTpAcomodacao, $id);

        if(mysqli_stmt_execute($stmt)){
            header('location: ../index.php?msg=Atualizado com sucesso!');
        } else {
            echo "Erro ao gravar: " . mysqli_error($con);
        }

    } else {
        $mensagem = "";
    }


?>