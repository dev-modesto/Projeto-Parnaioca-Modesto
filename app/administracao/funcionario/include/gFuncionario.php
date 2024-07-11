<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        //enviou o formulario
        $nome = trim($_POST['nome']);
        $cpf = trim($_POST['cpf']);
        $telefone = trim($_POST['telefone']);
        $id_cargo = trim($_POST['id_cargo']);
        $senha = trim($_POST['cpf']);

        if(strlen($cpf) < 14){
            header('location: ../index.php?msgInvalida=CPF inválido. Favor, preencha corretamente.');
        } else {

            // definindo senha padrao
            $nomePadrao = "Parnaioca";
            $priCaractereCpf = substr($senha,0,3);
            $senhaPadrao = $nomePadrao . '@' . $priCaractereCpf;

            $hash = password_hash($senhaPadrao,PASSWORD_DEFAULT);

            // consulta verificar cpf se já foi cadastrado
            $sqlVerifica = mysqli_prepare($con, "SELECT * FROM tbl_funcionario WHERE cpf = ? ");
            mysqli_stmt_bind_param($sqlVerifica, "s", $cpf);
            mysqli_stmt_execute($sqlVerifica);    
            $result = mysqli_stmt_get_result($sqlVerifica);

            if (mysqli_num_rows($result) > 0) {
                header('location: ../index.php?msgInvalida=Este CPF já foi cadastrado anteriormente.');
                mysqli_close($con);

            } else {
                $sql = 
                    mysqli_prepare(
                    $con, 
                    "INSERT INTO tbl_funcionario (
                        id_funcionario, 
                        nome, 
                        cpf, 
                        telefone, 
                        id_cargo, 
                        senha) 
                    VALUES (null, ?, ?, ?, ?, ?)"
                );

                mysqli_stmt_bind_param(
                    $sql,
                    "sssis",
                    $nome,
                    $cpf,
                    $telefone,
                    $id_cargo,
                    $hash
                );

                if(mysqli_stmt_execute($sql)){
                    // id gerado ao gravar
                    $idFuncionario = mysqli_insert_id($con);
    
                    // log operações
                        $nomeTabela = 'tbl_funcionario';
                        $idRegistro = $idFuncionario;
                        $tpOperacao = 'insercao';
                        $descricao = 'Funcionário adicionado ID: ' . $idFuncionario;
                        logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
                    // 
                    
                    // idFuncionario = matricula do novo funcionario
                    nivelAcessoPadrao($con, $idFuncionario,1,0,0);
    
                    header('location: ../index.php?msg=Adicionado com sucesso!');
                } else {
                    echo "Error ao gravar" . mysqli_error($con);
                }
                mysqli_close($con);
            }
        }

    } else {
        $mensagem = "";
    }
?>