<?php
    ob_start();
    $setorPagina = "SAC";
    $pagina = "Reservas";
    $grupoPagina = "Reservas";
    $tituloMenuPagina = "Reservas";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    // include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_FUNCAO_SQL;
    
    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        $nome = $_SESSION['nome'];
        segurancaSac($con, $idLogado);
    }

    date_default_timezone_set('America/Sao_Paulo');
    $extraiData = new DateTimeImmutable();
    $dataAtual = date_format($extraiData, "Y-m-d");
    $dataAtualPtbr = date_format($extraiData, "d/m/Y");

    $diaSemanaIngles = strval( date_format($extraiData, 'l'));

    $sqlTotalHospedes = "SELECT SUM(total_hospedes) as total_hospedes from tbl_reserva WHERE dt_reserva_inicio >= '$dataAtual'";
    $consultaHospedes = mysqli_query($con, $sqlTotalHospedes);
    $arrayTotalHospedes = mysqli_fetch_assoc($consultaHospedes);
    $totalHospedes = $arrayTotalHospedes['total_hospedes'];

    $diaDataHoje = diaSemanaPtbr($diaSemanaIngles) . ", " . $dataAtualPtbr;
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
        <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@1,900&family=Poppins:wght@200;300;400;500;600;700&family=Roboto:wght@200;300;400;500&display=swap" rel="stylesheet">
        
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

            

            <div class="container-conteudo dash-reserva">
                <div class="container-data-dash-reserva">
                    <div class="info-data-dash-reserva">
                        <p><?php echo $diaDataHoje ?></p>
                    </div>
                    <form class="form-container filtro-data-dash-reserva" id="form-data-filtro-dash" action="" method="post">
                        <div class="container-data-dash-inputs">
                            <div class="mb-3 data-dash">
                                <label class="font-1-s" for="data-inicio">Data inicio</label>
                                <input class="form-control data-dash-reserva" type="date" name="data-inicio" id="data-inicio" required>
                            </div>
                            <div class="mb-3 data-dash">
                                <label class="font-1-s" for="data-final">Data final</label>
                                <input class="form-control data-dash-reserva" type="date" name="data-final" id="data-final" required>
                            </div>
                        </div>
                        <div class="container-data-dash-botao">
                            <button id="btn-filtrar-dash"><span class="material-symbols-rounded">check</span></button>
                            <button><span class="material-symbols-rounded">cleaning_services</span></button>
                        </div>
                    </form>
                </div>
                <div class="container-cards-dash-reserva">

                    <div class="card-dash card-bem-vindo">
                        <div class="card-dash-reserva-conteudo cor-p6 conteudo-bem-vindo">
                            <p class="sub font-1-xm peso-medio">Olá, <?php echo $nome ?>!<br> Bem vindo de volta.</p>
                            <p class="font-1-s texto-sub">Acompanhe aqui o andamento das reservas da pousada.</p>
                        </div>
                    </div>

                    <div class="card-dash card-hospedes ">
                        <div class="card-dash-reserva-conteudo">
                            <p class="titulo peso-leve">Total</p>
                            <span class="valor font-1-xxxl "><?php echo $totalHospedes ?></span>
                            <p class="sub info font-1 cor-2">Hóspedes</p>
                        </div>
                    </div>

                    <div class="card-dash card-confirmados">
                        <div class="card-dash-reserva-conteudo">
                            <p class="titulo peso-leve ">Total</p>
                            <span class="valor font-1-xxxl cor-a-green3">11</span>
                            <p class="sub info font-1 cor-2">Confirmados</p>
                        </div>
                    </div>

                    <div class="card-dash card-check-in">
                    <div class="card-dash-reserva-conteudo">
                            <p class="titulo peso-leve ">Total</p>
                            <span class="valor font-1-xxxl cor-a-blue3">9</span>
                            <p class="sub info font-1 cor-2">Check-in</p>
                        </div>
                    </div>

                    <div class="card-dash card-check-out">
                        <div class="card-dash-reserva-conteudo">
                            <p class="titulo peso-leve ">Total</p>
                            <span class="valor font-1-xxxl cor-a-purple3">2</span>
                            <p class="sub info font-1 cor-2">Check-out</p>
                        </div>
                    </div>

                    <div class="card-dash card-pendentes">
                        <div class="card-dash-reserva-conteudo">
                            <p class="titulo peso-leve ">Total</p>
                            <span class="valor font-1-xxxl cor-a-yellow3">3</span>
                            <p class="sub info font-1 cor-2">Pendentes</p>
                        </div>
                    </div>

                    <div class="card-dash card-cancelados">
                        <div class="card-dash-reserva-conteudo">
                            <p class="titulo peso-leve ">Total</p>
                            <span class="valor font-1-xxxl cor-a-red3">1</span>
                            <p class="sub info font-1 cor-2">Cancelados</p>
                        </div>
                    </div>
                </div>

            </div>

            <span class="separador"></span>

            <div class="container-conteudo dash">
                    <?php
                        $sqlConsultaReservas = 
                            "SELECT 
                                r.id_reserva,
                                r.id_acomodacao,
                                r.id_cliente,
                                r.dt_reserva_inicio,
                                r.dt_reserva_fim,
                                r.id_status_reserva,
                                s.nome_status_reserva
                            FROM tbl_reserva r
                            INNER JOIN tbl_status_reserva s
                            ON r.id_status_reserva = s.id_status_reserva
                        ";
                        $consultaReservas = mysqli_query($con, $sqlConsultaReservas);
                        $numeroLinhas = mysqli_num_rows($consultaReservas);

                        while($arrayReservas = mysqli_fetch_assoc($consultaReservas)) {
                            $idAcomodacao = $arrayReservas['id_acomodacao'];
                            $idStatusReserva = $arrayReservas['id_status_reserva'];

                            $dtReservaInicio = $arrayReservas['dt_reserva_inicio'];
                            $dtReservaFim = $arrayReservas['dt_reserva_fim'];
                            $dtReservaInicioFormatar = new DateTime($dtReservaInicio);
                            $dtReservaFimFormatar = new DateTime($dtReservaFim);
                            $dtReservaInicioFormatada = date_format($dtReservaInicioFormatar, "d/m/Y");
                            $dtReservaFimFormatada = date_format($dtReservaFimFormatar, "d/m/Y");
                            
                            $consultaInfoAcomodacao = consultaInfoAcomodacao($con, 0, $idAcomodacao);
                            $arrayInfoAcomodacao = mysqli_fetch_assoc($consultaInfoAcomodacao);

                            ?>
                                
                                <div class="card card-container-disponibilidade-reserva dash disponivel" data-id-acomodacao="<?php  ?>" data-data-inicio="<?php ?>" data-data-fim="<?php ?>">
                                    <div class="card-reserva-dash-top">
                                        <div class="disp-reserva-nome dash">
                                            <div class="card-reserva-cabecalho dash">
                                                <span class="material-symbols-rounded">hotel</span>
                                                <p class="cor-4">Reserva - #<?php echo $arrayReservas['id_reserva']?></p>
                                            </div>
                                    
                                            <div class="disp-reserva-nome-info dash">
                                                <p class="card-title font-1-l cor-8"><?php echo $arrayInfoAcomodacao['nome_acomodacao']?></p>
                                                <p class="font-1-xm cor-8"><?php echo $arrayInfoAcomodacao['numero_acomodacao']?></p>
                                            </div>
                                        </div>
                                        
                                        <div class="disp-reserva-status dash disponivel">
                                            <p class="cor-6"><?php echo $arrayReservas['nome_status_reserva']?><span></span></p>
                                        </div>
                                    </div>
                                    
                                    <div class="disp-reserva-data dash">
                                        <p class="cor-6 font-1-xs" >Período estadia</p>
                                        <div class="disp-reserva-data-periodo">
                                            <div>
                                                <p class="cor-5 font-1-xxs peso-leve"> <?php echo $dtReservaInicioFormatada ?> - <?php echo $dtReservaFimFormatada ?><p>
                                            </div>
                                        </div>
                                    </div>
                    
                                </div>
                            
                            <?php
                        }
                    ?>
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

    $(document).ready(function () {

        $('#form-data-filtro-dash').on('submit', function (e) { 
            e.preventDefault();

            var dataInicio = $('#data-inicio').val();
            var dataFinal = $('#data-final').val();

            $.ajax({
                type: "POST",
                url: "include/cFiltrarDatasReservas.php",
                data: {
                    'data-inicio':dataInicio,
                    'data-final':dataFinal
                },
                success: function (response) {
                    console.log(response);
                }
            });
        });
    });

</script>



