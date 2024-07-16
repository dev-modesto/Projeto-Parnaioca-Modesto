<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $idFrigobar = $_POST['id-frigobar'];
        $idAcomodacao = $_POST['id-acomodacao'];
        $idItem = $_POST['id-item-frigobar'];
        $sku = $_POST['sku'];
        $quantidade = $_POST['quantidade'];

        $array = ['ID frigobar: '.  $idFrigobar, 'ID acomodacao: '.  $idAcomodacao, 'ID item: ' . $idItem, 'SKU: ' . $sku,'Quantidade: ' . $quantidade];
        echo "<pre>";
        print_r($array);

        $sql = 
            mysqli_prepare(
            $con, 
            "INSERT INTO tbl_entrada_item_frigobar (
                id_frigobar,
                id_acomodacao,
                id_item,
                id_sku,
                quantidade,
                id_funcionario)
            VALUES (?,?,?,?,?,?)
        ");

        mysqli_stmt_bind_param(
            $sql, 
            "iiisii", 
            $idFrigobar, 
            $idAcomodacao,
            $idItem,
            $sku,
            $quantidade,
            $idLogado
        );

        // sql tbl_saida_item_estoque
            $sqlSaidaEstoque = 
                mysqli_prepare($con,
                "INSERT INTO tbl_saida_item_estoque (
                    id_item,
                    quantidade,
                    id_funcionario)
                VALUES (?,?,?)
            ");
            
            mysqli_stmt_bind_param(
                $sqlSaidaEstoque,
                "iii",
                $idItem,
                $quantidade,
                $idLogado
            );

            mysqli_stmt_execute($sqlSaidaEstoque);
        //

        if(mysqli_stmt_execute($sql)){

            // log operações
                $nomeTabela = 'tbl_entrada_item_frigobar';
                $idRegistro = $sku;
                $tpOperacao = 'insercao';
                $descricao = 'Item adicionado ID: ' . $sku;
                logOperacao($con,$idLogado,$nomeTabela,$idRegistro,$tpOperacao,$descricao);
            // 
            header('location: ../index.php?msg=Adicionado com sucesso!');

        } else {
            echo "Error ao gravar" . mysqli_error($con);
        }

        mysqli_close($con);
    }

?>