<?php
    ob_start();
    $setorPagina = "SAC";
    $pagina = "Reservas";
    $grupoPagina = "";
    $tituloMenuPagina = "Reservas";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    include ARQUIVO_FUNCAO_SQL;
    
    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaSac($con, $idLogado);
    }

    if (isset($_GET['click-btn-reservar']) && $_GET['click-btn-reservar'] === 'true') {
        $idAcomodacao = $_GET['id-acomodacao'];
        $dataInicio = $_GET['data-inicio'];
        $dataFim = $_GET['data-fim'];

        $consulta = consultaInfoTipoAcomodacao($con, 0, $idAcomodacao);
        $array = mysqli_fetch_assoc($consulta);
    } 

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
    <link rel="stylesheet" href="../../../css/style.css"> <!--- precisa colocar a constante -->
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

            <div class="form-container reservas cabecalho">
                <div class="container-cabecalho-padrao">
                    <h1 class="modal-title fs-5 cor-8 peso-semi-bold" id="staticBackdropLabel">Reserva</h1>
                    <span class="cor-6"><?php echo $array['nome_acomodacao']?> - <?php echo $array['numero_acomodacao']?> </span>
                </div>
            </div>

            <!-- formulario envio -->
            <form class="was-validated form-container reservas" action="include/gNovaReserva.php" method="post" data-id-acomodacao="<?php echo $idAcomodacao ?>">

                <div class="container-progresso-nova-reserva">
                    <div class="hospede">
                        <span class="progresso ativo confirmado"></span>
                        <p class="font-1-xs cor-8">Hóspede</p>
                    </div>
                    <div class="info-reserva">
                        <span class="progresso"></span>
                        <p class="font-1-xs cor-6">Informações da reserva</p>
                    </div>
                    <div class="pagamento">
                        <span class="progresso"></span>
                        <p class="font-1-xs cor-6">Pagamento</p>
                    </div>
                </div>

                <br>

                <div class="tab-content" id="myTabContent">
                    <!-- hospede -->
                    <div class="tab-hospede tab-pane fade show active" id="hospedes-pane" role="tabpanel" aria-labelledby="hospedes" tabindex="0">

                        <span class="separador-botao"></span>

                        <div class="conteudo-nova-reserva teste">

                    
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-1-s" for="cpf">CPF</label>
                                    <input class="form-control cpf" type="text" name="cpf" id="cpf" value="" required >
                                </div>

                                <div class="col-md-6">
                                    <label class="font-1-s" for="nome">Nome completo</label>
                                    <input class="form-control" type="text" name="nome" id="nome" value="" disabled required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="font-1-s" for="total-hospede">Total de hóspedes</label>
                                    <input class="form-control" type="number" min="1" max="" name="total-hospede" id="total-hospede" value="" >
                                </div>
                            </div>

                        </div>

                        <span class="separador-botao"></span>

                        <div class="row mb-3 footer-container-button-reserva">
                            <div class="col-md-6 form-container-button-reserva">
                                <!-- <button class='btn btn-primary btn-avancar info'>Avançar</button> -->
                                <a class="btn btn-primary btn-avancar info">Avançar</a>
                            </div>
                        </div>

                    </div>

                    <!-- info reserva -->
                    <div class="tab-reserva tab-pane fade" id="info-reserva-pane" role="tabpanel" aria-labelledby="info-reserva" tabindex="0">
                    
                        <span class="separador-botao"></span>

                        <div class="conteudo-nova-reserva teste">

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="font-1-s" for="acomodacao">Acomodação</label>
                                    <input class="form-control acomodacao" type="text" name="acomodacao" id="acomodacao" value="<?php echo $array['nome_acomodacao']?>"  disabled  required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-1-s" for="numero-acomodacao">Número</label>
                                    <input class="form-control" type="text" name="numero-acomodacao" id="numero-acomodacao" value="<?php echo $array['numero_acomodacao']?>" disabled required>
                                </div>

                                <div class="col-md-3">
                                    <label class="font-1-s" for="data-inicio">Data inicio</label>
                                    <input class="form-control" type="text" name="data-inicio" id="data-inicio" value="<?php echo $dataInicio ?>" disabled required>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="font-1-s" for="data-final">Data final</label>
                                    <input class="form-control" type="text" name="data-final" id="data-final" value="<?php echo $dataFim ?>" disabled required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-1-s" for="valor-diaria">Valor diária</label>
                                    <input class="form-control monetario" type="text" name="valor-diaria" id="valor-diaria" value="<?php echo $array['valor']?>" disabled required>
                                </div>

                                <div class="col-md-6">
                                    <label class="font-1-s" for="valor-reserva-total">Valor reserva total</label>
                                    <input class="form-control monetario" type="text" name="valor-reserva-total" id="valor-reserva-total" value="" disabled required>
                                </div>
                            </div>

                        </div>

                        <span class="separador-botao"></span>

                        <div class="row mb-3 footer-container-button-reserva">
                            <div class="col-md-6 form-container-button-reserva">
                                <a class='btn btn-secondary btn-modal-cancelar btn-retornar hospede'>Retornar</a>
                                <a class='btn btn-primary btn-avancar pagamento'>Avançar</a>
                                <!-- <button class='btn btn-secondary btn-modal-cancelar btn-retornar hospede'>Retornar</button> -->
                                <!-- <button class='btn btn-primary btn-avancar pagamento'>Avançar</button> -->
                            </div>
                        </div>


                    </div>

                    <!-- pagamento -->
                    <div class="tab-pagamento tab-pane fade" id="pagamento-pane" role="tabpanel" aria-labelledby="pagamento" tabindex="0">
                    <span class="separador-botao"></span>

                    <div class="conteudo-nova-reserva teste">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="font-1-s" for="forma-pagamento">Forma de pagamento</label>
                                <input class="form-control" type="text" name="forma-pagamento" id="forma-pagamento" value="">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="font-1-s" for="valor-entrada">Valor de entrada</label>
                                <input class="form-control monetario" type="text" name="valor-entrada" id="valor-entrada" value="">
                            </div>

                            <div class="col-md-6">
                                <label class="font-1-s" for="valor-restante">Valor restante</label>
                                <input class="form-control monetario" type="text" name="valor-restante" id="valor-restante" disabled>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="font-1-s" for="valor-reserva-total-2">Valor reserva total</label>
                                <input class="form-control monetario" type="text" name="valor-reserva-total-2" id="valor-reserva-total-2" value="" disabled required>
                            </div>
                        </div>

                        </div>

                        <span class="separador-botao"></span>

                        <div class="row mb-3 footer-container-button-reserva">
                            <div class="col-md-6 form-container-button-reserva">
                                <a class='btn btn-secondary btn-modal-cancelar btn-retornar info'>Retornar</a>
                                <!-- <button class='btn btn-secondary btn-modal-cancelar btn-retornar info'>Retornar</button> -->
                                <button class='btn btn-primary btn-avancar finalizar' type="submit">Finalizar</button>
                            </div>
                        </div>
                
                    </div>

                    <ul class="nav nav-links-reservas">
                        <button class="nav-link active" id="hospede" data-bs-toggle="tab" data-bs-target="#hospedes-pane" type="button" role="tab" aria-controls="hospedes-pane" aria-selected="true">Dados cliente</button>
                        <button class="nav-link" id="info-reserva" data-bs-toggle="tab" data-bs-target="#info-reserva-pane" type="button" role="tab" aria-controls="info-reserva-pane" aria-selected="false">Informações da reserva</button>
                        <button class="nav-link" id="pagamento" data-bs-toggle="tab" data-bs-target="#pagamento-pane" type="button" role="tab" aria-controls="pagamento-pane" aria-selected="false">Pagamento</button>
                    </ul>
                    
                </div>

                <?php if(!empty($mensagem)){ ?>  
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $mensagem ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div> 
                <?php }else {
                        echo '';
                    }
                ?>
            </form>
        </div>

    </div>

<?php
    include ARQUIVO_FOOTER;
    ob_end_flush();
?>

<script src="<?php echo BASE_URL ?>/js/modal.js"></script>
<script src="<?php echo BASE_URL ?>/js/table.js"></script>

<script>
        $('.cpf').mask('000.000.000-00', {reverse: true});
</script>


<script>

    var tabHospede = document.getElementById("hospede");
    
    var btnAvancarInfo = document.querySelector(".btn-avancar.info");
    var tabInfoReserva = document.getElementById("info-reserva");

    var btnAvancarPagamento = document.querySelector(".btn-avancar.pagamento");
    var tabInfoPagamento = document.getElementById("pagamento");

    btnAvancarInfo.addEventListener("click", function () {
        tabInfoReserva.click();
    })

    btnAvancarPagamento.addEventListener("click", function () {
        tabInfoPagamento.click();
    })

    var hospede = document.querySelector(".tab-hospede");

    var btnRetornarHospede = document.querySelector(".btn-retornar.hospede");
    btnRetornarHospede.addEventListener("click", function () {
        tabHospede.click();
    })

    var btnRetornarInfo = document.querySelector(".btn-retornar.info");
    btnRetornarInfo.addEventListener("click", function () {
        tabInfoReserva.click();
    })

    document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(function(tabButton) {
        tabButton.addEventListener('shown.bs.tab', function (event) {
            var ativarTab = event.target.id;

            var progressoHospede = document.querySelector(".hospede span");
            var progressoInfo = document.querySelector(".info-reserva span");
            var progressoPagamento = document.querySelector(".pagamento span");

            if (ativarTab === "hospede") {
                progressoHospede.classList.add("ativo")
                progressoInfo.classList.remove("ativo")

            } else if (ativarTab === "info-reserva") {
                progressoHospede.classList.remove("ativo")
                progressoInfo.classList.add("ativo")
                progressoInfo.classList.add("confirmado")
                progressoPagamento.classList.remove("ativo")

            } else if (ativarTab === "pagamento") {
                progressoPagamento.classList.add("ativo")
                progressoPagamento.classList.add("confirmado")
                progressoInfo.classList.remove("ativo")
            }
        });
    });

</script>
