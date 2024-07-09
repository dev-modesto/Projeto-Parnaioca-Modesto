<?php
    $tituloPagina = "Administração";
    $pagina = "Setor";
    $grupoPagina = "Administração geral";
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaAdm($con, $idLogado);
    }

    $sql = 'SELECT * FROM tbl_setor';
    $consulta = mysqli_query($con, $sql);

?>

    <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Administração | Setores</title>
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

            <?php
                if(isset($_GET['msg'])){
                    $msg = $_GET['msg'];
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            '. $msg .'
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                }
            
            ?>

            <span class="separador"></span>


            <?php if(!empty($mensagem)){ ?>  
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $mensagem ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div> 
            <?php }else {
                    echo '';
                }
            ?>

            <!-- Tabela -->
            <div class="container-tabela">
                <div class="container-button">
                    <button type="button" class="cadastrar-funcionario btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <span class="material-symbols-rounded">add</span>Novo setor</button>
                </div>
                <table id="myTable" class="table table-hover text-center">
                    <thead class="">
                        <tr>
                            <th scope="col">Nº</th>
                            <th scope="col">id setor</th>
                            <th scope="col">Nome setor</th>
                            <th scope="col">Controle</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            $nroLinha = 1;
                            while($exibe = mysqli_fetch_array($consulta)){
                                    $id = $exibe['id_setor'];
                                ?>
                                <tr>
                                    <td class="numero-linha"><?php echo $nroLinha++; ?></td>
                                    <td class="id-setor"><?php echo $exibe['id_setor']?></td>
                                    <td><?php echo $exibe['nome_setor']?></td>
                                    <td class="td-icons">
                                        <a class="btn-editar-setor icone-controle-editar" href="#"><span class="icon-btn-controle material-symbols-rounded">edit</span></a>
                                        <a class="btn-excluir-setor icone-controle-excluir" href="include/eSetor.php"><span class="icon-btn-controle material-symbols-rounded">delete</span></a>
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
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar setor</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- formulario envio cargo -->
                        <form class="was-validated form-container" action="include/gSetor.php" method="post">
                            <div class="mb-3">
                                <label class="font-1-s" for="setor">Nome do setor</label>
                                <input class="form-control" type="text" name="setor" id="setor" required>
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
                                <button type="button" class="btn btn-secondary btn-modal-cancelar"" data-bs-dismiss="modal">Cancelar</button>
                                <button class='btn btn-primary' type="submit">Adicionar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modalEditarSetor">
            </div>

            <div class="modalExcluir">
            </div>

        </div>

    </div>

    <?php
         include __DIR__ . '/../../../include/footer.php';
    ?>

    <script src="<?php echo BASE_URL ?>/js/modal.js"></script>
    <script src="<?php echo BASE_URL ?>/js/table.js"></script>
