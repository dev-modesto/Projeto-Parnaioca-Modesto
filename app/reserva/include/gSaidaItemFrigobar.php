<?php

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;
    include ARQUIVO_FUNCAO_SQL_RESERVA;
    include PASTA_FUNCOES . '/converter.php';

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }


    if (isset($_POST['click-btn-saida-frigobar'])) {
        $idReservaPost = $_POST['id-reserva'];
        $idItemPost = $_POST['id-item'];
        $idFrigobarPost = $_POST['id-frigobar'];
        $quantidadePost = $_POST['quantidade'];


        if (is_numeric($idReservaPost) && is_numeric($idItemPost) && is_numeric($idFrigobarPost) && is_numeric($quantidadePost)) {

            $idReservaFormatado = intval($idReservaPost);
            $idItemFormatado = intval($idItemPost);
            $idFrigobarFormatado = intval($idFrigobarPost);
            $quantidadeFormatada = intval($quantidadePost);

            $arrayItemFrigobar = totalItensEspecificoFrigobar($con, $idItemFormatado, $idFrigobarFormatado);
            $nomeItem = $arrayItemFrigobar['nome_item'];
            $precoUnit = $arrayItemFrigobar['preco_unit'];
            $precoUnitConvertido = floatval($precoUnit);
            $totalItemDisponivelFrigobar = $arrayItemFrigobar['total_disponivel'];

            if ($quantidadeFormatada > $totalItemDisponivelFrigobar ) {
                $mensagem['mensagem'] = "A quantidade informada é superior a quantidade disponível.";

            } else {
                $valorTotal = $quantidadeFormatada * $precoUnit;
                $valorTotalFormatado = number_format($valorTotal, 2);
                $valorTotalConvertido = floatval($valorTotalFormatado);

                $sql = 
                    mysqli_prepare(
                        $con, 
                    "INSERT INTO tbl_consumo_item_frigobar(
                        id_reserva, 
                        id_frigobar, 
                        id_item, 
                        quantidade, 
                        preco_unit, 
                        valor_total)
                    VALUES(?,?,?,?,?,?)       
                ");

                mysqli_stmt_bind_param(
                    $sql, 
                    "iiiidd",
                    $idReservaFormatado, 
                    $idFrigobarFormatado, 
                    $idItemFormatado, 
                    $quantidadeFormatada, 
                    $precoUnitConvertido, 
                    $valorTotalConvertido
                );
                
                mysqli_stmt_execute($sql);
                
                $mensagem['sucesso'] = true;
                $mensagem['mensagem'] = "Saida do item realizada com sucesso!";
                header('Content-Type: application/json');
                echo json_encode($mensagem);
                
                mysqli_close($con);
                exit();
            }

        } else {
            $mensagem['mensagem'] = "Não foi possível realizar a operação.";
        }

    } else {

    }

    header('Content-Type: application/json');
    echo json_encode($mensagem);
?>
