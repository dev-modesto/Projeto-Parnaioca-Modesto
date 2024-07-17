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

        $sqlAcesso = "SELECT * FROM tbl_acesso_area WHERE id_funcionario = '$id'";
        $consultaAcesso = mysqli_query($con, $sqlAcesso);
        $arrayAcesso = mysqli_fetch_array($consultaAcesso);

        $sac = $arrayAcesso['sac'];
        $logistica = $arrayAcesso['logistica'];
        $administracao = $arrayAcesso['administracao'];

        if ($sac == 0 AND $logistica == 0 AND $administracao == 0) {
            header("location: " . BASE_URL . "/app/login/index.php?msgInvalida=Usuário sem acesso ao sistema. Favor, entre em contato com o administrador.");
            mysqli_close($con);
            die();
        } 
    }
    
?>

<body>
    


<header class="header">
    <div class="principal-container-header">
        <div class="container-titulo-cabecalho">
            <h1 class="font-1-xxl-1"><?php echo $tituloMenuPagina ?></h1>
        </div>

        <div class="container-usuario-logado">
            <div class="usuario-logado-foto" id="foto">
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

    <?php 

        if ($setorPagina == "Administração") {
            // echo "<pre>";
            // print_r('pagina administracao');
            // die();

            if ($administracao == 1 ){

                switch ($grupoPagina) {
                    case 'Administração geral':
                            ?> 
                                <div class="sub-container-header">
                                    <ul class="container-header-itens" >
                                        <li><a href="<?php echo BASE_URL ?>/app/administracao/funcionario/index.php">Funcionários</a></li>
                                        <li><a href="<?php echo BASE_URL ?>/app/administracao/setor/index.php">Setores</a></li>
                                        <li><a href="<?php echo BASE_URL ?>/app/administracao/cargo/index.php">Cargos</a></li>
                                        <li class="dropdown-acomodacoes"><a href="#">Acomodações</a>
                                            <div class="container-dropwdown-acomodacoes" >
                                                <ul class="container-dropwdown-itens font-2-xs">
                                                    <li><a href="<?php echo BASE_URL ?>/app/administracao/acomodacao/index.php">Acomodações</a></li>
                                                    <li><a href="<?php echo BASE_URL ?>/app/administracao/tipoAcomodacao/index.php">Tipo Acomodações</a></li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li><a href="<?php echo BASE_URL ?>/app/administracao/frigobar/index.php">Frigobar</a></li>
                                        <li><a href="<?php echo BASE_URL ?>/app/administracao/estacionamento/index.php">Estacionamento</a></li>
                                    </ul>
                                </div>
                            
                            <?php
                        break;
    
                    case 'Nível de acesso':
                            ?> 
                                <div class="sub-container-header">
                                    <ul class="container-header-itens" >
                                        <li><a href="<?php echo BASE_URL ?>/app/administracao/acessoArea/index.php">Controle nível de acesso</a></li>
                                    </ul>
                                </div>
                            <?php
       
                        break;
    
                    case 'Logs geral':
                            
                            ?> 
                                <div class="sub-container-header">
                                    <ul class="container-header-itens" >
                                        <li><a href="<?php echo BASE_URL ?>/app/administracao/logOperacao/index.php">Logs de Operações</a></li>
                                    </ul>
                                </div>
                            <?php

       
                        break;
                    
                    default:
     
                        break;
                }
            }
        }  

        if ($setorPagina == "Logística") {

            if ($logistica == 1) {

                switch ($grupoPagina) {
                    case 'Produtos':
                            ?> 
                                <div class="sub-container-header">
                                    <ul class="container-header-itens" >
                                        <li><a href="<?php echo BASE_URL ?>/app/estoque/produto/cadastro/index.php">Cadastro</a></li>
                                        <li><a href="<?php echo BASE_URL ?>/app/estoque/produto/entrada/index.php">Entrada</a></li>
                                        <li><a href="<?php echo BASE_URL ?>/app/estoque/produto/saida/index.php">Saída</a></li>
                                    </ul>
                                </div>
                            <?php
                        break;

                    case 'Frigobar':
                        ?> 
                            <div class="sub-container-header">
                                <ul class="container-header-itens" >
                                    <li><a href="<?php echo BASE_URL ?>/app/estoque/frigobar/abastecer/index.php">Abastecer</a></li>
                                    <li><a href="<?php echo BASE_URL ?>/app/estoque/frigobar/entrada/index.php">Tabela de abastecimento</a></li>
                                    <li><a href="<?php echo BASE_URL ?>/app/estoque/frigobar/consumo/index.php">Consumo</a></li>
                                </ul>
                            </div>
                        <?php
                        break;

                default:
                        break;
                    
                }
            }
        }

    ?>

</header>

<nav class="container-navbar-lateral">
    <div class="logo">
        <img class="img-logo" src="<?php echo BASE_URL ?>/assets/img/logo-2.svg"  data-logoMax="<?php echo BASE_URL ?>/assets/img/logo-2.svg" data-logoMin="<?php echo BASE_URL ?>/assets/img/logo-2-minimizada.svg" alt="">
    </div>

    <ul class="navbar-itens">
        <li class="cor-3 "><a href="navbar-lateral.php" class="font-1-s"><span class="material-symbols-rounded">dashboard</span><p class="texto-nav">Dashboard</p></a></li>
        <li class="cor-3"><a href="app/" class="font-1-s"><span class="material-symbols-rounded">style</span><p class="texto-nav">Reservas</p></a></li>
        <li class="cor-3"><a href="#" class="font-1-s"><span class="material-symbols-rounded">hotel</span><p class="texto-nav">Acomodações</p></a></li>
        
       

        <?php 

            if ($sac == 1 ){
                ?> 
                    <li class="cor-3"><a href="<?php echo BASE_URL ?>/app/cliente/index.php" class="font-1-s"><span class="material-symbols-rounded">group</span><p class="texto-nav">Clientes</p></a></li>
                <?php
            }

            if ($logistica == 1) {
                ?> 
                     <li class="cor-3"><a href="<?php echo BASE_URL ?>/app/estoque/" class="font-1-s"><span class="material-symbols-rounded">package_2</span><p class="texto-nav">Estoque</p></a></li>
                 <?php
            } 

            if ($administracao == 1 ){
                ?> 
                    <li class="cor-3"><a href="<?php echo BASE_URL ?>/app/administracao/" class="font-1-s"><span class="material-symbols-rounded">room_preferences</span><p class="texto-nav">Administração</p></a></li>
                <?php
            }


        ?>
        
    </ul>

</nav>
<div class="container-botao-menu">
    <div class="botao-menu">
        <span class="material-symbols-rounded"> keyboard_arrow_left</span>
    </div>
</div>


<!-- <script src="../../js/menu.js"></script> -->
<script src="<?php echo BASE_URL ?>/js/menu.js"></script>
</body>