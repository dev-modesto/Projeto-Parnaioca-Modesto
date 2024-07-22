<?php
    ob_start();
    $setorPagina = "SAC";
    $pagina = "Reservas";
    $grupoPagina = "Reservas";
    $tituloMenuPagina = "Reservas";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    
    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaSac($con, $idLogado);
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>
    <!-- link bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- meu css -->
    <link rel="stylesheet" href="../../../css/style.css"> <!--- precisa colocar a constante -->
    <!-- meus icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" />

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@1,900&family=Poppins:wght@200;300;400;600;700&family=Roboto:wght@200;300;400;500&display=swap" rel="stylesheet">
    
    <!-- link css datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
</head>
<body>

    <div class="conteudo">
        <div class="container-conteudo-principal">

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
                        <div class="row mb-3">

                            <div class="col-md-4">
                                <label class="font-1-s" for="cpf">CPF</label>
                                <input class="form-control cpf" type="text" name="cpf" id="cpf" value=""  required>
                            </div>

                            <div class="col-md-4">
                                <label class="font-1-s" for="nome">Nome completo</label>
                                <input class="form-control" type="text" name="nome" id="nome" value="" disabled required>
                            </div>

                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <button class='btn btn-primary' type="submit">Avançar</button>
                            </div>
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

                <!-- <div class="modal-footer form-container-button">
                    <button type="button" class="btn btn-secondary btn-modal-cancelar" data-bs-dismiss="modal">Cancelar</button>
                    <button class='btn btn-primary' type="submit">Adicionar</button>
                </div> -->
            </form>
        </div>

    </div>

<?php
    include ARQUIVO_FOOTER;
    ob_end_flush();
?>

<script src="<?php echo BASE_URL ?>/js/modal.js"></script>
<script src="<?php echo BASE_URL ?>/js/table.js"></script>

<script>
        $('.cpf').mask('000.000.000-00', {reverse: true});
</script>

