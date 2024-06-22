<?php 
    include __DIR__ . '/../../../config/conexao.php'; 
    include './../funcao/verificaCriterioSenha.php'; 
    
    session_start(); 

    if(isset($_POST['senha'])){
        $novaSenha = trim($_POST['senha']);
        $confirmaNovaSenha = trim($_POST['senha-confirma']);

        if($novaSenha == $confirmaNovaSenha){

            $sql = 'SELECT * FROM tbl_funcionario WHERE id_funcionario = ' . $_SESSION['id'];
            $retornoConsulta = mysqli_query($con,$sql);
            $hash = password_hash($novaSenha,PASSWORD_DEFAULT);
            $id = $_SESSION['id'];

            if(verificaCriterioSenha($criterioSenha, $novaSenha)){

                $sql2 = "UPDATE tbl_funcionario SET senha = '" . $hash . "' WHERE id_funcionario = " . $id;

                if(mysqli_query($con,$sql2)){
                    $_SESSION['update_success'] = true;
                    ?> 
                        <script>
                            alert("Senha atualizada com sucesso!")
                            window.location.href = './index.php';
                        </script>
                    <?php
                    session_destroy();
                } else {
                    $newMensage = "Erro ao gravar" . mysqli_error($con);
                }
                mysqli_close($con);

            }else {
                $mensagem = 'A senha nao atendeu aos requisitos.';
            }
            

        } else {
            $mensagem = 'Senhas não coincidem';
        }
        
    }
?>