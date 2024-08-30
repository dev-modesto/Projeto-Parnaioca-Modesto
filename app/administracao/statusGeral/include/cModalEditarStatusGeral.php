<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if(isset($_POST['click-editar-status-geral'])){

        $id = $_POST['idPrincipal'];

        $stmt = mysqli_prepare($con, "SELECT * FROM tbl_status_geral WHERE id_status = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id);
        $consulta = mysqli_stmt_execute($stmt);

        if($consulta){
            $retorno = mysqli_stmt_get_result($stmt);
            $array = mysqli_fetch_all($retorno, MYSQLI_ASSOC)[0];

            $idStatusGeral = $array['id_status'];
            $nomeStatusGeral = $array['nome_status'];
        }

}

?>

<!-- Modal cadastrar informações -->
<div class="modal fade" id="modalEditarStatusGeral" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditarStatusGeralLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarStatusGeral">Editar status</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- formulario envio -->
            <form class="was-validated form-container" action="include/aStatusGeral.php" method="post">

                <input type="text" name="idStatusGeral" id="idStatusGeral" value="<?php echo $idStatusGeral ?>" hidden>

                <div class="mb-3">
                    <label class="font-1-s" for="nomeStatusGeral">Nome status</label>
                    <input class="form-control" type="text" name="nomeStatusGeral" id="nomeStatusGeral" value="<?php echo $nomeStatusGeral ?>" required>
                    <div class="invalid-feedback">
                    </div>
                </div>

                <div class="modal-footer form-container-button">
                    <button type="button" class="btn btn-secondary btn-modal-cancelar" data-bs-dismiss="modal">Cancelar</button>
                    <button class='btn btn-primary' type="submit">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>
