<?php

    if(isset($_POST['click-btn-excluir-item'])){
        $idItem = $_POST['idItem'];
        $idSku = $_POST['idSku'];
    }

?>

<div class="modal fade" id="modalExcluir" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalExcluir" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-second">
                <span class="icone-alerta-modal material-symbols-rounded">error</span>
            </div>
            <div class="modal-body body-alerta-modal">
                <p><strong>Você tem certeza que deseja remover?</strong> <br>
                    Esta é uma ação irreversível.
                </p>
            </div>

            <form class="was-validated form-container" action="include/eCadastroProduto.php" method="post">
                <input type="text" name="id-item" id="id-item" value="<?php echo $idItem ?>" hidden>
                <input type="text" name="id-sku" id="id-sku" value="<?php echo $idSku ?>" hidden>
                <div class="modal-footer form-container-button">
                    <button type="button" class="btn btn-secondary btn-modal-cancelar" data-bs-dismiss="modal">Cancelar</button>
                    <button class='btn btn-modal-excluir' type="submit">Excluir</button>
                </div>
            </form>
            
        </div>
    </div>
</div>