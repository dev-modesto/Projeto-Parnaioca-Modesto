<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    // include ARQUIVO_CONEXAO;
    // include ARQUIVO_SEGURANCA;
    // include ARQUIVO_NAVBAR;

    
    $sql = "SELECT c.id_cargo, c.nome_cargo, c.salario, s.nome_setor FROM tbl_cargo c INNER JOIN tbl_setor s ON c.id_setor = s.id_setor ORDER BY c.id_cargo";

    $consulta = mysqli_query($con, $sql);
?>

    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Administração | Cargos</title>
        <!-- link bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- meu css -->
        <link rel="stylesheet" href="../../../css/style.css">
        <!-- meus icons -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" />

        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@1,900&family=Poppins:wght@400;600&family=Roboto:wght@500&display=swap" rel="stylesheet">
   
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
                    <button type="button" class="cadastrar-cargo btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <span class="material-symbols-rounded">add</span>Novo cargo</button>
                </div>
                <table id="myTable" class="table table-hover text-center">
                    <thead class="">
                        <tr>
                            <th scope="col">Nº</th>
                            <th scope="col">idCargo</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Salário</th>
                            <th scope="col">Setor</th>
                            <th scope="col">Controle</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            $nroLinha = 1;
                            while($exibe = mysqli_fetch_array($consulta)){
                                    $id = $exibe['id_cargo'];
                                ?>
                                <tr>
                                    <td class="numeroLinha"><?php echo $nroLinha++; ?></td>
                                    <td class="id-cargo"><?php echo $exibe['id_cargo']?></td>
                                    <td><?php echo $exibe['nome_cargo']?></td>
                                    <td class="monetario"><?php echo $exibe['salario']?></td>
                                    <td><?php echo $exibe['nome_setor']?></td>
                                    <td class="td-icons">
                                        <a class="btn-editar-cargo icone-controle-editar" href="#"><span class="icon-btn-controle material-symbols-rounded">edit</span></a>
                                        <a class="btn-excluir-cargo icone-controle-excluir" href="#"><span class="icon-btn-controle material-symbols-rounded">delete</span></a>
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
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar cargo</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- formulario envio cargo -->
                        <form class="was-validated form-container" action="include/gCargo.php" method="post">
                            <div class="mb-3">
                                <label class="font-1-s" for="cargo">Cargo</label>
                                <input class="form-control" type="text" name="cargo" id="validationText" required>
                                <div class="invalid-feedback">
                                    
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="font-1-s" for="salario">Salário</label>
                                <input class="form-control monetario" type="text" name="salario" id="salario" required>
                                <!-- <p id="info-validaCpf"></p> -->
                                <div class="invalid-feedback">
                                
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="idSetor">Setor</label>
                                <select class="form-select" name="idSetor" id="idSetor" required>
                                    <?php
                                        include '../../config/conexao.php';
                                        $query = "SELECT id_setor, nome_setor FROM tbl_setor";
                                        $result = mysqli_query($con, $query);
                                        
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='" . $row['id_setor'] . "'>" . $row['nome_setor'] . "</option>";
                                        }
                                        mysqli_close($con);
                                        ?>
                                </select>
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

            <div class="modalEditarCargo">
            </div>

            <div class="modalExcluir">
            </div>

        </div>

    </div>

    <?php
        include __DIR__ . '/../../../include/footer.php';
    ?>

    <!-- <script src="../../../js/modal.js"></script> -->
    <script src="<?php echo BASE_URL ?>/js/modal.js"></script>
    <script src="<?php echo BASE_URL ?>/js/table.js"></script>
