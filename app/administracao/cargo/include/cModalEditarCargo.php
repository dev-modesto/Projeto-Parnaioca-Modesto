<?php
    // include __DIR__  . '/../../../config/conexao.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if(isset($_POST['click-editar-cargo'])){

        $id = $_POST['idPrincipal'];
        $stmt = mysqli_prepare($con, "SELECT * FROM tbl_cargo WHERE id_cargo = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id);
        $consulta = mysqli_stmt_execute($stmt);

        if($consulta){
            $retorno = mysqli_stmt_get_result($stmt);
            $array = mysqli_fetch_all($retorno, MYSQLI_ASSOC)[0];
            
            $idSetor = $array['id_setor'];
            $nomeCargo = $array['nome_cargo'];
            $salario = $array['salario'];
            $idSetor = $array['id_setor'];
    }
}

?>

<!-- Modal cadastrar informações -->
<div class="modal fade" id="modalEditarCargo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditarCargoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarCargoLabel">Editar cargo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- formulario envio editar setor -->
            <form class="was-validated form-container" action="include/aCargo.php" method="post">

                <input type="text" name="idCargo" id="idCargo" value="<?php echo $id ?>" hidden>
                <input type="text" name="idSetor" id="idSetor" value="<?php echo $idSetor ?>" hidden>

                <div class="mb-3">
                    <label class="font-1-s" for="cargo">Nome do cargo <em>*</em></label>
                    <input class="form-control" type="text" name="cargo" id="cargo" value="<?php echo $nomeCargo ?>" required>
                    <div class="invalid-feedback">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="font-1-s" for="salario">Salário <em>*</em></label>
                    <input class="form-control monetario" type="text" name="salario" id="salario" value="<?php echo $salario ?>"  required>
                    <!-- <p id="info-validaCpf"></p> -->
                    <div class="invalid-feedback">
                    
                    </div>
                </div>

                <div class="mb-3">
                    <label for="idSetor">Cargo <em>*</em></label>
                    <select class="form-select idSetor" name="idSetor" required aria-label="select example">
                        <?php
                            include '../../config/conexao.php';
                            $query = "SELECT id_setor, nome_setor FROM tbl_setor";
                            $result = mysqli_query($con, $query);
                
                                while ($row = mysqli_fetch_assoc($result)) {
                                $selected = ($row['id_setor'] == $idSetor) ? 'selected' : '';
                                echo "<option value='" . $row['id_setor'] . "' $selected>" . $row['nome_setor'] . "</option>";
                            }
                            mysqli_close($con);
                        ?>
                    </select>
                </div>

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

