<?php
    include '../../include/head.php';
    include __DIR__  . '/../../config/seguranca.php';
    // header('location: ../../app/login/');

    if(session_status() == PHP_SESSION_ACTIVE){
        $nome = $_SESSION['nome'];
        $id = $_SESSION['id'];
    }
    
?>

<body>
    


<header class="header">
    <div class="principal-container-header">
        <div class="container-titulo-cabecalho">
            <h1 class="font-1-xxl-1">Administração</h1>
        </div>

        <div class="container-usuario-logado">
            <div class="usuario-logado-foto" id="foto">
                <img src="../../assets/img/user.png" alt="">
            </div>

            <div class="usuario-info">
                <div class="usuario-logado-texto">
                    <p><?php echo $nome ?></p>
                    <span>Assistente de Frota II</span>
                </div>
                <div class="usuario-logado-icodown">
                    <span class="material-symbols-rounded ico-icodown">keyboard_arrow_down</span>
                </div>

                <div class="usuario-logado-dropdown">
                    <ul class="dropwdown-logado" class="font-2-xs">
                        <li><a href="#"><span class="icon-btn-controle material-symbols-rounded">edit</span>Editar perfil</a></li>
                        <li><a href="./../../config/logoff.php"><span class="material-symbols-rounded">logout</span>Sair</a></li>
                    </ul>
                </div>

            </div>

        </div>
    </div>

    <div class="sub-container-header">
        <ul class="container-header-itens" >
            <li><a href="../../app/funcionario/index.php">Funcionários</a></li>
            <li><a href="../../app/setor/">Setores</a></li>
            <li><a href="../../app/cargo/">Cargos</a></li>
            <li><a href="#">Acomodações</a></li>
            <li><a href="#">Frigobar</a></li>
            <li><a href="#">Estacionamento</a></li>
        </ul>
    </div>
</header>

<nav class="container-navbar-lateral">
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
</body>