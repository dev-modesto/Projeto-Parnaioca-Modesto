<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $nome = trim($_POST['nome']);
        $dataNascimento = trim($_POST['data-nascimento']);
        $cpf = trim($_POST['cpf']);
        $email = trim($_POST['email']);
        $telefone = trim($_POST['telefone']);
        $estado = trim($_POST['estado']);
        $cidade = trim($_POST['cidade']);
        $idStatus = 1;

        if(strlen($cpf) < 14){
            $mensagem = "Cpf inválido. Favor, preencha corretamente.";
            header('location: ../index.php?msgInvalida=' . $mensagem);
            die();
        } 

        mysqli_begin_transaction($con);

        try {
            
            $sqlVerifica = mysqli_prepare($con, "SELECT cpf, email FROM tbl_cliente WHERE cpf = ? OR email = ? ");
            mysqli_stmt_bind_param($sqlVerifica, "ss", $cpf, $email);
            mysqli_stmt_execute($sqlVerifica);
            $result = mysqli_stmt_get_result($sqlVerifica);
        
            if (mysqli_num_rows($result) > 0) {
                $array = mysqli_fetch_assoc($result);
                
                if($array['cpf'] == $cpf ){
                    $mensagem = "Este CPF já foi cadastrado anteriormente.";
                    header('location: ../index.php?msgInvalida=' . $mensagem);
                    die();

                } elseif ($array['email'] == $email ){
                    $mensagem = "Este e-mail já foi cadastrado anteriormente.";
                    header('location: ../index.php?msgInvalida=' . $mensagem);
                    die();
                } 
            } 

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception('Tipo de e-mail inválido.');
            } 

            $sql = 
                mysqli_prepare(
                $con, 
                "INSERT INTO tbl_cliente (
                    id_cliente, 
                    nome, 
                    dt_nascimento, 
                    cpf, 
                    email, 
                    telefone, 
                    estado, 
                    cidade, 
                    id_funcionario, 
                    id_status) 
                VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?, ? )"
            );

            mysqli_stmt_bind_param(
                $sql,
                "sssssssii",
                $nome, 
                $dataNascimento, 
                $cpf, 
                $email, 
                $telefone,
                $estado, 
                $cidade, 
                $idLogado, 
                $idStatus
            );

            mysqli_stmt_execute($sql);
            $idCliente = mysqli_insert_id($con);

            // log operações
                $nomeTabela = 'tbl_cliente';
                $idRegistro = $idCliente;
                $tpOperacao = 'insercao';
                $descricao = 'Cliente adicionado ID: ' . $idCliente;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            mysqli_commit($con);
            header('location: ../index.php?msg=Adicionado com sucesso!');

        } catch (Exception $e) {
            mysqli_rollback($con);
            $mensagem = "Ocorreu um erro. Não foi possível realizar a operação.";
            header('location: ../index.php?msgInvalida=' . $mensagem);
            
        } finally {
            mysqli_close($con);
        }

    } else {
        $mensagem = "";
    }
?>