<?php
    $tituloPagina = "Administração ";
    $pagina = "Administração home";
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaAdm($con, $idLogado);
    }
    
    $sql = "SELECT * FROM tbl_tp_acomodacao";
    $consulta = mysqli_query($con, $sql);

?>

    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Administração</title>
        <!-- link bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- meu css -->
        <link rel="stylesheet" href="../../css/style.css"> <!--- precisa colocar a constante -->
        <!-- meus icons -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" />

        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@1,900&family=Poppins:wght@200;300;400;600;700&family=Roboto:wght@200;300;400;500&display=swap" rel="stylesheet">
        
        <!-- link css datatable -->
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
    
    
    </head>
    <body>

    <div class="conteudo">
        <div class="container-conteudo-principal">

            <span class="separador"></span>

            <div class="container-itens-administracao">
                <a href="<?php echo BASE_URL . '/app/administracao/funcionario/index.php' ?>">
                    <div class="card" style="width: 15rem; min-height: 15rem; border: none">
                        <div class="card-body card-administracao">
                            <span class="material-symbols-rounded">
                                inbox_customize
                            </span>
                            <p class="card-title">Administração geral</p>
                        </div>
                    </div>
                </a>

                <a href="<?php echo BASE_URL . '/app/administracao/acessoArea/index.php' ?>">
                    <div class="card" style="width: 15rem; min-height: 15rem; border: none">
                        <div class="card-body card-administracao">
                            <span class="material-symbols-rounded">
                                switch_access_2
                            </span>
                            <p class="card-title">Controle nível de acesso</p>
                        </div>
                    </div>
                </a>

                <a href="<?php echo BASE_URL . '/app/administracao/logOperacao/index.php' ?>">
                    <div class="card" style="width: 15rem; min-height: 15rem; border: none">
                        <div class="card-body card-administracao">
                            <span class="material-symbols-rounded">
                                manage_search
                            </span>
                            <p class="card-title">Logs geral</p>
                        </div>
                    </div>
                </a>

            </div>

        </div>

    </div>

    <?php
        include __DIR__ . '/../../include/footer.php';
    ?>

    <!-- <script src="../../js/modal.js"></script> -->
    <script src="<?php echo BASE_URL ?>/js/modal.js"></script>
    <script src="<?php echo BASE_URL ?>/js/table.js"></script>

