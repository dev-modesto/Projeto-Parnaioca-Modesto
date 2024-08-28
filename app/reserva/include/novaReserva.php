<?php
    ob_start();
    $setorPagina = "SAC";
    $pagina = "Reservas";
    $grupoPagina = "";
    $tituloMenuPagina = "Reservas";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    include ARQUIVO_FUNCAO_SQL;
    include PASTA_FUNCOES . "funcaoData.php";
    
    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaSac($con, $idLogado);
    }

    if (isset($_GET['click-btn-reservar']) && $_GET['click-btn-reservar'] === 'true') {
        $idAcomodacao = $_GET['id-acomodacao'];
        $dataInicio = $_GET['data-inicio'];
        $dataFim = $_GET['data-fim'];

        try {
            $dateTimeInicio = new DateTime($dataInicio);
            $dateTimeFim = new DateTime($dataFim);

        } catch (Exception $e) {
            $mensagem = "Datas inválidas. Não foi possível prosseguir com a reserva.";
            header('location: ../disponibilidade.php?msgInvalida=' . $mensagem);
            die();
        }

        $intervalo = $dateTimeInicio->diff($dateTimeFim);
        $qntDias = $intervalo->days;

        $dataInicioFormatada = date_format($dateTimeInicio, "d/m/Y");
        $dataFimFormatada = date_format($dateTimeFim, "d/m/Y");

        $consulta = consultaInfoAcomodacao($con, 0, $idAcomodacao);
        $array = mysqli_fetch_assoc($consulta);
        $capacidadeAcomodacao = $array['capacidade_max'];
        $valorDiaria = $array['valor'];
        $valorReservaTotal = ($valorDiaria * $qntDias);

        $valorDiariaFormatado = number_format($valorDiaria, 2, '.', '');
        $valorReservaTotalFormatado = number_format($valorReservaTotal, 2, '.', '');

    } 

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
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/tabela.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/cards-info.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/setor/setor.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/login/login.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/reserva/disponibilidade-reserva.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/reserva/visao-geral-reservas.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/reserva/consumo-frigobar-reserva.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/reserva/info-reserva.css'?>"> 

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@1,900&family=Poppins:wght@200;300;400;600;700&family=Roboto:wght@200;300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
</head>
<body>

    <?php 
        include ARQUIVO_NAVBAR;
    ?>

    <div class="conteudo">
        <div class="container-conteudo-principal">

            <div class="form-container reservas cabecalho">
                <div class="container-cabecalho-padrao">
                    <h1 class="modal-title fs-5 cor-8 peso-semi-bold" id="staticBackdropLabel">Reserva</h1>
                    <span class="cor-6"><?php echo $array['nome_acomodacao']?> - <?php echo $array['numero_acomodacao']?> </span>
                </div>
            </div>

            <!-- formulario envio -->
            <form class="form-container reservas" id="reservaForm" data-id-acomodacao="<?php echo $idAcomodacao ?>" data-id-cliente="" data-data-inicio="<?php echo $dataInicio ?>" data-data-fim="<?php echo $dataFim ?>">

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

                        <div class="conteudo-nova-reserva">

                    
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-1-s" for="cpf">CPF <em>*</em></label>
                                    <input class="form-control cpf input-cpf" type="text" name="cpf" id="cpf" value="" required >
                                    <div class="invalid-feedback">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="font-1-s" for="nome">Nome completo</label>
                                    <input class="form-control" type="text" name="nome" id="nome" value="" disabled required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label class="font-1-s" for="total-hospedes">Total de hóspedes <em>*</em></label>
                                    <input class="form-control total-hospedes" type="number" min="1" max="<?php echo $capacidadeAcomodacao ?>" name="total-hospedes" id="total-hospedes" disabled required>
                                </div>
                                <div class="invalid-feedback-hospedes" style="color: red; font-size: .875em" ></div>
                            </div>

                        </div>

                        <span class="separador-botao"></span>

                        <div class="row mb-3 footer-container-button-reserva">
                            <div class="col-md-6 form-container-button-reserva">
                                <a class="btn btn-primary btn-avancar dados disabled-button info" aria-disabled="true">Avançar</a>
                            </div>
                        </div>

                    </div>

                    <!-- info reserva -->
                    <div class="tab-reserva tab-pane fade" id="info-reserva-pane" role="tabpanel" aria-labelledby="info-reserva" tabindex="0">
                    
                        <span class="separador-botao"></span>

                        <div class="conteudo-nova-reserva">

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
                                    <input class="form-control" type="text" name="data-inicio" id="data-inicio" value="<?php echo $dataInicioFormatada ?>" disabled required>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="font-1-s" for="data-final">Data final</label>
                                    <input class="form-control" type="text" name="data-final" id="data-final" value="<?php echo $dataFimFormatada ?>" disabled required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-1-s" for="valor-diaria">Valor diária</label>
                                    <input class="form-control monetario" type="text" name="valor-diaria" id="valor-diaria" value="<?php echo $valorDiariaFormatado ?>" disabled required>
                                </div>

                                <div class="col-md-6">
                                    <label class="font-1-s" for="valor-reserva-total">Valor reserva total</label>
                                    <input class="form-control monetario" type="text" name="valor-reserva-total" id="valor-reserva-total" value="<?php echo $valorReservaTotalFormatado ?>" disabled required>
                                </div>
                            </div>

                        </div>

                        <span class="separador-botao"></span>

                        <div class="row mb-3 footer-container-button-reserva">
                            <div class="col-md-6 form-container-button-reserva">
                                <a class='btn btn-secondary btn-modal-cancelar btn-retornar hospede'>Retornar</a>
                                <a class='btn btn-primary btn-avancar pagamento'>Avançar</a>
                            </div>
                        </div>


                    </div>

                    <!-- pagamento -->
                    <div class="tab-pagamento tab-pane fade" id="pagamento-pane" role="tabpanel" aria-labelledby="pagamento" tabindex="0">
                        <span class="separador-botao"></span>

                        <div class="conteudo-nova-reserva">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="id-forma-pagamento">Forma de pagamento <em>*</em></label>
                                    <select class="form-select"  name="id-forma-pagamento" id="id-forma-pagamento" required aria-label="select example">
                                        <option value="">-</option>
                                        <?php
                                            $sqlStatus = "SELECT id_metodo_pag, nome_metodo_pag FROM tbl_metodo_pagamento";
                                            $consultaa = mysqli_query($con, $sqlStatus);

                                            while($arrayStatus = mysqli_fetch_assoc($consultaa)) {
                                                    echo "<option value='" . $arrayStatus['id_metodo_pag'] . "' $selected>" . $arrayStatus['nome_metodo_pag'] . "</option>";
                                            }
                                            mysqli_close($con);
                                                
                                        ?>
                        
                                    </select>
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-1-s" for="valor-entrada">Valor de entrada</label>
                                    <input class="form-control monetario valor-entrada" type="text" name="valor-entrada" id="valor-entrada" value="">
                                </div>


                                <div class="col-md-6">
                                    <label class="font-1-s" for="valor-restante">Valor restante</label>
                                    <input class="form-control monetario" type="text" name="valor-restante" id="valor-restante" value="<?php echo $valorReservaTotalFormatado ?>" disabled>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="invalid-feedback-valor-pago" style="color: red; "></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label class="font-1-s" for="valor-reserva-total-2">Valor reserva total</label>
                                    <input class="form-control monetario" type="text" name="valor-reserva-total-2" id="valor-reserva-total-2" value="<?php echo $valorReservaTotalFormatado ?>" disabled required>
                                </div>
                            </div>

                            </div>

                            <span class="separador-botao"></span>

                            <div class="row mb-3 footer-container-button-reserva">
                                <div class="col-md-6 form-container-button-reserva">
                                    <a class='btn btn-secondary btn-modal-cancelar btn-retornar info'>Retornar</a>
                                    <button class='btn btn-primary btn-avancar finalizar' id="btn-finalizar-reserva" type="submit">Finalizar</button>
                                </div>
                            </div>
                    
                        </div>

                        <ul class="nav nav-links-reservas">
                            <button class="nav-link active" id="hospede" data-bs-toggle="tab" data-bs-target="#hospedes-pane" type="button" role="tab" aria-controls="hospedes-pane" aria-selected="true">Dados cliente</button>
                            <button class="nav-link" id="info-reserva" data-bs-toggle="tab" data-bs-target="#info-reserva-pane" type="button" role="tab" aria-controls="info-reserva-pane" aria-selected="false">Informações da reserva</button>
                            <button class="nav-link" id="pagamento" data-bs-toggle="tab" data-bs-target="#pagamento-pane" type="button" role="tab" aria-controls="pagamento-pane" aria-selected="false">Pagamento</button>
                        </ul>
                    </div>

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

<script>
    $('.cpf').mask('000.000.000-00', {reverse: true});

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


<script>
// pesquisa cliente

    $(document).ready(function () {

        var totalHospedes = $('.total-hospedes').attr('max');
        var inputTotalHospedes = $('.total-hospedes').val();
 
        function verificarTotalHospedes() {
            var valorTotal = $('.total-hospedes').val();
            var totalDigitada = Number(valorTotal);

            if (totalDigitada > totalHospedes) {
                $('.invalid-feedback-hospedes').text('Total de hóspedes superior à capacidade da acomodação.');
                $('.btn-avancar.dados').attr('aria-disabled', 'true');
                $('.btn-avancar.dados').addClass('disabled-button');

            } else {
                $('.invalid-feedback-hospedes').text(''); 
                $('.btn-avancar.dados').removeAttr('aria-disabled', 'true'); 
                $('.btn-avancar.dados').removeClass('disabled-button'); 
                $('.total-hospedes').removeAttr('disabled', '');
            }
        }

        function habilitaCampoTotalHospedes() {
            $('.total-hospedes').removeAttr('disabled', '');
        }

        function desabilitaCampoTotalHospedes() {
            $('.total-hospedes').attr('disabled', 'disabled');
            $('.total-hospedes').val('');
            $('.invalid-feedback-hospedes').text('');
            $('.btn-avancar.dados').attr('aria-disabled', 'true'); 
        }


        $('.cpf').keyup(function (e) { 
            var cpfCliente = $(this).val();

            $.ajax({
                type: "POST",
                url: "../include/cPesquisaCadastroCliente.php",
                data: {
                    'cpf-cliente': cpfCliente
                },

                success: function (response) {
                    if (response.sucesso) {
                        $('#nome').val(response.nomeCliente);
                        $('#reservaForm').data('id-cliente', response.idCliente);
                        $('.input-cpf').removeClass('is-invalid');
                        $('.input-cpf').addClass('is-valid');
                        $('.finalizar').removeAttr('disabled', '');

                        habilitaCampoTotalHospedes();

                        $('.total-hospedes').on('change keyup', function (e) {
                            verificarTotalHospedes();
                        });

                    } else {
                        desabilitaCampoTotalHospedes();
                        $('.input-cpf').removeClass('is-valid');
                        $('.input-cpf').addClass('is-invalid');
                        $('.invalid-feedback').text(response.mensagem);
                        $('#nome').val("");
                        $('#reservaForm').data('id-cliente', '');
                        $('.finalizar').attr('disabled', '');
                        $('.btn-avancar.dados').attr('aria-disabled', 'true');
                    }
                }
            });
        });


        var valorTotalReserva = $('#valor-reserva-total').val();
        valorTotalReservaFormatado = formatarValorVirgula(valorTotalReserva);

        $('#valor-entrada').keyup(function (e) { 
            valorEntradaDigitada = $(this).val();
            valorEntradaFormatado = formatarValorVirgula(valorEntradaDigitada);

            totalFormatado = valorTotalReservaFormatado - valorEntradaFormatado;

            if (valorEntradaFormatado < 0 ) {
                $('.valor-entrada').removeClass('is-valid');
                $('.valor-entrada').addClass('is-invalid');
                valorEntradaFormatado = 0;
                valorRestante = valorTotalReservaFormatado - valorEntradaFormatado;

            } else if (isNaN(valorEntradaFormatado)) {
                $('.valor-entrada').removeClass('is-invalid');
                $('.valor-entrada').removeClass('is-valid');
                valorRestante = valorTotalReservaFormatado;

            } else { 
                $('.valor-entrada').removeClass('is-invalid');
                $('.valor-entrada').addClass('is-valid');
                valorRestante = valorTotalReservaFormatado - valorEntradaFormatado;
            }

            if (totalFormatado < 0 ) {
                $('.invalid-feedback-valor-pago').text('Valor superior ao total restante.');
                $('.valor-entrada').addClass('is-invalid');
                $('#btn-finalizar-reserva').prop('disabled', true);

            } else {
                $('.invalid-feedback-valor-pago').text('');
                $('#btn-finalizar-reserva').prop('disabled', false);
            }
            valorRestanteFormatado = formatarValorNumero(valorRestante);

            $('#valor-restante').val(valorRestanteFormatado);
        });
    });


    

    $(document).ready(function() {
            $('#reservaForm').on('submit', function(e) {
                e.preventDefault();

                var idAcomodacao = $('#reservaForm').data('id-acomodacao');
                var idCliente = $('#reservaForm').data('id-cliente');
                var dataInicio = $('#reservaForm').data('data-inicio');
                var dataFim = $('#reservaForm').data('data-fim');

                $('#total-hospedes, #valor-diaria, #valor-entrada, #valor-reserva-total, #id-forma-pagamento').prop('disabled', false);
                var formData = $(this).serialize();
                $('#total-hospedes, #valor-diaria, #valor-entrada, #valor-reserva-total, #id-forma-pagamento').prop('disabled', true);

                formData += '&id-acomodacao=' + encodeURIComponent(idAcomodacao);
                formData += '&id-cliente=' + encodeURIComponent(idCliente);
                formData += '&data-inicio=' + encodeURIComponent(dataInicio);
                formData += '&data-fim=' + encodeURIComponent(dataFim);

                $.ajax({
                    type: 'POST',
                    url: 'gNovaReserva.php',
                    data: formData,
                    success: function(response) {
                        if (response.sucesso) {
                            window.location.href = '../index.php?msg=' + encodeURIComponent(response.mensagem);

                        } else {
                            window.location.href = '../index.php?msgInvalida=' + encodeURIComponent(response.mensagem);
                        }
                    }
                });
            });
        });

</script>
<script type="text/javascript" src="<?= BASE_URL ?>/js/funcao.js"></script> 