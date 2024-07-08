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
        $idFuncionario = $_POST['id-funcionario'];
        $idStatus = $_POST['id-status'];

        $array = [$nome, $dataNascimento, $cpf, $email, $telefone, $estado, $cidade, $idFuncionario, $idStatus];

        if(strlen($cpf) < 14){
            header('location: ../index.php?msgInvalida=Cpf inválido. Favor, preencha corretamente.');
        } else {

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
                $idFuncionario, 
                $idStatus
            );
    
            if(mysqli_stmt_execute($sql)){
                $idCliente = mysqli_insert_id($con);

                // log operações
                    $nomeTabela = 'tbl_cliente';
                    $idRegistro = $idCliente;
                    $tpOperacao = 'insercao';
                    $descricao = 'Cliente adicionado ID: ' . $idCliente;
                    logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
                // 
                header('location: ../index.php?msg=Adicionado com sucesso!');
            } else {
                echo "Error ao gravar" . mysqli_error($con);
            }
            mysqli_close($con);
        }

    } else {
        $mensagem = "";
    }
?>