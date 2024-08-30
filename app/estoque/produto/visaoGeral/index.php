<?php
    $setorPagina = "Logística";
    $pagina = "Visão geral do estoque";
    $grupoPagina = "Produtos";
    $tituloMenuPagina = "Estoque | Visão geral";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    include ARQUIVO_FUNCAO_SQL;
    
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/global/global.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/navbar/navbar-lateral.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/navbar/navbar-top.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/tipografia.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/cores.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/componentes.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/modal.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/formulario.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/tabela.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/reserva/disponibilidade-reserva.css'?>">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@1,900&family=Poppins:wght@200;300;400;600;700&family=Roboto:wght@200;300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
</head>
<body>

    <?php 
        include ARQUIVO_NAVBAR;
    ?>

    <div class="conteudo">
        <div class="container-conteudo-principal">

            <span class="separador"></span>

                <!-- Tabela -->
                <div class="container-tabela">
                    <table id="myTable" class="table nowrap table-bordered table-striped order-column dt-right table-hover text-center">
                        <thead>
                            <tr>
                                <th scope="col">ID#</th>
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
                                while($exibe = mysqli_fetch_array($consultaDistinta)){
                                        $idItem = $exibe['id_item'];
                                        
                                        // informacoes do item
                                        $arrayInfoItem = infoItemArray($con, $idItem);

                                        // entradas
                                        $arrayItem = entradasEstoqueArray($con, $idItem);
                                        $totalEntrada = totalEntradasEstoque($con, $idItem);
                                        
                                        // saidas
                                        $totalSaida = totalSaidasEstoque($con, $idItem);

                                        // total estoque
                                        $estoqueMinimo = $arrayInfoItem['estoque_minimo'];
                                        $totalEstoque = ($totalEntrada - $totalSaida);

                                    ?>
                                    
                                    <tr class="borda-status">
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

