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

        $sqlInner = 
                mysqli_prepare(
                $con, 
                "SELECT 
                e.id_item, 
                e.id_sku, 
                i.nome_item,
                e.quantidade 
                FROM tbl_entrada_item_estoque e
                INNER JOIN tbl_item i
                ON e.id_item = i.id_item
                WHERE e.id_sku = ? "
        );


        mysqli_stmt_bind_param($sqlInner, "i", $idSku);
        mysqli_stmt_execute($sqlInner);
        $result = mysqli_stmt_get_result($sqlInner);

        if (mysqli_num_rows($result) > 0) {
            $array = mysqli_fetch_assoc($result);
            
            $idItem = $array['id_item'];
            $nomeItem = $array['nome_item'];

            // entradas
            $totalEntrada = totalEntradasEstoque($con, $idItem);
                                            
            // saidas
            $totalSaida = totalSaidasEstoque($con, $idItem);

            // total estoque
            $totalEstoque = ($totalEntrada - $totalSaida);

            $response = [
                'idItem' => $idItem,
                'nomeItem' => $nomeItem,
                'totalEstoqueItem' => $totalEstoque
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