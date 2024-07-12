<?php 
    include $_SERVER['DOCUMENT_ROOT'] . "/Projeto-Parnaioca-Modesto/config/config.php";
    include ARQUIVO_CONEXAO;
    include PASTA_FUNCOES . '/verificaCriterioSenha.php';
    
    session_start(); 

    if(isset($_POST['senha'])) {
        $novaSenha = trim($_POST['senha']);
        $confirmaNovaSenha = trim($_POST['senha-confirma']);

        if($novaSenha == $confirmaNovaSenha){

            $sql = "SELECT * FROM tbl_funcionario WHERE id_funcionario = " . $_SESSION['id'];
            $retornoConsulta = mysqli_query($con,$sql);
            $hash = password_hash($novaSenha,PASSWORD_DEFAULT);
            $id = $_SESSION['id'];

            if(verificaCriterioSenha($criterioSenha, $novaSenha)) {

                $sqlAtualizar = mysqli_prepare($con, "UPDATE tbl_funcionario SET senha = ? WHERE id_funcionario = $id ");
                mysqli_stmt_bind_param($sqlAtualizar, "s", $hash);
            
                if (mysqli_stmt_execute($sqlAtualizar)) {
                    header('location: ../login/index.php?msg=Atualizado com sucesso!');
                    session_destroy();

                } else {
                    $newMensage = "Erro ao gravar" . mysqli_error($con);

                }

                mysqli_close($con);

            } else {
                $mensagem = 'A senha não atendeu aos requisitos.';
            }

        } else {
            $mensagem = 'Senhas não coincidem';
        }

    } else {
        $mensagem = "";
    }
    
?>