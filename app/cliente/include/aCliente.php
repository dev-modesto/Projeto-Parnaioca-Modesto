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
            
            mysqli_stmt_execute($sql);

            // log operações
                $nomeTabela = 'tbl_cliente';
                $idRegistro = $id;
                $tpOperacao = 'atualizacao';
                $descricao = 'Cliente atualizado ID: ' . $id;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 

            $mensagem = "Cliente atualizado com sucesso!";
            header('location: ../index.php?msg=' . $mensagem);
            mysqli_commit($con);

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