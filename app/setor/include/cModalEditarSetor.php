<?php
    include __DIR__  . '/../../../config/conexao.php';

    if(isset($_POST['click-editar-setor'])){

        $id = $_POST['idSetor'];
        $stmt = mysqli_prepare($con, "SELECT * FROM tbl_setor WHERE id_setor = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id);
        $consulta = mysqli_stmt_execute($stmt);

        if($consulta){
            $retorno = mysqli_stmt_get_result($stmt);
            $array = mysqli_fetch_all($retorno, MYSQLI_ASSOC)[0];
            
            $nomeSetor = $array['nome_setor'];
        }
    }

?>

<!-- Modal cadastrar informações -->
<div class="modal fade" id="modalEditarSetor" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditarSetorLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarSetorLabel">Editar setor</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- formulario envio editar setor -->
            <form class="was-validated form-container" action="include/aSetor.php" method="post">

                <input type="text" name="id" id="id" value="<?php echo $id ?>" hidden>

                <div class="mb-3">
                    <label class="font-1-s" for="setor">Nome do setor</label>
                    <input class="form-control" type="text" name="setor" id="setor" value="<?php echo $nomeSetor ?>" required>
                    <div class="invalid-feedback">
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class='btn btn-primary' type="submit">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>

