<?php

    // include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';


    if(session_status() == PHP_SESSION_ACTIVE){
        $nome = $_SESSION['nome'];
        $id = $_SESSION['id'];

        $sql = "SELECT f.id_funcionario, f.nome, c.nome_cargo FROM tbl_funcionario f INNER JOIN tbl_cargo c ON f.id_cargo = c.id_cargo WHERE id_funcionario = $id";
        $consulta = mysqli_query($con,$sql);
        $array = mysqli_fetch_array($consulta);

        $nomeLogado = $array['nome'];
        $cargo = $array['nome_cargo'];
        
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
                <!-- <img src="../../assets/img/user.png" alt=""> -->
                <img src="<?php echo BASE_URL ?>/assets/img/user.png" alt="">
            </div>

            <div class="usuario-info">
                <div class="usuario-logado-texto">
                    <p><?php echo $nomeLogado ?></p>
                    <span><?php echo $cargo ?></span>
                </div>
                <div class="usuario-logado-icodown">
                    <span class="material-symbols-rounded ico-icodown">keyboard_arrow_down</span>
                </div>

                <div class="usuario-logado-dropdown">
                    <ul class="dropwdown-logado" class="font-2-xs">
                        <li><a href="#"><span class="icon-btn-controle material-symbols-rounded">edit</span>Editar perfil</a></li>
                        <li><a href="<?php echo BASE_URL ?>/config/logoff.php"><span class="material-symbols-rounded">logout</span>Sair</a></li>
                    </ul>
                </div>

            </div>

        </div>
    </div>

    <div class="sub-container-header">
        <ul class="container-header-itens" >
            <li><a href="<?php echo BASE_URL ?>/app/administracao/funcionario/index.php">Funcionários</a></li>
            <li><a href="<?php echo BASE_URL ?>/app/administracao/setor/">Setores</a></li>
            <li><a href="<?php echo BASE_URL ?>/app/administracao/cargo/">Cargos</a></li>
            <li class="dropdown-acomodacoes"><a href="#">Acomodações</a>
                 <div class="container-dropwdown-acomodacoes" >
                    <ul class="container-dropwdown-itens font-2-xs">
                        <li><a href="<?php echo BASE_URL ?>/app/administracao/acomodacao/index.php">Acomodações</a></li>
                        <li><a href="<?php echo BASE_URL ?>/app/administracao/tipoAcomodacao/index.php">Tipo Acomodações</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="#">Frigobar</a></li>
            <li><a href="<?php echo BASE_URL ?>/app/administracao/estacionamento/index.php">Estacionamento</a></li>
        </ul>
    </div>
</header>

<nav class="container-navbar-lateral">
    <div class="logo">
        <!-- <img src="../../assets/img/logo.svg" alt=""> -->
        <img src="<?php echo BASE_URL ?>/assets/img/logo.svg" alt="">
    </div>

    <ul class="navbar-itens">
        <li class="cor-3 "><a href="navbar-lateral.php" class="font-1-m"><span class="material-symbols-rounded">dashboard</span>Dashboard</a></li>
        <li class="cor-3"><a href="app/" class="font-1-m"><span class="material-symbols-rounded">style</span>Reservas</a></li>
        <li class="cor-3"><a href="#" class="font-1-m"><span class="material-symbols-rounded">hotel</span>Acomodações</a></li>
        <li class="cor-3"><a href="#" class="font-1-m"><span class="material-symbols-rounded">group</span>Clientes</a></li>
        <li class="cor-3"><a href="#" class="font-1-m"><span class="material-symbols-rounded">package_2</span>Estoque</a></li>
        <li class="cor-3"><a href="<?php echo BASE_URL ?>/app/administracao/" class="font-1-m"><span class="material-symbols-rounded">room_preferences</span>Administração</a></li>
    </ul>

</nav>

<!-- <script src="../../js/menu.js"></script> -->
<script src="<?php echo BASE_URL ?>/js/menu.js"></script>
</body>