<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include_once(ARQUIVO_CONEXAO);
    include_once(ARQUIVO_FUNCAO_SQL);
    include_once(ARQUIVO_FUNCAO_SQL_RESERVA);

    date_default_timezone_set('America/Sao_Paulo');
    $extraiData = new DateTimeImmutable();
    $dataAtual = date_format($extraiData, "Y-m-d");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $dataInicio = $_POST['data-inicio'];
        $dataFinal = $_POST['data-final'];

        // ID de status das reservas
            $pendente = 1;
            $confirmado = 2;
            $cancelado = 3;
            $checkIn = 4;
            $checkOut = 5;
            $finalizado = 6;
        // 

        $totalPendentes = totalStatusReservaFiltro($con, $dataInicio, $dataFinal, $pendente);
        $totalConfirmados = totalStatusReservaFiltro($con, $dataInicio, $dataFinal, $confirmado);
        $totalFinalizados = totalStatusReservaFiltro($con, $dataInicio, $dataFinal, $finalizado);
        $totalCheckIn = totalStatusReservaFiltro($con, $dataInicio, $dataFinal, $checkIn);
        $totalCheckOut = totalStatusReservaFiltro($con, $dataInicio, $dataFinal, $checkOut);
        $totalCancelados = totalStatusReservaFiltro($con, $dataInicio, $dataFinal, $cancelado);

        ?>
            <div class="container-conteudo dash conteudo-dash" id="conteudo-filtro-dash">
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
                            WHERE (dt_reserva_inicio <= '$dataFinal 23:59:59' and dt_reserva_fim >= '$dataInicio 00:00:00')
                            OR (dt_reserva_inicio >= '$dataInicio 00:00:00' AND dt_reserva_fim <= '$dataFinal 23:59:00')
                            ORDER BY dt_reserva_inicio;
                        ";

                        $resultado = mysqli_query($con, $sqlConsultaReservas);

                    while($arrayReservas = mysqli_fetch_assoc($resultado)) {
                        $idAcomodacao = $arrayReservas['id_acomodacao'];
                        $idStatusReserva = $arrayReservas['id_status_reserva'];
                        $nomeStatusReserva = $arrayReservas['nome_status_reserva'];

                        $consultaInfoAcomodacao = consultaInfoAcomodacao($con, 0, $idAcomodacao);
                        $arrayInfoAcomodacao = mysqli_fetch_assoc($consultaInfoAcomodacao);

                        $nomeAcomodacao = $arrayInfoAcomodacao['nome_acomodacao'];
                        $numeroAcomodacao = $arrayInfoAcomodacao['numero_acomodacao'];

                        $dtReservaInicio = $arrayReservas['dt_reserva_inicio'];
                        $dtReservaFim = $arrayReservas['dt_reserva_fim'];
                        $dtReservaInicioFormatar = new DateTime($dtReservaInicio);
                        $dtReservaFimFormatar = new DateTime($dtReservaFim);
                        $dtReservaInicioFormatada = date_format($dtReservaInicioFormatar, "d/m/Y");
                        $dtReservaFimFormatada = date_format($dtReservaFimFormatar, "d/m/Y");

                        $idReserva = $arrayReservas['id_reserva'];

                        ?>
                            <div class="card card-container-disponibilidade-reserva dash <?php echo strtolower($nomeStatusReserva) ?>" data-id-reserva="<?php echo $idReserva ?>">
                                <div class="card-reserva-dash-top">
                                    <div class="disp-reserva-nome dash">
                                        <div class="card-reserva-cabecalho dash">
                                            <span class="material-symbols-rounded">hotel</span>
                                            <p class="cor-4">Reserva - #<?php echo $idReserva ?></p>
                                        </div>
                                
                                        <div class="disp-reserva-nome-info dash">
                                            <p class="card-title font-1-l cor-8"><?php echo $nomeAcomodacao ?></p>
                                            <p class="font-1-xm cor-8"><?php echo $numeroAcomodacao ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="disp-reserva-status dash <?php echo strtolower($nomeStatusReserva) ?>">
                                        <p class="cor-6 status-reserva "><?php echo $nomeStatusReserva ?><span></span></p>
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
        <?php

    } else {
        ?>
            <div class="container-conteudo dash conteudo-dash" id="conteudo-filtro-dash">
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
                        WHERE (dt_reserva_inicio <= '$dataAtual 23:59:59' AND dt_reserva_fim >= '$dataAtual 00:00:00')
                        ORDER BY dt_reserva_inicio;
                    ";
                    $consultaReservas = mysqli_query($con, $sqlConsultaReservas);
                    $numeroLinhas = mysqli_num_rows($consultaReservas);

                    while($arrayReservas = mysqli_fetch_assoc($consultaReservas)) {
                        $idAcomodacao = $arrayReservas['id_acomodacao'];
                        $idStatusReserva = $arrayReservas['id_status_reserva'];
                        $nomeStatusReserva = $arrayReservas['nome_status_reserva'];

                        $consultaInfoAcomodacao = consultaInfoAcomodacao($con, 0, $idAcomodacao);
                        $arrayInfoAcomodacao = mysqli_fetch_assoc($consultaInfoAcomodacao);

                        $nomeAcomodacao = $arrayInfoAcomodacao['nome_acomodacao'];
                        $numeroAcomodacao = $arrayInfoAcomodacao['numero_acomodacao'];

                        $dtReservaInicio = $arrayReservas['dt_reserva_inicio'];
                        $dtReservaFim = $arrayReservas['dt_reserva_fim'];
                        $dtReservaInicioFormatar = new DateTime($dtReservaInicio);
                        $dtReservaFimFormatar = new DateTime($dtReservaFim);
                        $dtReservaInicioFormatada = date_format($dtReservaInicioFormatar, "d/m/Y");
                        $dtReservaFimFormatada = date_format($dtReservaFimFormatar, "d/m/Y");

                        $idReserva = $arrayReservas['id_reserva'];

                        ?>
                            <div class="card card-container-disponibilidade-reserva dash <?php echo strtolower($nomeStatusReserva) ?>" data-id-reserva="<?php echo $idReserva ?>">
                                <div class="card-reserva-dash-top">
                                    <div class="disp-reserva-nome dash">
                                        <div class="card-reserva-cabecalho dash">
                                            <span class="material-symbols-rounded">hotel</span>
                                            <p class="cor-4">Reserva - #<?php echo $idReserva ?></p>
                                        </div>
                                
                                        <div class="disp-reserva-nome-info dash">
                                            <p class="card-title font-1-l cor-8"><?php echo $nomeAcomodacao ?></p>
                                            <p class="font-1-xm cor-8"><?php echo $numeroAcomodacao ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="disp-reserva-status dash <?php echo strtolower($nomeStatusReserva) ?>">
                                        <p class="cor-6 status-reserva "><?php echo $nomeStatusReserva ?><span></span></p>
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
        <?php
    }

?>