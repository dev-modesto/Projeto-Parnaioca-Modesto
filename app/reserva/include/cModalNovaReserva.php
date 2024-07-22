<?php
    // include __DIR__  . '/../../../config/conexao.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        $nomeFuncionario = $_SESSION['nome'];
    }

    if(isset($_POST['click-btn-reservar'])){
        $idAcomodacao = $_POST['id-acomodacao'];
        $dataInicio = $_POST['data-inicio'];
        $dataFim = $_POST['data-fim'];

        $consulta = consultaInfoTipoAcomodacao($con, 0, $idAcomodacao);
        $array = mysqli_fetch_assoc($consulta);
    } 
?>

<div class="modal fade" id="modalNovaReserva" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalNovaReserva" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalNovaReserva">Nova reserva</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- formulario envio -->
            <form class="was-validated form-container" action="include/gNovaReserva.php" method="post">
                <ul class="nav nav-underline">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="dados-pessoais-cliente-tab-edit" data-bs-toggle="tab" data-bs-target="#dados-pessoais-cliente-tab-edit-pane" type="button" role="tab" aria-controls="dados-pessoais-cliente-tab-edit-pane" aria-selected="true">Dados cliente</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="endereco-cliente-tab-edit" data-bs-toggle="tab" data-bs-target="#endereco-cliente-tab-edit-pane" type="button" role="tab" aria-controls="endereco-cliente-tab-edit-pane" aria-selected="false">Informações da reserva</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="finalizar-reserva-tab" data-bs-toggle="tab" data-bs-target="#finalizar-reserva-tab-pane" type="button" role="tab" aria-controls="finalizar-reserva-pane" aria-selected="false">Finalizar</button>
                    </li>
                </ul>
                <br>

                <input class="form-control" type="hidden" name="id-cliente" id="id-cliente" value="<?php echo $id ?>">

                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="dados-pessoais-cliente-tab-edit-pane" role="tabpanel" aria-labelledby="dados-pessoais-cliente-tab-edit" tabindex="0">
                        <div class="mb-3">
                            <label class="font-1-s" for="cpf">CPF</label>
                            <input class="form-control cpf" type="text" name="cpf" id="cpf" value=""  required>
                        </div>

                        <div class="mb-3">
                            <label class="font-1-s" for="nome">Nome completo</label>
                            <input class="form-control" type="text" name="nome" id="nome" value="" disabled required>
                        </div>
                        
                    </div>

                    <div class="tab-pane fade" id="endereco-cliente-tab-edit-pane" role="tabpanel" aria-labelledby="endereco-cliente-tab-edit" tabindex="0">
                    </div>

                    <div class="tab-pane fade" id="finalizar-reserva-pane" role="tabpanel" aria-labelledby="finalizar-reserva" tabindex="0">
                    </div>
                    
                </div>

                <div class="mb-3">
                    <input class="form-control" type="hidden" name="id-funcionario" class="id-funcionario" id="id-funcionario" value="<?php echo $idLogado ?>" required>
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
        $('.cpf').mask('000.000.000-00', {reverse: true});
</script>