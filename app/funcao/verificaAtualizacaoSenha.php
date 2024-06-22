<?php
    include __DIR__ . '/../../config/conexao.php';

    $login = $_SESSION['id'];

        $sql_login = "SELECT * FROM tbl_funcionario WHERE id_funcionario = '$login'";
        $busca_login = mysqli_query($con, $sql_login);

        $verifica = mysqli_num_rows($busca_login);

        $array = mysqli_fetch_array($busca_login);
        $dt_cadastro = $array['dt_cadastro'];
        $dt_atualizacao = $array['dt_atualizacao'];

        //Aqui estou chamando minha função que irá verificar se houve atualização da senha. Caso true, ele me redireciona para index. False, posso definir a primeira senha.
        function verificaPrimeiroAcesso($dt_cadastro, $dt_atualizacao){

            if($dt_cadastro == $dt_atualizacao){
                // echo 'Funcão: DATA IGUAL - dt_cadastro ('. $dt_cadastro .') dt_atualização: (' . $dt_atualizacao . ').';//retorno - comentário provisório
                return true;
            }else {
                ?> <script>
                    window.location.href = '../login/index.php'';
                    </script>   
                <?php
                // echo 'funcao: DATA JÁ FOI ATUALIZADA. ';//pre-verificação - comentario provisorio
                // header('location: ../login/index.php');   
                return false;
            }
        }

        verificaPrimeiroAcesso($dt_cadastro, $dt_atualizacao);
?>