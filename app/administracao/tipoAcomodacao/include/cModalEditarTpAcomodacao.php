<?php
    // include __DIR__  . '/../../../config/conexao.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if(isset($_POST['click-editar-tp-acomodacao'])){

        $id = $_POST['idPrincipal'];
        // echo 'recebemos o id da acomodacao' . $id;
        $stmt = mysqli_prepare($con, "SELECT * FROM tbl_tp_acomodacao WHERE id_tp_acomodacao = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id);
        $consulta = mysqli_stmt_execute($stmt);

        if($consulta){
            $retorno = mysqli_stmt_get_result($stmt);
            $array = mysqli_fetch_all($retorno, MYSQLI_ASSOC)[0];

            $idAcomodacao = $array['id_tp_acomodacao'];
            $nomeTpAcomodacao = $array['nome_tp_acomodacao'];
    }
}

?>

<!-- Modal cadastrar informações -->
<div class="modal fade" id="modalEditarTpAcomodacao" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditarTpAcomodacaoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarTpAcomodacao">Editar tipo acomodacao</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- formulario envio editar setor -->
            <form class="was-validated form-container" action="include/aTpAcomodacao.php" method="post">

                <input type="text" name="idTpAcomodacao" id="idTpAcomodacao" value="<?php echo $id ?>" hidden>

                <div class="mb-3">
                    <label class="font-1-s" for="nomeTpAcomodacao">Nome do tipo de acomodação <em>*</em></label>
                    <input class="form-control" type="text" name="nomeTpAcomodacao" id="nomeTpAcomodacao" value="<?php echo $nomeTpAcomodacao ?>" required>
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
                    <button type="button" class="btn btn-secondary btn-modal-cancelar" data-bs-dismiss="modal">Cancelar</button>
                    <button class='btn btn-primary' type="submit">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>
