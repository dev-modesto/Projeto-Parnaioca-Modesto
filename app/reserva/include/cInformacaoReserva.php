<?php
    ob_start();
    $setorPagina = "SAC";
    $pagina = "Reservas";
    $grupoPagina = "";
    $tituloMenuPagina = "Reservas";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaSac($con, $idLogado);
    }
    include ARQUIVO_FUNCAO_SQL;
    include ARQUIVO_FUNCAO_SQL_RESERVA;

    if(isset($_GET['click-reserva']) && $_GET['click-reserva'] === 'true') {
        $idReserva = $_GET['id-reserva'];

        $consultaConsumoReserva = consultaConsumoReserva($con, $idReserva);        
        $arrayTotalConsumoReserva = consultaTotalConsumoReserva($con, $idReserva);   
        
        $totalConsumido = $arrayTotalConsumoReserva['total_consumo'];
        $totalConsumidoFormatadado = floatval($totalConsumido);
        $totalConsumidoFormatadado = number_format($totalConsumidoFormatadado, 2);

        $sqlReserva = 
                mysqli_prepare(
                    $con, 
                    "SELECT 
                        r.id_acomodacao,
                        r.id_cliente,
                        r.valor,
                        r.total_hospedes,
                        r.dt_reserva_inicio,
                        r.dt_reserva_fim,
                        r.total_noites,
                        r.dt_check_in,
                        r.dt_check_out,
                        r.valor_total_reserva,
                        r.id_metodo_pag,
                        r.valor_consumido,
                        r.id_status_pag,
                        r.id_status_reserva,
                        s.nome_status_reserva
                    FROM tbl_reserva r
                    INNER JOIN tbl_status_reserva s 
                    ON r.id_status_reserva = s.id_status_reserva 
                    WHERE r.id_reserva = ?");
        mysqli_stmt_bind_param($sqlReserva, "i", $idReserva);
        mysqli_stmt_execute($sqlReserva);
        $resultado = mysqli_stmt_get_result($sqlReserva);

        if($array = mysqli_fetch_assoc($resultado)) {

            $idAcomodacao = $array['id_acomodacao'];
            $idCliente = $array['id_cliente'];
            $valorAcomodacao = $array['valor'];
            $totalHospedes = $array['total_hospedes'];
            $dataInicio = $array['dt_reserva_inicio'];
            $dataFim = $array['dt_reserva_fim'];
            $totalNoites = $array['total_noites'];
            $dtCheckIn = $array['dt_check_in'];
            $dtCheckOut = $array['dt_check_out'];

            $consultaTotalPago = consultaTotalPagamentoReserva($con, $idReserva);
            $totalPago = $consultaTotalPago['valor_total'];

            $valorTotalReserva = $array['valor_total_reserva'];
            $idMetodoPag = $array['id_metodo_pag'];
            $valorConsumido = $array['valor_consumido'];
            $idStatusPag = $array['id_status_pag'];
            $idStatusReserva = $array['id_status_reserva'];
            $nomeStatusReserva = $array['nome_status_reserva'];

            $consulta = consultaInfoAcomodacao($con, 0, $idAcomodacao);
            $arrayAcomodacao = mysqli_fetch_assoc($consulta);

            $numeroAcomodacao = $arrayAcomodacao['numero_acomodacao'];
            $nomeAcomodacao = $arrayAcomodacao['nome_acomodacao'];
            // $valorAcomodacao = $arrayAcomodacao['valor'];

            $consultaInfoCliente = consultaInfoCliente($con, $idCliente, 0);

            $nomeCliente = $consultaInfoCliente['nome'];
            $cpfCliente = $consultaInfoCliente['cpf'];
            $telefoneCliente = $consultaInfoCliente['telefone'];

            $dateTimeInicio = new DateTime($dataInicio);
            $dateTimeFim = new DateTime($dataFim);
            $dataInicioPtbr = date_format($dateTimeInicio, "d/m/Y");
            $dataFimPtbr = date_format($dateTimeFim, "d/m/Y");

            $intervalo = $dateTimeInicio->diff($dateTimeFim);
            $qntDias = $intervalo->days;
    
            $valorDiaria = $valorAcomodacao;
            $valorReservaTotal = ($valorDiaria * $totalNoites);
    
            $valorDiariaFormatado = number_format($valorDiaria, 2, '.', '');
            $valorReservaTotalFormatado = number_format($valorReservaTotal, 2, '.', '');
            $valorRestante = ($valorReservaTotalFormatado + $totalConsumidoFormatadado) - $totalPago;
            $valorRestanteFormatado = number_format($valorRestante, 2, '.', '');

            // ID de status das reservas
                $pendente = 1;
                $confirmado = 2;
                $cancelado = 3;
                $checkIn = 4;
                $checkOut = 5;
                $finalizado = 6;
            //
        }   
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
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@1,900&family=Poppins:wght@200;300;400;500;600;700&family=Roboto:wght@200;300;400;500&display=swap" rel="stylesheet">
    
    <!-- link css datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
</head>
<body>

    <div class="conteudo">
        <div class="container-conteudo-principal informacao-reservas">

            <div class="form-container reservas cabecalho" data-status-reserva="<?php echo strtolower($nomeStatusReserva)?>">
                <div class="container-cabecalho-padrao">
                    <h1 class="modal-title fs-5 cor-8 peso-semi-bold" id="staticBackdropLabel">Reserva - #<?php echo $idReserva ?></h1>
                    <span class="cor-6"><?php echo $nomeAcomodacao ?> - <?php echo $numeroAcomodacao ?> </span>
                </div>
                <div class="container-status-reserva disp-reserva-status <?php echo strtolower($nomeStatusReserva)?>">
                    <h1 class="cor-4 font-1-xs">Status atual</h1>
                    <p class="cor-8 status-reserva"><?php echo $nomeStatusReserva ?><span></span></p>
                </div>
            </div>

            <?php
                if ($idStatusReserva !== $finalizado ) {
                    ?>
                    <div class="form-container reservas top-container-button-reserva-info" >

                        <div class="col-md-12 form-container-button-reserva informacao" data-id-reserva="<?php echo $idReserva ?>">

                            <?php 
                                if ($idStatusReserva !== $checkOut && $idStatusReserva !== $finalizado && $idStatusReserva !== $cancelado) {
                                    ?>
                                          <button class='btn btn-primary btn-cancelar-reserva' id="btn-cancelar-reserva">Cancelar reserva</button>
                                    <?php
                                }

                                switch ($idStatusReserva) {
                                    case $pendente :
                                        ?>
                                            <button class='btn btn-primary btn-confirmar-reserva' id="btn-confirmar-reserva">Confirmar reserva</button>
                                        <?php
                                        break;

                                    case $confirmado :
                                        ?>
                                            <button class='btn btn-primary btn-realizar-check-in' id="btn-realizar-check-in">Realizar check-in</button>
                                        <?php
                                        break;
                                    case $checkIn :
                                        ?>
                                            <button class='btn btn-primary btn-realizar-check-out' id="btn-realizar-check-out">Realizar check-out</button>
                                        <?php
                                        break;

                                    case $checkOut :
                                        ?>
                                            <button class='btn btn-primary btn-finalizar-reserva' id="btn-finalizar-reserva">Finalizar reserva</button>
                                        <?php
                                        break;
                                    
                                    default:
                                        break;
                                }
                            ?>
                        </div>
                    </div>
                <?php
                }
            ?>

            <!-- formulario envio -->
            <form class="was-validated form-container reservas-informacao" id="reservaForm">

                <div class="modulo-reservas-informacao geral">
                    <div class="cards-reservas-cabecalho informacao-reservas">
                        <h1 class="font-1-l cor-8 peso-semi-bold">Informações gerais</h1>
                        <div id="dropdown-reservas-disponiveis">
                            <span class="material-symbols-rounded icon-drop-disponiveis">keyboard_arrow_up</span>
                        </div>
                    </div>
                    <div class="form-container reservas">
                        <div class="conteudo-nova-reserva">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-1-s" for="cpf">CPF</label>
                                    <input class="form-control cpf" type="text" name="cpf" id="cpf" value="<?php echo $cpfCliente ?>" disabled required >
                                </div>

                                <div class="col-md-6">
                                    <label class="font-1-s" for="nome">Nome completo</label>
                                    <input class="form-control" type="text" name="nome" id="nome" value="<?php echo $nomeCliente ?>" disabled required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-1-s" for="acomodacao">Acomodação</label>
                                    <input class="form-control acomodacao" type="text" name="acomodacao" id="acomodacao" value="<?php echo $nomeAcomodacao ?>"  disabled  required>
                                </div>

                                <div class="col-md-6">
                                    <label class="font-1-s" for="total-hospedes">Total de hóspedes</label>
                                    <input class="form-control" type="number" min="1" max="5" name="total-hospedes" id="total-hospedes" value="<?php echo $totalHospedes ?>" disabled required>
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-1-s" for="numero-acomodacao">Número</label>
                                    <input class="form-control" type="text" name="numero-acomodacao" id="numero-acomodacao" value="<?php echo $numeroAcomodacao ?>" disabled required>
                                </div>

                                <div class="col-md-3">
                                    <label class="font-1-s" for="data-inicio">Data inicio</label>
                                    <input class="form-control" type="text" name="data-inicio" id="data-inicio" value="<?php echo $dataInicioPtbr ?>" disabled required>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="font-1-s" for="data-final">Data final</label>
                                    <input class="form-control" type="text" name="data-final" id="data-final" value="<?php echo $dataFimPtbr ?>" disabled required>
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
                    </div>
                </div>
                
                <br>

                <div class="modulo-reservas-informacao geral">
                    <div class="cards-reservas-cabecalho informacao-reservas">
                        <h1 class="font-1-l cor-8 peso-semi-bold">Consumo</h1>
                        <div id="dropdown-reservas-disponiveis">
                            <span class="material-symbols-rounded icon-drop-disponiveis">keyboard_arrow_up</span>
                        </div>
                    </div>
                    
                    <div class="form-container reservas">
                        <div class="row mb-3 conteudo-reserva">
                            <div class="col-md-12">
                                <label class="font-1-s" for="valor-total-consumido">Total consumido</label>
                                <input class="form-control monetario" type="text" name="valor-total-consumido" id="valor-total-consumido" value="<?php echo $totalConsumidoFormatadado ?>" disabled required>
                            </div>
                        </div>

                        <span class="separador-botao"></span>

                        <div class="row mb-3 footer-container-button-reserva">
                            <div class="col-md-6 container-button-reserva-info" data-id-reserva="<?php echo $idReserva ?>">
                                <a class='btn btn-primary  btn-ver-consumo' data-bs-toggle="modal" data-bs-target="#modal-visualizar-consumo" id="btn-ver-consumo" >Visualizar consumo</a>
                                <?php
                                    if ($idStatusReserva !== $checkOut && $idStatusReserva !== $finalizado && $idStatusReserva !== $cancelado) {
                                        ?>
                                            <a class='btn btn-primary btn-consumir-itens-frigobar' id="btn-consumir-itens-frigobar">Consumo frigobar</a>
                                        <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <br>

                <div class="modulo-reservas-informacao geral">
                    <div class="cards-reservas-cabecalho informacao-reservas">
                        <h1 class="font-1-l cor-8 peso-semi-bold">Pagamentos</h1>
                        <div id="dropdown-reservas-disponiveis">
                            <span class="material-symbols-rounded icon-drop-disponiveis">keyboard_arrow_up</span>
                        </div>
                    </div>

                    <div class="form-container reservas">
                        <div class="conteudo-reserva">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="font-1-s" for="valor-entrada">Total pago</label>
                                    <input class="form-control monetario" type="text" name="valor-entrada" id="valor-entrada" value="<?php echo $totalPago ?>" disabled>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <label class="font-1-s" for="valor-reserva-total-2">Valor reserva total</label>
                                    <input class="form-control monetario" type="text" name="valor-reserva-total-2" id="valor-reserva-total-2" value="<?php echo $valorReservaTotalFormatado ?>" disabled required>
                                </div>

                                <div class="col-md-6">
                                    <label class="font-1-s" for="valor-total-consumido-2">Total consumido</label>
                                    <input class="form-control monetario" type="text" name="valor-total-consumido-2" id="valor-total-consumido-2" value="<?php echo $totalConsumidoFormatadado ?>" disabled required>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-md-12">
                                    <label class="font-1-s" for="total-a-pagar">Total a pagar</label>
                                    <input class="form-control monetario" type="text" name="total-a-pagar" id="total-a-pagar" value="<?php echo $valorRestanteFormatado ?>" disabled required>
                                </div>
                            </div>

                            <span class="separador-botao"></span>

                            <div class="row mb-3 footer-container-button-reserva">
                                <div class="col-md-6 ">
                                    <?php
                                        if ($idStatusReserva !== $checkOut && $idStatusReserva !== $finalizado && $idStatusReserva !== $cancelado) {
                                            ?>
                                                <a class='btn btn-primary btn-avancar finalizar' id="btn-realizar-pagamento" data-bs-toggle="modal" data-bs-target="#modal-realizar-pagamento">Realizar pagamento</a>
                                            <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>   
                    </div>   
                </div>
                </div>


                <div class="modalConfirmaCheckIn modalConfirmarCheckOut modalConfirmarReserva modalFinalizarReserva modalCancelarReserva">
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

            <div class="modal fade" id="modal-realizar-pagamento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-realizar-pagamento" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modal-realizar-pagamento">Realizar pagamento</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- formulario envio -->
                        <form class="form-container" action="gRealizarPagamento.php" method="post">
                            <input type="text" name="id-reserva" id="id-reserva" value="<?php echo $idReserva ?>" hidden>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="id-forma-pagamento">Forma de pagamento <em>*</em></label>
                                    <select class="form-select select-forma-pagamento"  name="id-forma-pagamento" id="id-forma-pagamento" required aria-label="select example">
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
                                <div class="col-md-6">
                                    <label class="font-1-s" for="valor-total-pendente">Total pendente</label>
                                    <input class="form-control monetario valor-total-pendente" type="text" name="valor-total-pendente" id="valor-total-pendente" value="<?php echo $valorRestanteFormatado ?>" disabled required>
                                </div>
                            </div>


                            <div class="mb-3">
                                <label class="font-1-s" for="valor">Valor a pagar <em>*</em></label>
                                <input class="form-control monetario valor-total-pagar" type="text" name="valor" id="valor" placeholder="R$" required>
                            </div>
                            <div class="mb-3">
                                <div class="invalid-feedback-valor-pago" style="color: red; "></div>
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

                            <div class="modal-footer form-container-button">
                                <button type="button" class="btn btn-secondary btn-modal-cancelar" data-bs-dismiss="modal">Cancelar</button>
                                <button class='btn btn-primary btn-confirmar-pagamento' type="submit" disabled>Confirmar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-visualizar-consumo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-visualizar-consumo" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modal-visualizar-consumo">Produtos consumidos</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form class="was-validated form-container" action="gRealizarPagamento.php" method="post">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <p class="font-1-xs-2 cor-8 peso-leve">Reserva - #<?php echo $idReserva ?></p>
                                    <p class="font-1-xs-2 cor-8 peso-leve">Cliente: <?php echo $nomeCliente ?></p>
                                </div>
                            </div>

                            <table class="table table-hover text-center">
                                <thead class="">
                                    <tr>
                                        <th scope="col">Nº</th>
                                        <th scope="col">Descrição</th>
                                        <th scope="col">Qnt.</th>
                                        <th scope="col">Valor</th>
                                        <th scope="col">Valor total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $nroLinha = 1;
                                        while($row = mysqli_fetch_array($consultaConsumoReserva)) {
                                            ?>
                                                <tr class="table-td-produtos-consumidos">
                                                    <td><?php echo $nroLinha++ ?></td>
                                                    <td><?php echo $row['nome_item'] ?></td>
                                                    <td><?php echo $row['total_quantidade'] ?></td>
                                                    <td>R$ <span class="monetario font-2-xs-2"><?php echo $row['preco_unit'] ?></span></td>
                                                    <td>R$ <span class="monetario font-2-xs-2"><?php echo $row['total_consumido'] ?></span></td>
                                                </tr>
                                            <?php
                                        }
                                    ?>

                                    <tr class="footer-consumo-lista">
                                        <td>.</td>
                                        <td>.</td>
                                        <td><?php echo $arrayTotalConsumoReserva['quantidade']?></td>
                                        <td>.</td>
                                        <td>R$ <span class="monetario font-2-xs-2"><?php echo $arrayTotalConsumoReserva['total_consumo']?></span></td>
                                    </tr>
                                </tbody>
                            </table>


                            <div class="modal-footer form-container-button">
                                <div class="row-mb-3">
                                    <button type="button" class="btn btn-secondary btn-modal-cancelar" data-bs-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

<?php
    include ARQUIVO_FOOTER;
    ob_end_flush();
?>

<script src="<?php echo BASE_URL ?>/js/modal.js"></script>
<script src="<?php echo BASE_URL ?>/js/table.js"></script>
<script src="<?php echo BASE_URL ?>/js/funcao.js"></script>

<script>
    $('.cpf').mask('000.000.000-00', {reverse: true});
</script>


<script>
    $(document).ready(function() {
       
        $('.btn-realizar-check-in').click(function (e) { 
            e.preventDefault();

            var idReserva = $(this).closest('.form-container-button-reserva').data('id-reserva');

            $.ajax({
                type: "POST",
                url: "cModalRealizarCheckIn.php",
                data: {
                    'click-realizar-check-in':true,
                    'id-reserva':idReserva
                },
                success: function (response) {
                    $('.modalConfirmaCheckIn').html(response);
                    $('#modalConfirmaCheckIn').modal('show');
                }
            });
        });

        $('.btn-confirmar-reserva').click(function (e) { 
            e.preventDefault();
            
            var idReserva = $(this).closest('.form-container-button-reserva').data('id-reserva');

            $.ajax({
                type: "POST",
                url: "cModalConfirmarReserva.php",
                data: {
                    'click-confirmar-reserva':true,
                    'id-reserva':idReserva
                },
                success: function (response) {
                    $('.modalConfirmarReserva').html(response);
                    $('#modalConfirmarReserva').modal('show');
                }
            });
        });

        $('.btn-realizar-check-out').click(function (e) { 
            e.preventDefault();
            
            var idReserva = $(this).closest('.form-container-button-reserva').data('id-reserva');

            $.ajax({
                type: "POST",
                url: "cModalRealizarCheckOut.php",
                data: {
                    'click-confirmar-check-out':true,
                    'id-reserva':idReserva
                },
                success: function (response) {
                    $('.modalConfirmarCheckOut').html(response);
                    $('#modalConfirmarCheckOut').modal('show');
                }
            });
        });

        $('.btn-finalizar-reserva').click(function (e) { 
            e.preventDefault();
            
            var idReserva = $(this).closest('.form-container-button-reserva').data('id-reserva');

            $.ajax({
                type: "POST",
                url: "cModalFinalizarReserva.php",
                data: {
                    'click-finalizar-reserva':true,
                    'id-reserva':idReserva
                },
                success: function (response) {
                    $('.modalFinalizarReserva').html(response);
                    $('#modalFinalizarReserva').modal('show');
                }
            });
        });

        $('.btn-consumir-itens-frigobar').click(function (e) { 
            e.preventDefault();
            var idReserva = $(this).closest('.container-button-reserva-info').data('id-reserva');
            var queryString = $.param({
                'click-consumir-itens-frigobar':true,
                'id-reserva':idReserva
            });

            window.location.href = "cFrigobarReserva.php?" + queryString;
        });

        $('.btn-cancelar-reserva').click(function (e) { 
            e.preventDefault();

            var idReserva = $(this).closest('.form-container-button-reserva').data('id-reserva');

            $.ajax({
                type: "POST",
                url: "cModalCancelarReserva.php",
                data: {
                    'click-cancelar-reserva':true,
                    'id-reserva':idReserva
                },
                success: function (response) {
                    $('.modalCancelarReserva').html(response);
                    $('#modalCancelarReserva').modal('show');
                }
            });
            
        });

        const valorPendente = $('.valor-total-pendente').val();
        valorPendenteFormatado = formatarValorVirgula(valorPendente);


        $('.valor-total-pagar').keyup(function (e) { 
            valorDigitado = $(this).val();
            valorDigitadoFormatado = formatarValorVirgula(valorDigitado)

            total = valorPendenteFormatado - valorDigitadoFormatado;
            totalFormatado = formatarValorNumero(total);

            if (isNaN(valorDigitadoFormatado) || valorDigitadoFormatado == 0) {
                $('.btn-confirmar-pagamento').attr('disabled', 'disabled');
                $('.valor-total-pagar').removeClass('is-valid');
                $('.valor-total-pagar').addClass('is-invalid');

            } else {
                $('.btn-confirmar-pagamento').removeAttr('disabled', 'disabled');
                $('.valor-total-pagar').removeClass('is-invalid');
                $('.valor-total-pagar').addClass('is-valid');
            }

            if (totalFormatado < 0 ) {
                $('.invalid-feedback-valor-pago').text('Valor superior ao total pendente.');
                $('.valor-total-pagar').addClass('is-invalid');
                $('.btn-confirmar-pagamento').attr('disabled', 'disabled');

            } else {
                $('.invalid-feedback-valor-pago').text('');
            }
        });

        $('.select-forma-pagamento').change(function (e) { 
            e.preventDefault();
            formaPagamento = $(this).val();

            if (formaPagamento == '') {
                $('.select-forma-pagamento').addClass('is-invalid');

            } else {
                $('.select-forma-pagamento').removeClass('is-invalid');
                $('.select-forma-pagamento').addClass('is-valid');

            }
        });

        const formMarcador = $('.form-container.reservas.cabecalho')[0];
        const formLinha = $('.top-container-button-reserva-info')[0];
        function atualizaClasse(status) {
            formMarcador.classList.remove('status-pendente', 'status-confirmado', 'status-check-in', 'status-check-out', 'status-cancelado');
            formLinha.classList.remove('status-pendente', 'status-confirmado', 'status-check-in', 'status-check-out', 'status-cancelado');
            
            formMarcador.classList.add(`status-${status}`);
            formLinha.classList.add(`status-${status}`);
        }

        const valorStatus = $('.form-container.reservas.cabecalho').data('status-reserva');
        atualizaClasse(valorStatus);

    });
</script>