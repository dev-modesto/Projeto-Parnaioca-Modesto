<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo "houve tentativa de post!!";
        $dataInicio = $_POST['data-inicio'];
        $dataFinal = $_POST['data-final'];

        echo $dataInicio;
        echo $dataFinal;

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
            WHERE dt_reserva_inicio >= '$dataInicio'
        ";

        $consultaReservas = mysqli_query($con, $sqlConsultaReservas);

        while($array = mysqli_fetch_assoc($consultaReservas)) {
            print_r($array);
        }
        // $numeroLinhas = mysqli_num_rows($consultaReservas);

    }

?>