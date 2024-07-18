<?php
    $setorPagina = "Logística";
    $pagina = "Visão geral do estoque";
    $grupoPagina = "Produtos";
    $tituloMenuPagina = "Estoque | Visão geral";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    
    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaLogistica($con, $idLogado);
    }

    $sqlInner = "SELECT DISTINCT id_item FROM tbl_entrada_item_estoque";
    $consultaDistinta = mysqli_query($con, $sqlInner);

?>

    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Estoque | Visão geral do estoque</title>
        <!-- link bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- meu css -->
        <link rel="stylesheet" href="../../../../css/style.css"> <!--- precisa colocar a constante -->
        <!-- meus icons -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" />

        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@1,900&family=Poppins:wght@200;300;400;600;700&family=Roboto:wght@200;300;400;500&display=swap" rel="stylesheet">
        
        <!-- link css datatable -->
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
    
    
    </head>
    <body>

    <div class="conteudo">
        <div class="container-conteudo-principal">

            <?php
                if(isset($_GET['msg'])){
                    $msg = $_GET['msg'];
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            '. $msg .'
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                }
            
            ?>

            <?php
                if(isset($_GET['msgInvalida'])){
                    $msg = $_GET['msgInvalida'];
                    echo '<div class="alert alert-danger  alert-dismissible fade show" role="alert">
                            '. $msg .'
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                }
            
            ?>

            <span class="separador"></span>

                <!-- Tabela -->
                <div class="container-tabela">
                    <table id="myTable" class="table nowrap order-column dt-right table-hover text-center">
                        <thead>
                            <tr>
                                <th scope="col">Nº</th>
                                <th scope="col">ID item/th>
                                <th scope="col">ID SKU</th>
                                <th scope="col">Nome item</th>
                                <th scope="col">Entradas</th>
                                <th scope="col">Saidas</th>
                                <th scope="col">Total estoque</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <?php 
                                $nroLinha = 1;
                                while($exibe = mysqli_fetch_array($consultaDistinta)){
                                        $idItem = $exibe['id_item'];

                                        // informacoes do item
                                        $sqlInfoItem = "SELECT * FROM tbl_item WHERE id_item = $idItem";
                                        $consultaInfoItem = mysqli_query($con, $sqlInfoItem);
                                        $arrayInfoItem = mysqli_fetch_assoc($consultaInfoItem);

                                        // entradas
                                        $sql2 = "SELECT id_item, id_sku, SUM(quantidade) FROM tbl_entrada_item_estoque where id_item = $idItem";
                                        $consultaItem = mysqli_query($con, $sql2);
                                        $arrayItem = mysqli_fetch_assoc($consultaItem);
                                        $totalEntrada = $arrayItem['SUM(quantidade)'] . "\n";

                                        // saidas
                                        $sqlSaida = "SELECT id_item, SUM(quantidade) FROM tbl_saida_item_estoque where id_item = $idItem";
                                        $consultaSaidaItem = mysqli_query($con, $sqlSaida);
                                        $arraySaidaItem = mysqli_fetch_assoc($consultaSaidaItem);
                                        $totalSaida = $arraySaidaItem['SUM(quantidade)'];

                                        // total estoque
                                        $estoqueMinimo = $arrayInfoItem['estoque_minimo'];
                                        $totalEstoque = ($totalEntrada - $totalSaida);

                                    ?>
                                    
                                    <tr class="borda-status">
                                        <td class="numero-linha"><?php echo $nroLinha++; ?></td>
                                        <td class="id-item"><?php echo $exibe['id_item']?></td>
                                        <td class="id-item"><?php echo $arrayItem['id_sku']?></td>
                                        <td><?php echo $arrayInfoItem['nome_item']?></td>
                                        <td class="total-entrada-item"><?php echo $totalEntrada == 0 ? 0 : $totalEntrada ?></td>
                                        <td class="total-saida-item"><?php echo $totalSaida == 0 ? 0 : $totalSaida ?></td>
                                        <td class="total-estoque"><?php echo $totalEstoque == 0 ? 0 : $totalEstoque ?></td>
                                        <td class="legenda"><span class="legenda-status-estoque"><?php echo $totalEstoque == 0 ? "Sem estoque" : ($totalEstoque < $estoqueMinimo ? "Baixo" : "Estável")?></span></td>
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

   <script>

    document.querySelectorAll('.legenda-status-estoque').forEach(function (element){
        switch (element.textContent) {
            case 'Baixo':
                element.classList.add("baixo");
                break;
            case 'Sem estoque':
                element.classList.add("vazio");
                break;
            default:
                element.classList.add("estavel");
                break;
        }
    })

    document.querySelectorAll('.borda-status').forEach(function (element){
        const textoStatus = element.querySelector('.legenda-status-estoque').textContent;
        switch (textoStatus) {
            case 'Baixo':
                element.classList.add("baixo");
                break;
            case 'Sem estoque':
                element.classList.add("vazio");
                break;
            default:
                element.classList.add("estavel");
                break;
        }

    })

</script>

