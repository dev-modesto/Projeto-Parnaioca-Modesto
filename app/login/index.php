<?php
    include '../../include/head.php';
    include './include/cLogin.php';

    session_start();

    if(isset($_SESSION['id'])){
        // echo 'Há uma sessão ativa no momento'; //retorno - comentário provisório
        // echo $_SESSION['id'];
    } else {
        // echo 'Nenhuma sessão ativa no momento!!'; //retorno - comentário provisório
    }
    
?>


<body class="body-login">
    <main class="container-principal-login">
        <section class="form-container-login">
            <!-- formulario envio cargo -->
            <div class="container-1-login">
                <div class="logo-login">
                    <img src="../../assets/img/logo.svg" alt="">
                </div>
            </div>
            <div class="container-2-login">
                <h1 class="font-1-xxl-2">LOGIN</h1>
                
                <form class="form-login" action="" method="post">
                        <span class="separador-login"></span>
                        <div class="mb-3">
                            <label class="label-login" for="form-label login">Matrícula</label>
                            <div class="container-input-login">
                                <span class="icone-login icone-matricula"></span>
                                <input class="input-login form-control " type="text" name="login" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="label-login" for="form-label senha">Senha</label>
                            <div class="container-input-login">
                                <span class="icone-login icone-senha"></span>
                                <input class="input-login form-control input-senha" type="password" name="senha" required>
                                <span class="icone-login icone-ver-senha"></span>
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

                            <?php
                                if(isset($_GET['msg'])){
                                    $msg = $_GET['msg'];
                                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                            '. $msg .'
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>';
                                }
                            
                            ?>

                            <?php
                                if(isset($_GET['msgInvalida'])){
                                    $msg = $_GET['msgInvalida'];
                                    echo '<div class="alert alert-danger  alert-dismissible fade show" role="alert">
                                            '. $msg .'
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>';
                                }
                            
                            ?>

                        <div class="form-container-button">
                            <button class='btn-login' type="submit">ENTRAR</button>
                        </div>
                </form>
        </section>
    </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="./../../js/senha.js"></script>
       <?php
       include __DIR__ . '/../../include/footer.php';
       ?>
        <script>

            var iconVerSenha = document.querySelector('.icone-ver-senha');

            iconVerSenha.addEventListener('click', function() {
                var inputSenha = document.querySelector('.input-senha');

                if (inputSenha.type === 'password') {
                    inputSenha.type = 'text';
                    iconVerSenha.classList.add('visible');
                } else {
                    inputSenha.type = 'password';
                    iconVerSenha.classList.remove('visible');
                }
                
            })

        </script>

</body>
