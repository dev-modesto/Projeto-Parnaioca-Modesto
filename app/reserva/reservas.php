<?php
    $setorPagina = "SAC";
    $pagina = "Todas as reservas";
    $grupoPagina = "Reservas";
    $tituloMenuPagina = "Reservas";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    include PASTA_FUNCOES . "funcaoData.php";
    
    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaLogistica($con, $idLogado);
    }

    $sqlInner = 
        "SELECT
        r.id_reserva,
        r.id_acomodacao,
        a.nome_acomodacao,
        r.valor,
        r.id_cliente,
        c.nome,
        c.cpf,
        r.total_hospedes,
        r.dt_reserva_inicio,
        r.dt_reserva_fim,
        r.total_noites,
        r.dt_check_in,
        r.dt_check_out,
        r.total_pago,
        r.valor_total_reserva,
        r.valor_consumido,
        r.id_status_reserva,
        s.nome_status_reserva
        FROM tbl_reserva r
        INNER JOIN tbl_acomodacao a
        ON r.id_acomodacao = a.id_acomodacao
        INNER JOIN tbl_cliente c
        ON r.id_cliente = c.id_cliente
        INNER JOIN tbl_status_reserva s
        ON r.id_status_reserva = s.id_status_reserva
    ";

    $consulta = mysqli_query($con, $sqlInner);
?>

    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Todas as reservas</title>
        <!-- link bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- meu css -->
        <link rel="stylesheet" href="../../css/style.css">
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

            <span class="separador"></span>

            <!-- Tabela -->
            <div class="container-tabela">
                <table id="myTable" class="table  nowrap order-column dt-right table-hover text-center">
                    <thead class="">
                        <tr>
                            <th scope="col">ID#</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">CPF</th>
                            <th scope="col">Acomodacao</th>
                            <th scope="col">Hóspedes</th>
                            <th scope="col">Data entrada</th>
                            <th scope="col">Data saída</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            while($exibe = mysqli_fetch_array($consulta)){
                                    $idReserva = $exibe['id_reserva'];
                                    $cliente = $exibe['nome'];
                                    $cpfCliente = $exibe['cpf'];
                                    $nomeAcomodacao = $exibe['nome_acomodacao'];
                                    $totalHospedes = $exibe['total_hospedes'];
                                    $dataEntrada = $exibe['dt_reserva_inicio'];
                                    $dataSaida = $exibe['dt_reserva_fim'];
                                    $statusReserva = $exibe['nome_status_reserva'];

                                    $dtEntradaTransformar = new DateTime($dataEntrada);
                                    $dataEntradaFormatada = date_format($dtEntradaTransformar, "d/m/Y");
          
                                    $dtSaidaTransformar = new DateTime($dataEntrada);
                                    $dataSaidaFormatada = date_format($dtSaidaTransformar, "d/m/Y");
                                ?>
                                <tr>
                                    <td class=""><?php echo $idReserva ?></td>
                                    <td class=""><?php echo $cliente ?></td>
                                    <td class=""><?php echo $cpfCliente ?></td>
                                    <td class=""><?php echo $nomeAcomodacao ?></td>
                                    <td class=""><?php echo $totalHospedes ?></td>
                                    <td class=""><?php echo $dataEntradaFormatada ?></td>
                                    <td class=""><?php echo $dataSaidaFormatada ?></td>
                                    <td class="legenda"><span class="legenda-status-reserva check-in"><?php echo $statusReserva ?></span></td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>

                </table>
            </div>

        </div>

    </div>

    <?php
        include ARQUIVO_FOOTER;
    ?>

    <script src="<?php echo BASE_URL ?>/js/modal.js"></script>
    <script src="<?php echo BASE_URL ?>/js/table.js"></script>
