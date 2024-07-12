<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if(isset($_POST['click-btn-editar-cadastro-item'])){
        $idItem = $_POST['idItem'];
        $idSku = $_POST['idSku'];

        $sql = mysqli_prepare($con, "SELECT * FROM tbl_item WHERE id_item = ?");
        mysqli_stmt_bind_param($sql, 'i', $idItem);
        $consulta = mysqli_stmt_execute($sql);
        $result = mysqli_stmt_get_result($sql);
        $array = mysqli_fetch_assoc($result);

        $nomeProduto = $array['nome_item'];
        $precoUnit = $array['preco_unit'];
            
    }

?>

<!-- Modal cadastrar informações -->
 <div class="modal fade" id="modalEditarCadastroProduto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditarCadastroProduto" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarCadastroProduto">Editar produto</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- formulario envio -->
            <form class="was-validated form-container" action="include/aCadastroProduto.php" method="post">
                <input class="form-control" type="text" name="item" id="item" value="<?php echo $idItem?>" hidden required >
                <div class="mb-3">
                    <label class="font-1-s" for="sku">SKU do produto</label>
                    <input class="form-control" type="text" name="sku" id="sku" value="<?php echo $idSku?>" required >
                </div>

                <div class="mb-3">
                    <label class="font-1-s" for="nome-produto">Nome produto</label>
                    <input class="form-control" type="text" name="nome-produto" id="nome-produto" value="<?php echo $nomeProduto?>" required>
                </div>

                <div class="mb-3">
                    <label class="font-1-s" for="preco">Preço</label>
                    <input class="form-control monetario" type="text" name="preco" id="preco" value="<?php echo $precoUnit?>" required>
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
</script>
