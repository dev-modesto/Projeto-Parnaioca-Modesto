<?php
    $setorPagina = "Logística";
    $pagina = "Entrada de produtos";
    $grupoPagina = "Produtos";
    $tituloMenuPagina = "Estoque | Produtos";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    include PASTA_FUNCOES . "funcaoData.php";
    
    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaLogistica($con, $idLogado);
    }

    $sqlInner = "SELECT e.id_e_item_e, e.id_item, e.id_sku, i.nome_item, e.quantidade, e.valor_unit, e.valor_total, e.nota_fiscal, e.id_funcionario, e.dt_entrada FROM tbl_entrada_item_estoque e INNER JOIN tbl_item i ON e.id_item = i.id_item";
    $consulta = mysqli_query($con, $sqlInner);

?>

    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Estoque | Entrada de item</title>
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
                    <button type="button" class="cadastrar-funcionario btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <span class="material-symbols-rounded">add</span>Cadastrar entrada</button>
                </div>
                <table id="myTable" class="table  nowrap order-column dt-right table-hover text-center">
                    <thead class="">
                        <tr>
                            <th scope="col">ID#</th>
                            <th scope="col">SKU</th>
                            <th scope="col">Nome item</th>
                            <th scope="col">Nota fiscal</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Valor unit.</th>
                            <th scope="col">Valor total</th>
                            <th scope="col">ID funcionário</th>
                            <th scope="col">Data entrada</th>
                            <th scope="col">Controle</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            while($exibe = mysqli_fetch_array($consulta)){
                                    $idItem = $exibe['id_e_item_e'];
                                    $dtOcorrencia = $exibe['dt_entrada'];
                                    $dtOcorrenciaFormatada = dataHoraFormatada($dtOcorrencia);
                                ?>
                                <tr data-id-entrada-item-estoque="<?php echo $idItem ?>">
                                    <td class="id_entrada-item-estoque"><?php echo $exibe['id_e_item_e']?></td>
                                    <td class="id-sku"><?php echo $exibe['id_sku']?></td>
                                    <td class="nome-item"><?php echo $exibe['nome_item']?></td>
                                    <td class="nota-fiscal"><?php echo $exibe['nota_fiscal']?></td>
                                    <td class=""><?php echo $exibe['quantidade']?></td>
                                    <td class="monetario"><?php echo $exibe['valor_unit']?></td>
                                    <td class="monetario"><?php echo $exibe['valor_total']?></td>
                                    <td class="id-funcionario"><?php echo $exibe['id_funcionario']?></td>
                                    <td class="dt-entrada"><?php echo $dtOcorrenciaFormatada ?></td>
                                    <td class="td-icons">
                                        <a class="btn-editar-entrada-item-estoque icone-controle-editar " href="#"><span class="icon-btn-controle material-symbols-rounded">edit</span></a>
                                        <a class="btn-excluir-entrada-item-estoque icone-controle-excluir" href="#"><span class="icon-btn-controle material-symbols-rounded">delete</span></a>
                                    </td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>

                </table>
            </div>

            <!-- Modal cadastrar informações -->
            <div class="modal fade modal-lg" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar entrada</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- formulario envio -->
                        <form class="was-validated form-container" action="include/gEntradaProdutoEstoque.php" method="post">
                            <div class="row mb-3">
                                <input class="form-control" type="text" name="id-item" id="id-item" value="" hidden required>
                                <div class="col-md-4">
                                    <label class="font-1-s" for="id-sku">SKU do produto <em>*</em></label>
                                    <input class="form-control input-sku-produto" type="text" name="id-sku" id="id-sku" required>
                                </div>

                                
                                <div class="col-md-8">
                                    <label class="font-1-s" for="nome-produto">Nome produto</label>
                                    <input class="form-control" type="text" name="nome-produto" id="nome-produto" value="" readonly  required>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label class="font-1-s" for="nota-fiscal">Nota fiscal <em>*</em></label>
                                    <input class="form-control" type="text" name="nota-fiscal" id="nota-fiscal" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="font-1-s" for="quantidade">Quantidade <em>*</em></label>
                                    <input class="form-control quantidade" type="text" name="quantidade" id="quantidade" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="font-1-s" for="valor-unitario">Valor unitário (R$) <em>*</em></label>
                                    <input class="form-control monetario valor-unitario" type="text" name="valor-unitario" id="valor-unitario" required>
                                </div>
                            </div>

                            <div class="row mb-3 justify-content-end">
                                <div class="col-md-4">
                                    <label class="font-1-s" for="valor-total">Valor total (R$)</label>
                                    <input class="form-control monetario valor-total" type="text" name="valor-total" id="valor-total" value="" readonly required>
                                </div>
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

            <div class="modalEditarEntradaItemEstoque">
            </div>

            <div class="modalExcluir">
            </div>

        </div>

    </div>

    <?php
        include ARQUIVO_FOOTER;
    ?>

    <script src="<?php echo BASE_URL ?>/js/modal.js"></script>
    <script src="<?php echo BASE_URL ?>/js/table.js"></script>

<script>

    $(document).ready(function () {

        $(".input-sku-produto").keyup(function (e) { 
            e.preventDefault();

            var idSku = $(this).val();

            $.ajax({
                type: "POST",
                url: "include/cPesquisaEntradaProdutoEstoque.php",
                data: {
                    'id-sku':idSku
                },

                success: function (response) {
                    if (response !== "") {
                        $('#id-item').val(response.idItem);
                        $('#nome-produto').val(response.nomeItem);
                    } else {
                        $('#id-item').val('');
                        $('#nome-produto').val('');
                    }
                },
            });
        });
        
    });

    document.querySelector('.quantidade').addEventListener('input', function() {
    calcularValorTotal();
    });

    document.querySelector('.valor-unitario').addEventListener('input', function() {
        calcularValorTotal();
    });

    function calcularValorTotal() {
        var quantidade = document.querySelector('.quantidade').value;
        var valorUnitario = document.querySelector('.valor-unitario').value;

        valorUnitario = valorUnitario.replace(/\./g, '').replace(',', '.');

        if (!isNaN(quantidade) && !isNaN(valorUnitario)) {
            var valorTotal = quantidade * valorUnitario;
            valorTotal = formatarValor(valorTotal);
            document.querySelector('.valor-total').value = valorTotal;
        }
    }

    function formatarValor(valor) {
        return parseFloat(valor).toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

</script>