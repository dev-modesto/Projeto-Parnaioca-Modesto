<?php
    include '../../../config/conexao.php';

    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $sql_login = "SELECT * FROM tbl_funcionario WHERE id_funcionario = '$login'";
    // $sql_senha = "SELECT * FROM tbl_funcionario WHERE senha = '$senha'";
    $busca_login = mysqli_query($con, $sql_login);

    $verifica = mysqli_num_rows($busca_login);
    
    if($verifica){
        echo 'LOGIN EXISTE';

        $dados = mysqli_fecth_array($verifica);
            if(password_verify($senha,$hash)){
                echo "senha ok!";
            }else{
                echo "senha incorreta";
            }

        mysqli_close($con);
    }else{
        echo 'LOGIN NÃO ENCONTRADO!';
    }
?>