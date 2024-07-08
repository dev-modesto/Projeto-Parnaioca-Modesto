<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }
    
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $id = $_POST['id-cliente'];
        $nome = trim($_POST['nome']);
        $dataNascimento = trim($_POST['data-nascimento']);
        $cpf = trim($_POST['cpf']);
        $email = trim($_POST['email']);
        $telefone = trim($_POST['telefone']);
        $estado = trim($_POST['estado']);
        $cidade = trim($_POST['cidade']);
        $idFuncionario = $_POST['id-funcionario'];
        $idStatus = $_POST['id-status'];

        if(strlen($cpf) < 14){
            header('location: ../index.php?msgInvalida=Cpf inválido. Favor, preencha corretamente.');
        } else {
    
            $sql = 
                    mysqli_prepare(
                    $con,
                    "UPDATE tbl_cliente 
                    SET 
                        nome=?, 
                        dt_nascimento=?, 
                        cpf=?, 
                        email=?, 
                        telefone=?, 
                        estado=?, 
                        cidade=?, 
                        id_funcionario=?, 
                        id_status=? 
                    WHERE id_cliente = ?"
            );

            mysqli_stmt_bind_param(
                $sql, 
                "sssssssiii",
                $nome,
                $dataNascimento,
                $cpf,
                $email, 
                $telefone,
                $estado,
                $cidade, 
                $idFuncionario, 
                $idStatus, 
                $id
            );
    
            if(mysqli_stmt_execute($sql)){

                // log operações
                    $nomeTabela = 'tbl_cliente';
                    $idRegistro = $id;
                    $tpOperacao = 'atualizacao';
                    $descricao = 'Cliente atualizado ID: ' . $id;
                    logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
                // 


                // echo 'gravado com sucesso';
                $mensagem = "Cliente atualizado com sucesso!";
                header('location: ../index.php?msg=Atualizado com sucesso!');
            } else {
                echo "Erro ao gravar: " . mysqli_error($con);
            }
            mysqli_close($con);
            
        }

    }

?>