<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include './../../../funcao/converter.php';


    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['idAcomodacao'];
        $numero = trim($_POST['numero']);
        $idTpAcomodacao = $_POST['id-tp-acomodacao'];
        $nomeAcomodacao = trim($_POST['nome-titulo']);
        $valor = $_POST['valor'];
        $capacidade = trim($_POST['capacidade']);
        $idStatus = $_POST['id-status'];
        $valorConvertido = converterMonetario($valor);
        

        $stmt = mysqli_prepare(
            $con, 
            "UPDATE tbl_acomodacao 
            SET 
            numero_acomodacao=?, 
            id_tp_acomodacao=?, 
            nome_acomodacao=?, 
            valor=?, 
            capacidade_max=?, 
            id_status=? 
        WHERE 
            id_acomodacao = $id
        ");
        
        mysqli_stmt_bind_param(
            $stmt, 
            'iisdii', 
            $numero, 
            $idTpAcomodacao,
            $nomeAcomodacao, 
            $valorConvertido, 
            $capacidade, 
            $idStatus
        );

        if(mysqli_stmt_execute($stmt)) {
            header('location: ../index.php?msg=Atualizado com sucesso!');
        } else {
            echo "Erro ao gravar: " . mysqli_error($con);
        }


    }

?>