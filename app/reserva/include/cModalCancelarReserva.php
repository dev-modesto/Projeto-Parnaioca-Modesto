<?php
    session_start();

    if(isset($_POST['click-cancelar-reserva'])){
        $id = $_POST['id-reserva'];
        $_SESSION['id-reserva'] = $id;
    }
?>

<div class="modal fade" id="modalCancelarReserva" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCancelarReserva" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-second modal-cancelar-reserva-icone">
                <span class="icone-alerta-modal material-symbols-rounded">event_busy</span>
            </div>
            <div class="modal-body body-alerta-modal">
                <p><strong>Deseja realmente cancelar a reserva?</strong> <br>
                </p>
            </div>

            <form class="was-validated form-container" action="../include/gCancelarReserva.php" method="post">
                <input type="text" name="id-reserva" id="id-reserva" value="<?php echo $id ?>" hidden>
                <div class="modal-footer form-container-button">
                    <button type="button" class="btn btn-secondary btn-modal-cancelar" data-bs-dismiss="modal">Cancelar</button>
                    <button class='btn btn-modal-cancelar-reserva' type="submit">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

