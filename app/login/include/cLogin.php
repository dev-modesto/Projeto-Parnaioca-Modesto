<?php
    include __DIR__ . '/../../../config/conexao.php';

    if(isset($_POST['login'])){

        $login = $_POST['login'];
        $senha = $_POST['senha'];

        $sql_login = "SELECT * FROM tbl_funcionario WHERE id_funcionario = '$login'";//consulta sql buscando pelo login
        $busca_login = mysqli_query($con, $sql_login);//passando a consulta sql pelo msqli_query

        $verifica = mysqli_num_rows($busca_login);//verificando se exite o login. se true = existe, false = nao existe
        
        if($verifica){
            //verificamos se o login existe. [existe]
            $array = mysqli_fetch_array($busca_login);
            $hash = $array['senha'];
            $dt_cadastro = $array['dt_cadastro'];
            $dt_atualizacao = $array['dt_atualizacao'];

            if (password_verify($senha, $hash)){ //verificando a senha digitada com a senha do banco

                //[senha correta]
                session_start();
                //armazenando os dados do banco na sessão
                $_SESSION['id'] = $array['id_funcionario'];
                $_SESSION['nome'] = $array['nome'];
                $_SESSION['cpf'] = $array['cpf'];

                //verificando se houve atualizacção da senha. (caso nao houve, é o primeiro login do usuario)
                if ($dt_cadastro == $dt_atualizacao){
                    //[não houve atualizacao]                   
                    // levar para tela de atualização de senha do usuário
                    header('location: ../login/pag_primeira_senha.php');
                    
                }else {
                    //[usuario ja atualizou]
                   // echo '| Senha já atualizada. Podemos continuar | ACESSO AO SISTEMA LIBERADO!!!!';
                    header('location: ./include/pag_sucesso.php');                    
                }

            }else{
                // [senha incorreta]
                // echo 'LOGIN OU SENHA INVÁLIDOS.';
                $mensagem = 'Senha inválida';
            }

        }else{
            // echo 'USUARIO NAO ENCONTRADO OU SENHA INVÁLIDOS!';
            $mensagem = 'Usuário não encontrado ou senha inválida';
            // session_abort();
            // echo 'sessao abortada';
        }

    }else {
        $mensagem = "";
    }
?>