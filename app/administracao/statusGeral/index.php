<?php
    $setorPagina = "Administração";
    $pagina = "Status geral";
    $grupoPagina = "Administração geral";
    $tituloMenuPagina = "Status geral";
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    include BASE_PATH . '/include/funcoes/diversas/mensagem.php';

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaAdm($con, $idLogado);
    }
    
    $sql = "SELECT * FROM tbl_status_geral";
    $consulta = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração | Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/global/global.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/navbar/navbar-lateral.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/navbar/navbar-top.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/tipografia.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/cores.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/componentes.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/modal.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/formulario.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/tabela.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/cards-info.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/setor/setor.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/login/login.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/reserva/disponibilidade-reserva.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/reserva/visao-geral-reservas.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/reserva/consumo-frigobar-reserva.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/reserva/info-reserva.css'?>">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@1,900&family=Poppins:wght@200;300;400;600;700&family=Roboto:wght@200;300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
</head>
<body>

    <?php 
        include ARQUIVO_NAVBAR;
    ?>

    <div class="conteudo">
        <div class="container-conteudo-principal">
            
            <?php
                msgGetValida();
                msgGetInvalida();
            ?>

            <span class="separador"></span>

            <!-- Tabela -->
            <div class="container-tabela">
                <div class="container-button">
                    <button type="button" class="cadastrar-status-geral btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <span class="material-symbols-rounded">add</span>Novo status</button>
                </div>
                <table id="myTable" class="table table-bordered table-striped table-hover text-center">
                    <thead class="">
                        <tr>
                            <th scope="col">Nº</th>
                            <th scope="col">id status</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Controle</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            $nroLinha = 1;
                            while($exibe = mysqli_fetch_array($consulta)){
                                    $idStatusGeral = $exibe['id_status'];
                                ?>
                                <tr data-id-status-geral="<?php echo $idStatusGeral ?>">
                                    <td class="numeroLinha"><?php echo $nroLinha++; ?></td>
                                    <td class="id-status"><?php echo $exibe['id_status']?></td>
                                    <td><?php echo $exibe['nome_status']?></td>
                                    <td class="td-icons">
                                        <a class="btn-editar-status-geral icone-controle-editar" href="#"><span class="icon-btn-controle material-symbols-rounded">edit</span></a>
                                        <a class="btn-excluir-status-geral icone-controle-excluir" href="#"><span class="icon-btn-controle material-symbols-rounded">delete</span></a>
                                    </td>

                                    
                                    </td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>

                </table>
            </div>

            <!-- Modal cadastrar informações -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar status</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- formulario envio -->
                        <form class="was-validated form-container" action="include/gStatusGeral.php" method="post">
                            <div class="mb-3">
                                <label class="font-1-s" for="status">Status</label>
                                <input class="form-control" type="text" name="status" id="status" required>
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

            <div class="modalEditarStatusGeral">
            </div>

            <div class="modalExcluir">
            </div>

        </div>

    </div>

<?php
    include ARQUIVO_FOOTER;
?>

<script src="<?php echo BASE_URL ?>/js/modal.js"></script>
