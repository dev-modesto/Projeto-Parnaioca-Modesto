<?php
    include '../../include/head.php';
    include './include/cLogin.php';
    include './include/aPrimeiraSenha.php';
    include __DIR__ . '/../funcao/verificaAtualizacaoSenha.php';

    if(isset($_SESSION['id'])) {
        $dt_cadastro = $_SESSION['dt_cadastro'];
        $dt_atualizacao = $_SESSION['dt_atualizacao'];

    } else {
        header('location: ./index.php'); 
    }

?>

<body class="body-login">
    <main class="container-principal-login">
        <section class="form-container-login ">
            <!-- formulario envio -->
            <div class="container-2-login">
                <h1 class="font-1-xxl-2">PRIMEIRO ACESSO</h1>
                

                <form class="form-login" action="" method="post">
                        <div class='text-center form-login-texto font-1-m'>
                            <p>Olá, <strong><?php echo $_SESSION['nome'] . '!';?></strong></p>
                            <p>Favor, informe uma nova senha.</p>
                        </div>
                        <span class="separador-login"></span>
                        <div class="mb-3">
                            <label class="label-login" for="form-label senha">Senha</label>
                            <div class="container-input-login">
                                <span class="icone-login icone-senha"></span>
                                <input class="input-login form-control input-senha input-senha-1" type="password" name="senha" required>
                                <span class="icone-login icone-ver-senha ver-senha-1"></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="label-login" for="form-label senha">Confirme sua senha</label>
                            <div class="container-input-login">
                                <span class="icone-login icone-senha"></span>
                                <input class="input-login form-control input-senha input-senha-2" type="password" name="senha-confirma" required>
                                <span class="icone-login icone-ver-senha ver-senha-2"></span>
                            </div>
                        </div>
                            
                            <?php if(!empty($mensagem)){ ?>  
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php echo $mensagem ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div> 
                            <?php }else {
                                    echo '';
                                }
                            ?>

                        <div class="container-requisitos-senha">
                            <span class="font-1-s">Sua senha deve ter pelo menos:</span>
                            <ul>
                                <li>- Começar ao menos com uma letra maiúscula</li>
                                <li>- Deve conter ao menos uma letra minúscula</li>
                                <li>- Deve conter ao menos um número</li>
                                <li>- Deve conter ao menos um caractere especial(*!@#$%&)</li>
                                <li>- Mínimo 8 caracteres e máximo 15</li>
                            </ul>
                        </div>

                        <div class="form-container-button">
                            <button class='btn-login' type="submit" data-bs-toggle="modal" data-bs-target="#exampleModal">ENTRAR</button>
                        </div>
                </form>
            </div>
            <div class="container-1-login">
                <div class="logo-login">
                    <img src="../../assets/img/logo.svg" alt="">
                </div>
            </div>

        </section>
    </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
       
       <script>

        var iconVerSenha1 = document.querySelector('.ver-senha-1');
        var iconVerSenha2 = document.querySelector('.ver-senha-2');

        iconVerSenha1.addEventListener('click', function() {
            var inputSenha1 = document.querySelector('.input-senha-1');

            if (inputSenha1.type === 'password') {
                inputSenha1.type = 'text';
                iconVerSenha1.classList.add('visible');
            } else {
                inputSenha1.type = 'password';
                iconVerSenha1.classList.remove('visible');
            }
        })

        iconVerSenha2.addEventListener('click', function() {
            var inputSenha2 = document.querySelector('.input-senha-2');

            if (inputSenha2.type === 'password') {
                inputSenha2.type = 'text';
                iconVerSenha2.classList.add('visible');
            } else {
                inputSenha2.type = 'password';
                iconVerSenha2.classList.remove('visible');
            }
        })

    </script>



</body>
