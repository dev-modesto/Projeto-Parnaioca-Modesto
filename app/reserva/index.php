<?php
    ob_start();
    $setorPagina = "SAC";
    $pagina = "Reservas";
    $grupoPagina = "Reservas";
    $tituloMenuPagina = "Reservas";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    include ARQUIVO_FUNCAO_SQL;
    include ARQUIVO_FUNCAO_SQL_RESERVA;
    include PASTA_FUNCOES . "funcaoData.php";
    
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

    // ID de status das reservas
        $pendente = 1;
        $confirmado = 2;
        $cancelado = 3;
        $checkIn = 4;
        $checkOut = 5;
        $finalizado = 6;
    // 

    // 
        $sqlTotalHospedes = 
            "SELECT COALESCE(SUM(total_hospedes), 0) AS total_hospedes 
            FROM tbl_reserva 
            WHERE (dt_reserva_inicio <= '$dataAtual 23:59:59' AND dt_reserva_fim >= '$dataAtual 00:00:00')
            AND id_status_reserva = '$checkIn'
        ";

        // informações referentes a data atual
        $totalPendentes = totalStatusReservaAtual($con, $dataAtual, $pendente);
        $totalConfirmados = totalStatusReservaAtual($con, $dataAtual, $confirmado);
        $totalFinalizados = totalStatusReservaAtual($con, $dataAtual, $finalizado);
        $totalCheckIn = totalStatusReservaAtual($con, $dataAtual, $checkIn);
        $totalCheckOut = totalStatusReservaAtual($con, $dataAtual, $checkOut);
        $totalCancelados = totalStatusReservaAtual($con, $dataAtual, $cancelado);
        
        $consultaHospedes = mysqli_query($con, $sqlTotalHospedes);
        $arrayTotalHospedes = mysqli_fetch_assoc($consultaHospedes);
        $totalHospedes = $arrayTotalHospedes['total_hospedes'];
    // 


    $diaDataHoje = diaSemanaPtbr($diaSemanaIngles) . ", " . $dataAtualPtbr;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/global/global.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/navbar/navbar-lateral.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/navbar/navbar-top.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/tipografia.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/cores.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/componentes.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/modal.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/formulario.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/cards-info.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/reserva/disponibilidade-reserva.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/reserva/visao-geral-reservas.css'?>">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@1,900&family=Poppins:wght@200;300;400;500;600;700&family=Roboto:wght@200;300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
</head>
<body>

    <?php 
        include ARQUIVO_NAVBAR;
    ?>

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
                            <button id="limpar-filtro"><span class="material-symbols-rounded">cleaning_services</span></button>
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
                            <span class="valor font-1-xxxl " id="total-hospedes"><?php echo $totalHospedes ?></span>
                            <p class="sub info font-1 cor-2">Hóspedes</p>
                        </div>
                    </div>

                    <div class="card-dash card-confirmados">
                        <div class="card-dash-reserva-conteudo">
                            <p class="titulo peso-leve ">Total</p>
                            <span class="valor font-1-xxxl cor-a-green3" id="total-confirmados"><?php echo $totalConfirmados ?></span>
                            <p class="sub info font-1 cor-2">Confirmados</p>
                        </div>
                    </div>

                    <div class="card-dash card-check-in">
                    <div class="card-dash-reserva-conteudo">
                            <p class="titulo peso-leve ">Total</p>
                            <span class="valor font-1-xxxl cor-a-blue3" id="total-check-in"><?php echo $totalCheckIn ?></span>
                            <p class="sub info font-1 cor-2">Check-in</p>
                        </div>
                    </div>

                    <div class="card-dash card-check-out">
                        <div class="card-dash-reserva-conteudo">
                            <p class="titulo peso-leve ">Total</p>
                            <span class="valor font-1-xxxl cor-a-purple3" id="total-check-out"><?php echo $totalCheckOut ?></span>
                            <p class="sub info font-1 cor-2">Check-out</p>
                        </div>
                    </div>

                    <div class="card-dash card-pendentes">
                        <div class="card-dash-reserva-conteudo">
                            <p class="titulo peso-leve ">Total</p>
                            <span class="valor font-1-xxxl cor-a-yellow3" id="total-pendentes"><?php echo $totalPendentes ?></span>
                            <p class="sub info font-1 cor-2">Pendentes</p>
                        </div>
                    </div>

                    <div class="card-dash card-cancelados">
                        <div class="card-dash-reserva-conteudo">
                            <p class="titulo peso-leve ">Total</p>
                            <span class="valor font-1-xxxl cor-a-red3 cancelados" id="total-cancelados"><?php echo $totalCancelados ?></span>
                            <p class="sub info font-1 cor-2">Cancelados</p>
                        </div>
                    </div>
                </div>

            </div>

            <span class="separador"></span>

            <div class="conteudo-dash">
                <?php 
                    include "include/cFiltrarDatasReservas.php";
                
                ?>
            </div>
               
        </div>

    </div>

<?php
    include ARQUIVO_FOOTER;
    ob_end_flush();
?>

<script src="<?php echo BASE_URL ?>/js/modal.js"></script>

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
                    $('.conteudo-dash').html(response);
                }
            });

            $.ajax({
                type: "POST",
                url: "include/cFiltroTotais.php",
                data: {
                    'data-inicio':dataInicio,
                    'data-final':dataFinal
                },

                success: function (arrayTotalStatus) {
                    if(arrayTotalStatus !== "") {
                        $('#total-hospedes').text(arrayTotalStatus.totalHospedes);
                        $('#total-confirmados').text(arrayTotalStatus.totalConfirmados);
                        $('#total-check-in').text(arrayTotalStatus.totalCheckIn);
                        $('#total-check-out').text(arrayTotalStatus.totalCheckOut);
                        $('#total-pendentes').text(arrayTotalStatus.totalPendentes);
                        $('#total-cancelados').text(arrayTotalStatus.totalCancelados);

                    } else {
                        $('#total-confirmados').text('');
                        $('#total-check-in').text('');
                        $('#total-check-out').text('');
                        $('#total-pendentes').text('');
                        $('#total-cancelados').text('');
                    }
                }
            });
        });
    });

</script>

<script>

    btnLimparFiltro = document.getElementById('limpar-filtro');
    btnLimparFiltro.addEventListener('click', function(){
        window.location.href = '../reserva/index.php';
    })

</script>


<script>

    $(document).ready(function () {
        $('body').on('click', '.card-container-disponibilidade-reserva', function (e) { 
            e.preventDefault();

            $('.card-container-disponibilidade-reserva').data('id-reserva');

            var idReserva = $(this).closest('.card-container-disponibilidade-reserva').data('id-reserva');
            var queryString = $.param({
                'click-reserva':true,
                'id-reserva':idReserva
            });

            window.location.href = "include/cInformacaoReserva.php?" + queryString;
        });
    });

</script>