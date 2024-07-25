<?php
    ob_start();
    $setorPagina = "SAC";
    $pagina = "Reservas";
    $grupoPagina = "Reservas";
    $tituloMenuPagina = "Reservas";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    
    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaSac($con, $idLogado);
    }

    $sql = "SELECT * FROM tbl_item";
    $consulta = mysqli_query($con, $sql);
?>

    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reservas</title>
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

            <span class="separador"></span>

            <div class="container-conteudo dash-reserva">
                <div class="container-cards-dash-reserva">
                    <div class="card-dash card-confirmados">
                        <div class="card-dash-reserva-cabecalho">
                            <span class="material-symbols-rounded icone-dash-reserva">hotel</span>
                            <div class="identificador-status"></div>
                        </div>
                        <div class="card-dash-reserva-conteudo">
                            <p class="font-1-xxxl cor-a-green3">4</p>
                            <p class="font-1-l">Confirmadas</p>
                        </div>
                    </div>

                    <div class="card-dash card-check-in">
                        <div class="card-dash-reserva-cabecalho">
                            <span class="material-symbols-rounded icone-dash-reserva">hotel</span>
                            <div class="identificador-status cor-p1"></div>
                        </div>
                        <div class="card-dash-reserva-conteudo">
                            <p class="font-1-xm peso-medio">2</p>
                            <p class="font-2-xs">Check-in</p>
                        </div>
                    </div>

                    <div class="card-dash card-check-out">
                        <div class="card-dash-reserva-cabecalho">
                            <span class="material-symbols-rounded icone-dash-reserva">hotel</span>
                            <div class="identificador-status"></div>
                        </div>
                        <div class="card-dash-reserva-conteudo">
                            <p class="font-1-xm peso-medio">2</p>
                            <p class="font-2-xs">Check-out</p>
                        </div>
                    </div>

                    <div class="card-dash card-pendentes">
                     <div class="card-dash-reserva-cabecalho">
                            <span class="material-symbols-rounded icone-dash-reserva">hotel</span>
                            <div class="identificador-status"></div>
                        </div>
                        <div class="card-dash-reserva-conteudo">
                            <p class="font-1-xm peso-medio">2</p>
                            <p class="font-2-xs">Pendentes</p>
                        </div>
                    </div>

                    <div class="card-dash card-cancelados">
                        <div class="card-dash-reserva-cabecalho">
                            <span class="material-symbols-rounded icone-dash-reserva">hotel</span>
                            <div class="identificador-status"></div>
                        </div>
                        <div class="card-dash-reserva-conteudo">
                            <p class="font-1-xm peso-medio">2</p>
                            <p class="font-2-xs">Cancelados</p>
                        </div>
                    </div>

                    <div class="card-dash card-finalizados">
                        <div class="card-dash-reserva-cabecalho">
                            <span class="material-symbols-rounded icone-dash-reserva">hotel</span>
                            <div class="identificador-status"></div>
                        </div>
                        <div class="card-dash-reserva-conteudo">
                            <p class="font-1-xm peso-medio">2</p>
                            <p class="font-2-xs">Finalizados</p>
                        </div>
                    </div>

                    <div class="card-dash card-calendario">

                    </div>
                </div>

            </div>

            <div class="container-conteudo">
               
            </div>

        </div>

    </div>

    <?php
        include ARQUIVO_FOOTER;
        ob_end_flush();
    ?>

    <script src="<?php echo BASE_URL ?>/js/modal.js"></script>
    <script src="<?php echo BASE_URL ?>/js/table.js"></script>

<script>

</script>



