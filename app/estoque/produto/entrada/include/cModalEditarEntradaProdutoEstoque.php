<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if(isset($_POST['click-btn-editar-entrada-item-estoque'])){
        $id = $_POST['idTabela'];

        $sqlInner = mysqli_prepare($con, 
                "SELECT 
                    e.id_e_item_e, 
                    e.id_item, 
                    e.id_sku, 
                    i.nome_item, 
                    e.quantidade, 
                    e.valor_unit, 
                    e.valor_total, 
                    e.nota_fiscal, 
                    e.id_funcionario, 
                    e.dt_entrada 
                FROM tbl_entrada_item_estoque e 
                INNER JOIN tbl_item i 
                ON e.id_item = i.id_item
                WHERE id_e_item_e = ? "
        );

        mysqli_stmt_bind_param($sqlInner, "i", $id);
        mysqli_stmt_execute($sqlInner);
        $result = mysqli_stmt_get_result($sqlInner);
        $array = mysqli_fetch_assoc($result);

        $idItem = $array['id_item'];
        $idSku = $array['id_sku'];
        $nomeProduto = $array['nome_item'];
        $quantidade = $array['quantidade'];
        $valorUnitario = $array['valor_unit'];
        $valorTotal = $array['valor_total'];
        $notaFiscal = $array['nota_fiscal'];
   
    }

?>

<!-- Modal editar informações -->
<div class="modal fade modal-lg" id="modalEditarEntradaItemEstoque" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditarEntradaItemEstoque" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarEntradaItemEstoque">Editar entrada</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- formulario envio -->
            <form class="was-validated form-container" action="include/aEntradaProdutoEstoque.php" method="post">
                <div class="row mb-3">
                    <input class="form-control" type="text" name="id-tabela" id="id-tabela" value="<?php echo $id?>" hidden required>
                    <input class="form-control" type="text" name="id-item" id="id-item-consulta" value="" hidden required>
                    <div class="col-md-4">
                        <label class="font-1-s" for="id-sku">SKU do produto</label>
                        <input class="form-control input-sku-produto" type="text" name="id-sku" id="id-sku" value="<?php echo $idSku?>" required>
                    </div>

                    
                    <div class="col-md-8">
                        <label class="font-1-s" for="nome-produto">Nome produto</label>
                        <input class="form-control" type="text" name="nome-produto" id="nome-produto-consulta" value="" readonly required>
                    </div>
                </div>


                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="font-1-s" for="nota-fiscal">Nota fiscal</label>
                        <input class="form-control" type="text" name="nota-fiscal" id="nota-fiscal" value="<?php echo $notaFiscal?>" required>
                    </div>

                    <div class="col-md-4">
                        <label class="font-1-s" for="quantidade">Quantidade</label>
                        <input class="form-control quantidade2" type="text" name="quantidade" id="quantidade" value="<?php echo $quantidade?>" required>
                    </div>

                    <div class="col-md-4">
                        <label class="font-1-s" for="valor-unitario">Valor unitário (R$)</label>
                        <input class="form-control monetario valor-unitario2" type="text" name="valor-unitario" id="valor-unitario" value="<?php echo $valorUnitario?>" required>
                    </div>
                </div>

                <div class="row mb-3 justify-content-end">
                    <div class="col-md-4">
                        <label class="font-1-s" for="valor-total">Valor total (R$)</label>
                        <input class="form-control monetario valor-total2" type="text" name="valor-total" id="valor-total" value="" readonly required>
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

<script>
    $('.monetario').mask('000.000.000.000.000,00', {reverse: true});


    $(document).ready(function () {

        $(".input-sku-produto").keyup(function (e) { 
            e.preventDefault();

            var idSku = $(this).val();
            console.log(idSku);

            $.ajax({
                type: "POST",
                url: "include/cPesquisaEntradaProdutoEstoque.php",
                data: {
                    'id-sku':idSku
                },

                success: function (response) {
                    if (response !== "") {
                        $('#id-item-consulta').val(response.idItem);
                        $('#nome-produto-consulta').val(response.nomeItem);
                    } else {
                        $('#id-item-consulta').val('');
                        $('#nome-produto-consulta').val('');
                    }
                },
            });
        });

        });


    document.querySelector('.quantidade2').addEventListener('input', function() {
    calcularValorTotal();
    });

    document.querySelector('.valor-unitario2').addEventListener('input', function() {
        calcularValorTotal();
    });

    function calcularValorTotal() {
        var quantidade = document.querySelector('.quantidade2').value;
        var valorUnitario = document.querySelector('.valor-unitario2').value;

        valorUnitario = valorUnitario.replace(/\./g, '').replace(',', '.');

        if (!isNaN(quantidade) && !isNaN(valorUnitario)) {
            var valorTotal = quantidade * valorUnitario;
            valorTotal = formatarValor(valorTotal);
            document.querySelector('.valor-total2').value = valorTotal;
        }
    }

    function formatarValor(valor) {
        return parseFloat(valor).toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }
</script>
