<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $cpfCliente = $_POST['cpf-cliente'];

        $sqlVerifica = mysqli_prepare($con, "SELECT id_cliente, nome FROM tbl_cliente WHERE cpf = ? ");
        mysqli_stmt_bind_param($sqlVerifica, "s", $cpfCliente);
        mysqli_stmt_execute($sqlVerifica);
        $resultado = mysqli_stmt_get_result($sqlVerifica);

        if (mysqli_num_rows($resultado) > 0 ) {
            $array = mysqli_fetch_assoc($resultado);
            $idCliente = $array['id_cliente'];
            $nomeCliente = $array['nome'];

            $response['sucesso'] = true;
            $response = [
                'idCliente' => $idCliente,
                'nomeCliente' => $nomeCliente,
                'sucesso' => $response
            ];
            
            header('Content-Type: application/json');
            echo json_encode($response);
            
        } else {
            $response['mensagem'] = 'Cliente não encontrado.';
            header('Content-Type: application/json');
            echo json_encode($response);
        }

        mysqli_close($con);
        
    } else {
        echo "";

    }

?>