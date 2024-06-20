<?php
    include '../../include/head.php';
?>
<body class="body-login">
    <main class="container-principal-login">
        <section class="form-container-login">
            <!-- formulario envio cargo -->
            <form  action="include/cLogin.php" method="post">
                <div class="container-logo-login">
                    <img src="../../assets/img/logo.svg" alt="">
                </div>
                <div>
                    <div class="mb-3">
                        <label class="label-login" for="form-label login">Login</label>
                        <input class="input-login form-control " type="text" name="login" placeholder="Informe seu login de acesso" required>
                    </div>
                    <div class="mb-3">
                        <label class="label-login" for="form-label senha">Senha</label>
                        <input class="input-login form-control" type="password" name="senha" placeholder="Informe sua senha" required>
                    </div>
                    <div class="form-container-button">
                        <button class='btn btn-primary' type="submit">ENTRAR</button>
                    </div>
                </div>
            </form>
        </section>
    </main>
</body>

<!-- <footer>
    <p>Alguns direitos reservados</p>
</footer> -->