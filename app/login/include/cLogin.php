<?php
    include __DIR__ . '/../../../config/conexao.php';
    //estou usando o '__DIR__' para passar o caminho com base no atual. 

    if(isset($_POST['login'])){

        $login = $_POST['login'];
        $senha = $_POST['senha'];

        $sql_login = "SELECT * FROM tbl_funcionario WHERE id_funcionario = '$login'";//consulta sql buscando pelo login
        $busca_login = mysqli_query($con, $sql_login);//passando a consulta sql pelo msqli_query

        $verifica = mysqli_num_rows($busca_login);//verificando se exite o login. se true = existe, false = nao existe
        
        if($verifica){

            $array = mysqli_fetch_array($busca_login);
            $hash = $array['senha'];
            $dt_cadastro = $array['dt_cadastro'];
            $dt_atualizacao = $array['dt_atualizacao'];

            if (password_verify($senha, $hash)){
                if ($dt_cadastro == $dt_atualizacao){

                    $mensagem = ' | Você precisa atualizar a senha.';
                    // levar para tela de atualização de senha do usuário
                }else {
                   // echo '| Senha já atualizada. Podemos continuar | ACESSO AO SISTEMA LIBERADO!!!!';
                    header('location: ./include/pag_sucesso.php');                    
                }

            }else{
                // echo 'LOGIN OU SENHA INVÁLIDOS.';
                $mensagem = 'Senha inválida';
            }

        }else{
            // echo 'USUARIO NAO ENCONTRADO OU SENHA INVÁLIDOS!';
            $mensagem = 'Usuário não encontrado ou senha inválida';
        }

    }else {
        $mensagem = "";
    }
?>