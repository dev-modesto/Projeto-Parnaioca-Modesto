<?php
    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION['id'])){
        // echo 'Voce precisa realizar o login!';
        echo"
        <script>
            alert('Área restrita a usuários logados. Informe o seu Login e Senha.');
            window.location = '../../app/login/';
        </script>
    ";
        header('location: ../../app/login/');
    }

    function segurancaAdm($con, $id){
        $sqlAcesso = "SELECT * FROM tbl_acesso_area WHERE id_funcionario = '$id'";
        $consultaAcesso = mysqli_query($con, $sqlAcesso);
        $arrayAcesso = mysqli_fetch_array($consultaAcesso);

        $idAcesso = $arrayAcesso['administracao'];

        if ($idAcesso != 1) {
            // verificando se não é administrador
            header('location:' .BASE_URL .'/app/cliente/index.php');
        }

    }

?>