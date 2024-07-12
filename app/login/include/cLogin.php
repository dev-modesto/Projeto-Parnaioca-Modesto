<?php
    include __DIR__ . '/../../../config/conexao.php';
    // include $_SERVER['DOCUMENT_ROOT'] . "/Projeto-Parnaioca-Modesto/config/config.php";

    if(isset($_POST['login'])){

        $login = $_POST['login'];
        $senha = $_POST['senha'];

        $stmt = mysqli_prepare($con,"SELECT * FROM tbl_funcionario WHERE id_funcionario = ?");
        mysqli_stmt_bind_param($stmt,"i", $login);
        $busca_login = mysqli_stmt_execute($stmt);

        if($busca_login){
            // echo "executado a busca!";
            $retorno = mysqli_stmt_get_result($stmt);

            if(mysqli_num_rows($retorno)){
                $array = mysqli_fetch_all($retorno, MYSQLI_ASSOC)[0];
                $hash = $array['senha'];
                $dt_cadastro = $array['dt_cadastro'];
                $dt_atualizacao = $array['dt_atualizacao'];

                if (password_verify($senha, $hash)){

                    //[senha correta]
                    session_start();
                    //armazenando os dados do banco na sessão
                    $_SESSION['id'] = $array['id_funcionario'];
                    $_SESSION['nome'] = $array['nome'];
                    $_SESSION['dt_cadastro'] = $array['dt_cadastro'];
                    $_SESSION['dt_atualizacao'] = $array['dt_atualizacao'];
                    
                    //verificando se houve atualizacção da senha. (caso nao houve, é o primeiro login do usuario)
                    if ($dt_cadastro == $dt_atualizacao){
                        header('location: ../login/primeiraSenha.php');
                        
                    } else {
                        header("location: ../home/index.php");                    
                    }

                } else {
                    $mensagem = 'Senha inválida';
                }

            } else {
                $mensagem = "Usuário não encontrado ou senha inválida";
            
            }
        } else {
            echo 'nao foi possivel executar a consulta';
        }

    } else {
        $mensagem = "";
    }
?>