<?php
    $setorPagina = "Logística";
    $pagina = "Cadastro de produtos";
    $grupoPagina = "Produtos";
    $tituloMenuPagina = "Estoque | Produtos";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    include PASTA_FUNCOES . "funcaoData.php";
    
    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaLogistica($con, $idLogado);
    }

    $sql= "SELECT * FROM tbl_item";
    $consulta = mysqli_query($con, $sql);

?>

    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Estoque | Cadastro de item</title>
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
                <div class="container-button">
                    <button type="button" class="cadastrar-funcionario btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <span class="material-symbols-rounded">add</span>Cadastrar produto</button>
                </div>
                <table id="myTable" class="table  nowrap order-column dt-right table-hover text-center">
                    <thead class="">
                        <tr>
                            <th scope="col">ID#</th>
                            <th scope="col">SKU</th>
                            <th scope="col">Produto</th>
                            <th scope="col">Preço unit. (R$)</th>
                            <th scope="col">Estoque mínimo</th>
                            <th scope="col">ID funcionário</th>
                            <th scope="col">Data cadastro</th>
                            <th scope="col">Controle</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            while($exibe = mysqli_fetch_array($consulta)){
                                    $idItem = $exibe['id_item'];
                                    $dtOcorrencia = $exibe['dt_cadastro'];
                                    $dtOcorrenciaFormatada = dataHoraFormatada($dtOcorrencia);
                                ?>
                                <tr>
                                    <td class="id-item"><?php echo $exibe['id_item']?></td>
                                    <td class="id-sku"><?php echo $exibe['id_sku']?></td>
                                    <td><?php echo $exibe['nome_item']?></td>
                                    <td class="monetario"><?php echo $exibe['preco_unit']?></td>
                                    <td><?php echo $exibe['estoque_minimo']?></td>
                                    <td class="id-funcionario"><?php echo $exibe['id_funcionario']?></td>
                                    <td><?php echo $dtOcorrenciaFormatada ?></td>
                                    <td class="td-icons">
                                        <a class="btn-editar-item icone-controle-editar " href="#"><span class="icon-btn-controle material-symbols-rounded">edit</span></a>
                                        <a class="btn-excluir-item icone-controle-excluir" href="#"><span class="icon-btn-controle material-symbols-rounded">delete</span></a>
                                    </td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>

                </table>
            </div>

            <!-- Modal cadastrar informações -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar produto</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- formulario envio -->
                        <form class="was-validated form-container" action="include/gCadastroProduto.php" method="post">
                            <div class="mb-3">
                                <label class="font-1-s" for="sku">SKU do produto <em>*</em></label>
                                <input class="form-control" type="text" name="sku" id="sku" required>
                            </div>

                            <div class="mb-3">
                                <label class="font-1-s" for="nome-produto">Nome produto <em>*</em></label>
                                <input class="form-control" type="text" name="nome-produto" id="nome-produto" required>
                            </div>

                            <div class="mb-3">
                                <label class="font-1-s" for="preco">Preço <em>*</em></label>
                                <input class="form-control monetario" type="text" name="preco" id="preco" required>
                            </div>

                            <div class="mb-3">
                                <label class="font-1-s" for="estoque-minimo">Estoque mínimo <em>*</em></label>
                                <input class="form-control" type="number" min="1" max="5000" name="estoque-minimo" id="estoque-minimo" required>
                            </div>

                            <?php if(!empty($mensagem)){ ?>  
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?php echo $mensagem ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div> 
                            <?php }else {
                                    echo '';
                                }
                            ?>

                            <div class="modal-footer form-container-button">
                                <button type="button" class="btn btn-secondary btn-modal-cancelar" data-bs-dismiss="modal">Cancelar</button>
                                <button class='btn btn-primary' type="submit">Adicionar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modalEditarCadastroProduto">
            </div>

            <div class="modalExcluir">
            </div>

        </div>

    </div>

    <?php
        include ARQUIVO_FOOTER;
    ?>

    <script src="<?php echo BASE_URL ?>/js/modal.js"></script>

