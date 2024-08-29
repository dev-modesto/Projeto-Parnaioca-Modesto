<?php
    $setorPagina = "Logística";
    $pagina = "Consumo frigobar";
    $grupoPagina = "Frigobar";
    $tituloMenuPagina = "Estoque | Frigobar";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    include PASTA_FUNCOES . "funcaoData.php";

    
    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaLogistica($con, $idLogado);
    }

    $sqlInner = 
            "SELECT 
                c.id_consumo_item_f, 
                c.id_reserva, 
                c.id_frigobar, 
                f.nome_frigobar,
                c.id_item,
                i.id_sku,
                i.nome_item,
                c.quantidade,
                c.preco_unit, 
                c.dt_saida 
            FROM tbl_consumo_item_frigobar c 
            INNER JOIN tbl_item i 
            ON c.id_item = i.id_item
            INNER JOIN tbl_frigobar f
            ON c.id_frigobar = f.id_frigobar
    ";
            
    $consulta = mysqli_query($con, $sqlInner);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frigobar | Consumo frigobar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/global/global.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/navbar/navbar-lateral.css';?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/navbar/navbar-top.css';?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/tipografia.css';?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/cores.css';?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/componentes.css';?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/modal.css';?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/formulario.css';?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/tabela.css';?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/cards-info.css';?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/setor/setor.css';?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/login/login.css';?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/reserva/disponibilidade-reserva.css';?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/reserva/visao-geral-reservas.css';?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/reserva/consumo-frigobar-reserva.css';?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/reserva/info-reserva.css';?>">
    
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
                <table id="myTable" class="table nowrap table-bordered table-striped order-column dt-right table-hover text-center">
                    <thead class="">
                        <tr>
                            <th scope="col">ID#</th>
                            <th scope="col">Nº reserva</th>
                            <th scope="col">Nome frigobar</th>
                            <th scope="col">SKU</th>
                            <th scope="col">Nome item</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Preço Unit.</th>
                            <th scope="col">Data saída</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            while($exibe = mysqli_fetch_array($consulta)){
                                    $idItem = $exibe['id_item'];
                                    $dtOcorrencia = $exibe['dt_saida'];
                                    $dtOcorrenciaFormatada = dataHoraFormatada($dtOcorrencia);
                                ?>
                                <tr>
                                    <td class="id-item"><?php echo $exibe['id_consumo_item_f']?></td>
                                    <td class="id-item"><?php echo $exibe['id_reserva']?></td>
                                    <td><?php echo $exibe['nome_frigobar']?></td>
                                    <td class="id-sku"><?php echo $exibe['id_sku']?></td>
                                    <td class="Nome item"><?php echo $exibe['nome_item']?></td>
                                    <td><?php echo $exibe['quantidade']?></td>
                                    <td class="monetario"><?php echo $exibe['preco_unit']?></td>
                                    <td><?php echo $dtOcorrenciaFormatada ?></td>
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

