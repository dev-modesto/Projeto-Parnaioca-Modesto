<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $id = $_POST['id'];
        $nomeFrigobar = $_POST['nome-frigobar'];
        $idAcomodacao = $_POST['id-acomodacao'];
        $capacidade = $_POST['capacidade'];

        $stmt = 
                mysqli_prepare(
                $con, 
                "UPDATE tbl_frigobar 
                SET nome_frigobar = ?, id_acomodacao = ?, capacidade_itens = ? 
                WHERE id_frigobar = '$id'"
        );
        
        mysqli_stmt_bind_param($stmt, 'sii', $nomeFrigobar, $idAcomodacao, $capacidade);

        if(mysqli_stmt_execute($stmt)){
            header('location: ../index.php?msg=Alterado com sucesso!');
        } else {
            echo "Error ao gravar" . mysqli_error($con);
        }
    }

?>