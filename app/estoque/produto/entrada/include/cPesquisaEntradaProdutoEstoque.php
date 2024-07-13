<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;
    include PASTA_FUNCOES . '/converter.php';

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $idSku = $_POST['id-sku'];

        $sqlVerifica = mysqli_prepare($con, "SELECT * FROM tbl_item WHERE id_sku = ? ");
        mysqli_stmt_bind_param($sqlVerifica, "i", $idSku);
        mysqli_stmt_execute($sqlVerifica);
        $result = mysqli_stmt_get_result($sqlVerifica);

        if (mysqli_num_rows($result) > 0) {
            $array = mysqli_fetch_assoc($result);
            
            $idItem = $array['id_item'];
            $nomeItem = $array['nome_item'];

            $response = [
                'idItem' => $idItem,
                'nomeItem' => $nomeItem
            ];
    
            header('Content-Type: application/json');
            echo json_encode($response);

        } else {
            echo "";
        }
        mysqli_close($con);
        
    } else {
        echo "";

    }

?>