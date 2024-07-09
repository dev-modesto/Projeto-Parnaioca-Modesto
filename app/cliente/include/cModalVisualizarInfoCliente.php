<?php
    // include __DIR__  . '/../../../config/conexao.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        $nomeFuncionario = $_SESSION['nome'];

    }

    if(isset($_POST['click-visualizar-info-cliente'])){
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
            $dtCadastro = $array['dt_cadastro'];
            $dtAtualizacao = $array['dt_atualizacao'];


        } else {
            echo "nada encontrado.";
        }
    } else {
        echo "nada foi postado";
    }

?>


<!-- este modal sera carregado quando eu o chamar em outra pagina -->
<div class="modal fade" id="modalVisualizarInfoCliente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalVisualizarInfoCliente" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalVisualizarInfoCliente">Mais informações do cliente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- formulario envio -->
            <form class="was-validated form-container">

                <ul class="nav nav-underline">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Gerais</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Outras</button>
                    </li>
                </ul>
                <br>


                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <div class="mb-3 label-dados-visualizar-info">
                            <label class="font-1-s" for="nome">Nome completo:</label>
                            <p class="font-1-s"><?php echo $nome ?></p>
                        </div>

                        <div class="mb-3 label-dados-visualizar-info">
                            <label class="font-1-s" for="cpf">CPF:</label>
                            <p><?php echo $cpf ?></p>
                        </div>

                        <div class="mb-3 label-dados-visualizar-info">
                            <label class="font-1-s" for="data-nascimento">Data nascimento:</label>
                            <p><?php echo $dataNascimento ?> </p>
                        </div>

                        <div class="mb-3 label-dados-visualizar-info">
                            <label class="font-1-s" for="estado">Estado: </label>
                            <p><?php echo $estado ?></p>
                        </div>

                        <div class="mb-3 label-dados-visualizar-info">
                            <label class="font-1-s" for="cidade">Cidade: </label>
                            <p><?php echo $cidade ?></p>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <div class="mb-3 label-dados-visualizar-info">
                            <label class="font-1-s" for="cidade">ID funcionário cadastro:</label>
                            <p><?php echo $idFuncionario ?></p>
                        </div>

                        <div class="mb-3 label-dados-visualizar-info">
                            <label class="font-1-s" for="cidade">Data cadastro:</label>
                            <p><?php echo $dtCadastro ?></p>
                        </div>

                        <div class="mb-3 label-dados-visualizar-info">
                            <label class="font-1-s" for="cidade">Data atualização:</label>
                            <p><?php echo $dtAtualizacao ?></p>
                        </div>

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



<script>
        $('.cpf').mask('000.000.000-00', {reverse: true});
</script>