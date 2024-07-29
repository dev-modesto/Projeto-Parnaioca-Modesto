<?php
    session_start();

    if(isset($_POST['click-realizar-check-in'])){
        $id = $_POST['id-reserva'];
        $_SESSION['id-reserva'] = $id;
    }
?>

<div class="modal fade" id="modalConfirmaCheckIn" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalConfirmaCheckIn" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-header-second modal-check-in-icone">
                <span class="icone-alerta-modal-padrao material-symbols-rounded">where_to_vote</span>
            </div>
            <div class="modal-body body-alerta-modal">
                <p><strong>Deseja confirmar o Check-In?</strong> <br>
                </p>
            </div>

            <form class="was-validated form-container" action="../include/gCheckIn.php" method="post">
                <input type="text" name="id-reserva" id="id-reserva" value="<?php echo $id ?>" hidden>
                <div class="modal-footer form-container-button">
                    <button type="button" class="btn btn-secondary btn-modal-cancelar" data-bs-dismiss="modal">Cancelar</button>
                    <button class='btn btn-modal-check-in' type="submit">Confirmar</button>
                </div>
            </form>
            
        </div>
    </div>
</div>

