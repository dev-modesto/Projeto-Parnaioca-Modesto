<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/conexao.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST' ){
        $idTipoAcomodacao = $_POST['id-tipo-acomodacao'];
        // $idTipoAcomodacao = "2";
        $dataInicio = $_POST['dt-inicio'];
        // $dataInicio = '2024-07-25';
        $dataFim = $_POST['dt-fim'];
        // $dataFim = '2024-07-29';
        $horaCheckIn = $_POST['hora-check-in'];
        // $horaCheckIn = '13:00';
        $horaCheckOut = $_POST['hora-check-out'];
        // $horaCheckOut = '11:00';

        $inicioFormatado = ($dataInicio ." ".  $horaCheckIn);
        $fimFormatado = ($dataFim ." ". $horaCheckOut);

    }

?>

<div class="container-conteudo">
    <section class="container-cards-reservas">
        <div class="cards-reservas-cabecalho">
            <h1 class="font-1-l cor-8 peso-semi-bold">Acomodações disponíveis</h1>
            <div id="dropdown-reservas-disponiveis">
                <span class="material-symbols-rounded icon-drop-disponiveis">keyboard_arrow_up</span>
            </div>
        </div>

        <div class="container-cards-reservas-disponiveis">
            <?php
                
                $sql = "SELECT * FROM tbl_acomodacao WHERE id_tp_acomodacao = $idTipoAcomodacao";
                $consulta2 = mysqli_query($con, $sql);


                while($arrayLivre = mysqli_fetch_assoc($consulta2)) {

                    $idAcomodacao = $arrayLivre['id_acomodacao'];
                    $numeroAcomodacao = $arrayLivre['numero_acomodacao'];

                    $sqlDisponibilidadeReserva2 = 
                    "SELECT * FROM tbl_reserva 
                    WHERE id_acomodacao = $idAcomodacao 
                    AND ((dt_reserva_inicio <= '$fimFormatado' and dt_reserva_fim >= '$inicioFormatado' ) OR (dt_reserva_inicio >= '$fimFormatado' and dt_reserva_fim <= '$inicioFormatado' )
                    )";

                    $consultaReservaDisponivel2 = mysqli_query($con, $sqlDisponibilidadeReserva2);

                    if($row = mysqli_fetch_assoc($consultaReservaDisponivel2)) {
                    
                    } else {
                        ?>

                            <div class="card card-container-disponibilidade-reserva disponivel">
                                <div class="disp-reserva-nome">
                                    <span class="material-symbols-rounded">hotel</span>
                                    <div class="disp-reserva-nome-info">
                                        <p class="card-title font-1-l cor-8"><?php echo $arrayLivre['nome_acomodacao']?></p>
                                        <p class="font-1-xm cor-8"><?php echo $numeroAcomodacao ?></p>
                                    </div>
                                </div>
                                
                                <span class="separador-reserva"></span>
                                
                                <div class="disp-reserva-status disponivel">
                                    <p class="cor-6">Disponível<span></span></p>
                                </div>
                                
                                <span class="separador-reserva"></span>

                                <div class="disp-reserva-data">
                                    <p class="text-center cor-6">Previsão</p>
                                    <div class="disp-reserva-data-periodo">
                                        <div>
                                        <p class="cor-7 font-1-xxs">Data check-in<p>
                                            <p class="cor-5 font-1-xxs peso-leve" ><?php echo $inicioFormatado ?></p>
                                        </div>
                                        
                                        <div>
                                            <p class="cor-7 font-1-xxs">Data check-out</p>
                                            <p class="cor-5 font-1-xxs peso-leve"><?php echo $fimFormatado ?></p>
                                        </div>
                                    </div>
                                </div>

                                <span class="separador-reserva"></span>

                                <div class="disp-reserva-botao">
                                    <span class="cor-8">Reservar</span>
                                </div>
                            </div>

                        <?php
                    }
                }

            ?>
        </div>

        <div class="cards-reservas-cabecalho">
            <h1 class="font-1-l cor-8 peso-semi-bold">Acomodações reservadas</h1>
            <div id="dropdown-reservas-ocupadas">
                <span class="material-symbols-rounded icon-drop-ocupadas">keyboard_arrow_up</span>
            </div>
        </div>

        <div class="container-cards-reservas-ocupadas">
            <?php

                $sql = "SELECT * FROM tbl_acomodacao WHERE id_tp_acomodacao = $idTipoAcomodacao";
                $consulta = mysqli_query($con, $sql);

                while($array = mysqli_fetch_assoc($consulta)) {

                    $idAcomodacao = $array['id_acomodacao'];
                    $numeroAcomodacao = $array['numero_acomodacao'];

                    $sqlDisponibilidadeReserva = 
                    "SELECT * FROM tbl_reserva 
                    WHERE id_acomodacao = $idAcomodacao 
                    AND ((dt_reserva_inicio <= '$fimFormatado' and dt_reserva_fim >= '$inicioFormatado' ) OR (dt_reserva_inicio >= '$fimFormatado' and dt_reserva_fim <= '$inicioFormatado' )
                    )";

                    $consultaReservaDisponivel = mysqli_query($con, $sqlDisponibilidadeReserva);

                    if($row = mysqli_fetch_assoc($consultaReservaDisponivel)) {

                        $dataReservaCheckIn = $row['dt_reserva_inicio'];
                        $dataReservaCheckOut = $row['dt_reserva_fim'];

                        ?>

                            <div class="card card-container-disponibilidade-reserva reservado">
                                <div class="disp-reserva-nome">
                                    <span class="material-symbols-rounded">hotel</span>
                                    <div class="disp-reserva-nome-info">
                                        <p class="card-title font-1-l cor-8"><?php echo $array['nome_acomodacao']?></p>
                                        <p class="font-1-xm cor-8"><?php echo $numeroAcomodacao ?></p>
                                    </div>
                                </div>
                                
                                <span class="separador-reserva"></span>
                                
                                <div class="disp-reserva-status reservado">
                                    <p class="cor-6">Reservado <span></span></p>
                                </div>
                                
                                <span class="separador-reserva"></span>

                                <div class="disp-reserva-data">
                                    <p class="text-center cor-6">Previsão</p>
                                    <div class="disp-reserva-data-periodo">
                                        <div>
                                        <p class="cor-7 font-1-xxs">Data check-in<p>
                                            <p class="cor-5 font-1-xxs peso-leve" ><?php echo $dataReservaCheckIn ?></p>
                                        </div>
                                        
                                        <div>
                                            <p class="cor-7 font-1-xxs">Data check-out</p>
                                            <p class="cor-5 font-1-xxs peso-leve"><?php echo $dataReservaCheckOut ?></p>
                                        </div>
                                    </div>
                                </div>

                                <span class="separador-reserva"></span>

                                <div class="disp-reserva-botao">
                                    <span class="cor-8">Saber mais</span>
                                </div>
                            </div>

                        <?php
                    
                    } else {

                    }
                }

            ?>
        </div>

    </section>
</div>    


<script>
    const containerReservasOcupadas = document.querySelector(".container-cards-reservas-ocupadas");
    const btnDropReservasOcupadas = document.getElementById("dropdown-reservas-ocupadas");
    const iconDropOcupadas = document.querySelector(".icon-drop-ocupadas");

    const containerReservasDisponiveis = document.querySelector(".container-cards-reservas-disponiveis");
    const btnDropReservasDisponiveis = document.getElementById("dropdown-reservas-disponiveis");
    const iconDropDisponiveis = document.querySelector(".icon-drop-disponiveis");
    
    btnDropReservasDisponiveis.addEventListener("click", function () {
        containerReservasDisponiveis.classList.toggle("min");

        if (containerReservasDisponiveis.classList.contains("min")) {
            iconDropDisponiveis.style.rotate = '180deg';

        } else {
            iconDropDisponiveis.style.rotate = '0deg';
        }

    })

    btnDropReservasOcupadas.addEventListener("click", function () {
        containerReservasOcupadas.classList.toggle("min");

        if (containerReservasOcupadas.classList.contains("min")) {
            iconDropOcupadas.style.rotate = '180deg';

        } else {
            iconDropOcupadas.style.rotate = '0deg';
        }

    })
</script>


