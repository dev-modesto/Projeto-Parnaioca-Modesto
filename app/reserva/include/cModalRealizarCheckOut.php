<?php
    session_start();

    if(isset($_POST['click-confirmar-check-out'])){
        $id = $_POST['id-reserva'];
        $_SESSION['id-reserva'] = $id;
    }
?>

<div class="modal fade" id="modalConfirmarCheckOut" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalConfirmarCheckOut" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-second modal-check-out-icone">
                <span class="icone-alerta-modal-padrao icone-alerta-check-out-modal material-symbols-rounded">tab_move</span>
            </div>
            <div class="modal-body body-alerta-modal">
                <p><strong>Deseja confirmar o Check-Out?</strong> <br>
                </p>
            </div>

            <form class="was-validated form-container" action="../include/gCheckOut.php" method="post">
                <input type="text" name="id-reserva" id="id-reserva" value="<?php echo $id ?>" hidden>
                <div class="modal-footer form-container-button">
                    <button type="button" class="btn btn-secondary btn-modal-cancelar" data-bs-dismiss="modal">Cancelar</button>
                    <button class='btn btn-modal-confirmar-check-out' type="submit">Confirmar</button>
                </div>
            </form>
            
        </div>
    </div>
</div>

