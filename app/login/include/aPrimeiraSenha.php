<?php 
    include __DIR__ . '/../../../config/conexao.php'; 
    session_start(); 

    if(isset($_POST['senha'])){

        $novaSenha = trim($_POST['senha']);
        $confirmaNovaSenha = trim($_POST['senha-confirma']);

        if($novaSenha == $confirmaNovaSenha){
            echo 'senhas identicas | ';
            echo $_SESSION['id'];

            $sql = 'SELECT * FROM tbl_funcionario WHERE id_funcionario = ' . $_SESSION['id'];
            $retornoConsulta = mysqli_query($con,$sql);
            $hash = password_hash($novaSenha,PASSWORD_DEFAULT);//passando o senha como hash

            if(mysqli_num_rows($retornoConsulta)){
                echo ' | Achou o id no banco!';
            } else {
                echo 'nada foi encontrado';
            }

        } else {
            echo 'senhas não coincidem';
        }
        
        // $hash = password_hash($senhaConfirmada,PASSWORD_DEFAULT)
    }
?>