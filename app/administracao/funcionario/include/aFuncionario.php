<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }
    
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){

        $id = $_POST['id-funcionario'];
        $nome = trim($_POST['nome']);
        $cpf = trim($_POST['cpf']);
        $telefone = trim($_POST['telefone']);
        $id_cargo = trim($_POST['id_cargo']);

        if(strlen($cpf) < 14){
            header('location: ../index.php?msgInvalida=Cpf inválido. Favor, preencha corretamente.');

        } else {

            // consulta verificar cpf se já foi cadastrado
            $sqlVerifica = mysqli_prepare($con, "SELECT * FROM tbl_funcionario WHERE cpf = ? AND id_funcionario != ? ");
            mysqli_stmt_bind_param($sqlVerifica, "si", $cpf, $id);
            mysqli_stmt_execute($sqlVerifica);    
            $result = mysqli_stmt_get_result($sqlVerifica);

            if (mysqli_num_rows($result) > 0) {

                header('location: ../index.php?msgInvalida=Este CPF já foi cadastrado anteriormente.');
                mysqli_close($con); 

            } else {

                $sql = mysqli_prepare($con, "UPDATE tbl_funcionario SET nome=?,cpf=?,telefone=?,id_cargo=? WHERE id_funcionario = ?");
                mysqli_stmt_bind_param($sql, "ssssi",$nome,$cpf,$telefone,$id_cargo,$id);
        
                if(mysqli_stmt_execute($sql)){
    
                    // log operações
                        $nomeTabela = 'tbl_funcionario';
                        $idRegistro = $id;
                        $tpOperacao = 'atualizacao';
                        $descricao = 'Funcionário atualizado ID: ' . $id;
                        logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
                    // 

                    // $mensagem = "Usuario atualizado com sucesso!";
                    header('location: ../index.php?msg=Atualizado com sucesso!');

                } else {
                    echo "Erro ao gravar: " . mysqli_error($con);

                }
                
                mysqli_close($con);

            }
            
        }

    }

?>