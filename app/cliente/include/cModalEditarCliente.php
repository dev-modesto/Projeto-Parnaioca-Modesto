<?php
    // include __DIR__  . '/../../../config/conexao.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        $nomeFuncionario = $_SESSION['nome'];
    }

    if(isset($_POST['click-editar-cliente'])){
        $id = $_POST['idCliente'];
        $sql = "SELECT * FROM tbl_cliente WHERE id_cliente = '$id'";
        
        $consulta = mysqli_query($con, $sql);
        
        if ($array = mysqli_fetch_array($consulta)) {
            $nome = $array['nome'];
            $dataNascimento = $array['dt_nascimento'];
            $cpf = $array['cpf'];
            $email = $array['email'];
            $telefone = $array['telefone'];
            $estado = $array['estado'];
            $cidade = $array['cidade'];
            $idFuncionario = $array['id_funcionario'];
            $idStatus = $array['id_status'];

        } else {
            echo "nada encontrado.";
        }
    } else {
        echo "nada foi postado";
    }

?>


<!-- este modal sera carregado quando eu o chamar em outra pagina -->
<div class="modal fade" id="modalEditarCliente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditarCliente" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarCliente">Editar cliente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- formulario envio -->
            <form class="was-validated form-container" action="include/aCliente.php" method="post">
                <ul class="nav nav-underline">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="dados-pessoais-cliente-tab-edit" data-bs-toggle="tab" data-bs-target="#dados-pessoais-cliente-tab-edit-pane" type="button" role="tab" aria-controls="dados-pessoais-cliente-tab-edit-pane" aria-selected="true">Dados pessoais</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="endereco-cliente-tab-edit" data-bs-toggle="tab" data-bs-target="#endereco-cliente-tab-edit-pane" type="button" role="tab" aria-controls="endereco-cliente-tab-edit-pane" aria-selected="false">Endereço</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="status-cliente-tab-edit" data-bs-toggle="tab" data-bs-target="#status-cliente-tab-edit-pane" type="button" role="tab" aria-controls="status-cliente-tab-edit-pane" aria-selected="false">Status cliente</button>
                    </li>
                </ul>
                <br>

                <input class="form-control" type="hidden" name="id-cliente" id="id-cliente" value="<?php echo $id ?>">

                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="dados-pessoais-cliente-tab-edit-pane" role="tabpanel" aria-labelledby="dados-pessoais-cliente-tab-edit" tabindex="0">

                        <div class="mb-3">
                            <label class="font-1-s" for="nome">Nome completo <em>*</em></label>
                            <input class="form-control" type="text" name="nome" id="nome" value="<?php echo $nome ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="font-1-s" for="cpf">CPF <em>*</em></label>
                            <input class="form-control cpf" type="text" name="cpf" id="cpf" value="<?php echo $cpf ?>"  required>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="font-1-s" for="email">E-mail <em>*</em></label>
                                <input class="form-control" type="email" name="email" class="email" id="email" value="<?php echo $email ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="font-1-s" for="telefone">Telefone <em>*</em></label>
                                <input class="form-control" type="fone" name="telefone" class="telefone" id="telefone" value="<?php echo $telefone ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="font-1-s" for="data-nascimento">Data nascimento <em>*</em></label>
                            <input class="form-control" type="date" name="data-nascimento" id="data-nascimento" value="<?php echo $dataNascimento ?>" required>
                        </div>
                        
                    </div>

                    <div class="tab-pane fade" id="endereco-cliente-tab-edit-pane" role="tabpanel" aria-labelledby="endereco-cliente-tab-edit" tabindex="0">
                        
                        <div class="mb-3">
                            <label class="font-1-s" for="estado">Estado <em>*</em></label>
                            <input class="form-control" type="fone" name="estado" class="estado" id="estado" value="<?php echo $estado ?>"  required>
                        </div>

                        <div class="mb-3">
                            <label class="font-1-s" for="cidade">Cidade <em>*</em></label>
                            <input class="form-control" type="fone" name="cidade" class="cidade" id="cidade" value="<?php echo $cidade ?>" required>
                        </div>

                    </div>

                    <div class="tab-pane fade" id="status-cliente-tab-edit-pane" role="tabpanel" aria-labelledby="status-cliente-tab-edit" tabindex="0">
                        <div class="mb-3">
                            <label for="id-status">Status <em>*</em></label>
                            <select class="form-select" name="id-status" id="id-status" required aria-label="select example">
                                <option value="">Selecione um status </option>
                                <?php
                                    include '../../config/conexao.php';
                                    $query = "SELECT id_status, nome_status FROM tbl_status_geral";
                                    $result = mysqli_query($con, $query);
                        
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $selected = ($row['id_status'] == $idStatus) ? 'selected' : '';
                                        echo "<option value='" . $row['id_status'] . "' $selected>" . $row['nome_status'] . "</option>";
                                    }
                                    mysqli_close($con);
                                ?>
                            </select>
                        </div>
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