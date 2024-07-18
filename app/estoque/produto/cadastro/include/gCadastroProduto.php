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
        
        $sku = trim($_POST['sku']);
        $nomeProduto = trim($_POST['nome-produto']);
        $preco = $_POST['preco'];
        $precoFormatado = converterMonetario($preco);
        $estoqueMinimo = $_POST['estoque-minimo'];

        $sqlVerifica = mysqli_prepare($con, "SELECT * FROM tbl_item WHERE id_sku = ?");
        mysqli_stmt_bind_param($sqlVerifica, "s", $sku);
        mysqli_stmt_execute($sqlVerifica);
        $result = mysqli_stmt_get_result($sqlVerifica);
        $msg = "";

        if (mysqli_num_rows($result) > 0) {
            $msg .= "Este SKU de produto já foi cadastrado anteriormente.";
            // echo 'encontrou resultados!';
            header("location: ../index.php?msgInvalida=" . $msg);
        
        } else {
            echo "nada encontrado!!";
            
            $sql = 
                mysqli_prepare(
                $con, 
                "INSERT INTO tbl_item (
                    id_sku, 
                    nome_item, 
                    preco_unit, 
                    estoque_minimo,
                    id_funcionario) 
                VALUES (?,?,?,?,?)
            ");
            
            mysqli_stmt_bind_param(
                $sql, 
                "ssdii", 
                $sku, 
                $nomeProduto, 
                $precoFormatado, 
                $estoqueMinimo,
                $idLogado
            );

            if(mysqli_stmt_execute($sql)){
                 // id gerado ao gravar
                 $idItem = mysqli_insert_id($con);

                // log operações
                    $nomeTabela = 'tbl_item';
                    $idRegistro = $idItem;
                    $tpOperacao = 'insercao';
                    $descricao = 'Item adicionado ID: ' . $sku;
                    logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
                // 
                header('location: ../index.php?msg=Adicionado com sucesso!');

            } else {
                echo "Error ao gravar" . mysqli_error($con);
            }

        }
        mysqli_close($con);
        
    } else {
        echo "";

    }

?>