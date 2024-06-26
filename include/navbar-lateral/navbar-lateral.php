<?php
    include '../../include/head.php';
    // header('location: ../../app/login/');

    if(session_status() == PHP_SESSION_ACTIVE){
        $nome = $_SESSION['nome'];
        $id = $_SESSION['id'];
    }
    
?>

<header class="header">
    <div class="container-usuario-logado">
        <div class="usuario-logado">
            <div class="usuario-logado-texto">
                <p><?php echo $nome ?></p>
                <span>Assistente de Frota II</span>
            </div>
            <div class="usuario-logado-foto" id="foto">
                <img src="../../assets/img/user.png" alt="">
            </div>
        </div>

        <div class="usuario-logado-dropdown">
            <ul class="dropwdown-logado" class="font-2-xs">
                <li><a href="#">Editar perfil</a></li>
                <li><a href="#">Sair</a></li>
            </ul>
        </div>

    </div>
</header>

<nav class="container-navbar-lateral aside">
    <div class="logo">
        <img src="../../assets/img/logo.svg" alt="">
    </div>

    <ul class="navbar-itens">
        <li class="cor-3 "><a href="navbar-lateral.php" class="font-1-m"><span class="material-symbols-rounded">dashboard</span>Dashboard</a></li>
        <li class="cor-3"><a href="app/" class="font-1-m"><span class="material-symbols-rounded">style</span>Reservas</a></li>
        <li class="cor-3"><a href="#" class="font-1-m"><span class="material-symbols-rounded">hotel</span>Acomodações</a></li>
        <li class="cor-3"><a href="#" class="font-1-m"><span class="material-symbols-rounded">group</span>Clientes</a></li>
        <li class="cor-3"><a href="#" class="font-1-m"><span class="material-symbols-rounded">directions_car</span>Estacionamento</a></li>
        <li class="cor-3"><a href="#" class="font-1-m"><span class="material-symbols-rounded">package_2</span>Administração</a></li>
    </ul>

</nav>

<script src="../../js/menu.js"></script>
