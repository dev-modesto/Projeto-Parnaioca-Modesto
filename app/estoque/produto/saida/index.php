<?php
    $setorPagina = "Logística";
    $pagina = "Saída de produtos do estoque";
    $grupoPagina = "Produtos";
    $tituloMenuPagina = "Estoque | Saída de produtos";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    
    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaLogistica($con, $idLogado);
    }

    $sqlInner = 
            "SELECT
            s.id_s_item_e, 
            s.id_e_item_f,
            s.id_item, 
            i.id_sku,
            i.nome_item,
            s.quantidade, 
            s.id_funcionario, 
            s.dt_saida 
            FROM tbl_saida_item_estoque s
            INNER JOIN tbl_item i
            ON s.id_item = i.id_item
    ";

    $consulta = mysqli_query($con, $sqlInner);

?>

    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Estoque | Saída de produtos</title>
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
                <table id="myTable" class="table  nowrap order-column dt-right table-hover text-center">
                    <thead class="">
                        <tr>
                            <th scope="col">ID#</th>
                            <th scope="col">SKU</th>
                            <th scope="col">Nome item</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">ID funcionário</th>
                            <th scope="col">Data saida</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            while($exibe = mysqli_fetch_array($consulta)){
                                    $idItem = $exibe['id_item'];
                                ?>
                                <tr>
                                    <td class="id_entrada-item-estoque"><?php echo $exibe['id_s_item_e']?></td>
                                    <td class="id-sku"><?php echo $exibe['id_sku']?></td>
                                    <td class="nome-item"><?php echo $exibe['nome_item']?></td>
                                    <td class=""><?php echo $exibe['quantidade']?></td>
                                    <td class="id-funcionario"><?php echo $exibe['id_funcionario']?></td>
                                    <td class="dt-saida"><?php echo $exibe['dt_saida']?></td>
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
