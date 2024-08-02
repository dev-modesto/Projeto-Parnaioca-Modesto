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

            <div class="container-conteudo">
                <div class="mb-3 container-cabecalho-padrao">
                    <h1 class="modal-title fs-5 cor-8 peso-semi-bold" id="staticBackdropLabel">Verificar disponibilidade de reservas</h1>
                </div>

                <!-- formulario envio -->
                <form class="was-validated form-container" action="" method="post">

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="font-1-s" for="data-inicio">Data inicio <em>*</em></label>
                            <input class="form-control" type="date" name="data-inicio" id="data-inicio" required>
                        </div>
                        <div class="col-md-4">
                            <label class="font-1-s" for="hora-inicio">Hora inicio</label>
                            <input class="form-control" type="time" name="hora-inicio" id="hora-inicio" value="13:00" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">

                        <div class="col-md-4">
                            <label class="font-1-s" for="data-final">Data final <em>*</em></label>
                            <input class="form-control" type="date" name="data-final" id="data-final" required>
                        </div>

                        <div class="col-md-4">
                            <label class="font-1-s" for="hora-final">Hora final</label>
                            <input class="form-control" type="time" name="hora-final" id="hora-final" value="11:00" disabled>
                        </div>
                        
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="id-tp-acomodacao">Tipo acomodação <em>*</em></label>
                            <select class="form-select" name="id-tp-acomodacao" id="id-tp-acomodacao" required aria-label="select example">
                                <option value="">-</option>
                                
                                <?php
                                    $sqlTipoAcomodacao = "SELECT * FROM tbl_tp_acomodacao";
                                    $consultaTpAcomodacao = mysqli_query($con, $sqlTipoAcomodacao);

                                    while($row = mysqli_fetch_assoc($consultaTpAcomodacao)){
                                        echo "<option value='" . $row['id_tp_acomodacao'] . "'>" . $row['nome_tp_acomodacao'] . "</option>";
                                    }
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="invalid-feedback-diverso" style="color: red; "></div>
                    </div>


                    <div class="mb-3">
                        <div class="col-md-4">
                            <button class='btn btn-primary btn-verificar-disponibilidade'>Verificar</button>
                        </div>
                    </div>

                    <?php if(!empty($mensagem)){ ?>  
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo $mensagem ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div> 
                    <?php } else {
                            echo '';
                        }
                    ?>
                </form>
            </div>

            <div class="container-cards-reservas">
            </div>

            <div class="modalNovaReserva">
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
        $('.btn-verificar-disponibilidade').click(function (e) { 
            e.preventDefault();

            console.log("Clicou no botão!!");

            var idTipoAcomodacao = $("#id-tp-acomodacao").val();
            var dtInicio = $("#data-inicio").val();
            var dtFim = $("#data-final").val();
            var horaCheckIn = $("#hora-inicio").val();
            var horaCheckOut = $("#hora-final").val();

            $.ajax({
                type: "POST",
                url: "include/cPesquisaDisponibilidadeReserva.php",
                data: {
                    '.btn-verificar-disponibilidade':true,
                    'id-tipo-acomodacao':idTipoAcomodacao,

                    'dt-inicio':dtInicio,
                    'dt-fim':dtFim,
                    'hora-check-in':horaCheckIn,
                    'hora-check-out':horaCheckOut
                },
                success: function (response) {

                    if(response.mensagem) {
                        console.log(response);
                        $('.invalid-feedback-diverso').text(response.mensagem);
                        
                    } else {
                        $('.invalid-feedback-diverso').text("");
                    }

                    $('.container-cards-reservas').html(response)
                    
                }
            });
        });
    });

</script>



