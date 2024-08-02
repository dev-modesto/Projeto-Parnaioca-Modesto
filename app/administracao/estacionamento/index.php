<?php
    $setorPagina = "Administração";
    $pagina = "Estacionamento";
    $grupoPagina = "Administração geral";
    $tituloMenuPagina = "Administração";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaAdm($con, $idLogado);
    }

    $sql = 
            "SELECT 
            e.id_estacionamento, 
            a.numero_acomodacao, 
            e.numero_vaga
            FROM
            tbl_estacionamento e
            INNER JOIN 
            tbl_acomodacao a
            ON
            e.id_acomodacao = a.id_acomodacao"
    ;
    
    $consulta = mysqli_query($con, $sql);



?>

    <!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Administração | Estacionamento</title>
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
                    <button type="button" class="cadastrar-estacionamento btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <span class="material-symbols-rounded">add</span>Nova vaga</button>
                </div>
                <table id="myTable" class="table table-hover text-center">
                    <thead class="">
                        <tr>
                            <th scope="col">ID#</th>
                            <th scope="col">Número acomodação</th>
                            <th scope="col">Vaga</th>
                            <th scope="col">Controle</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            while($exibe = mysqli_fetch_array($consulta)){
                                    $idVagaEstacionamento = $exibe['id_estacionamento'];
                                ?>
                                <tr data-id-vaga-estacionamento="<?php echo $idVagaEstacionamento ?>">
                                    <td class="id-vaga-estacionamento"><?php echo $exibe['id_estacionamento']?></td> 
                                    <td class="id-acomodacao"><?php echo $exibe['numero_acomodacao']?></td>
                                    <td class="numero-vaga"><?php echo $exibe['numero_vaga']?></td>
                                    <td class="td-icons">
                                        <a class="btn-editar-vaga-estacionamento icone-controle-editar" href="#"><span class="icon-btn-controle material-symbols-rounded">edit</span></a>
                                        <a class="btn-excluir-vaga-estacionamento icone-controle-excluir" href="#"><span class="icon-btn-controle material-symbols-rounded">delete</span></a>
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
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar vaga estacionamento</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- formulario envio -->
                        <form class="was-validated form-container" action="include/gVagaEstacionamento.php" method="post">
                            <div class="mb-3">
                                <label for="id-numero-acomodacao">Número da acomodação <em>*</em></label>
                                <select class="form-select" name="id-numero-acomodacao" id="id-numero-acomodacao" required aria-label="select example">
                                    <option value="">Selecione o número da acomodação</option>
                                    <?php
                                        include '../../config/conexao.php';
                                        $query = "SELECT * FROM tbl_acomodacao";
                                        $result = mysqli_query($con, $query);
                            
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='" . $row['id_acomodacao'] . "'>" . $row['numero_acomodacao'] . "</option>";
                                        }
                                        mysqli_close($con);
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="font-1-s" for="numero-vaga-estacionamento">Número da vaga <em>*</em></label>
                                <input class="form-control" type="text" name="numero-vaga-estacionamento" id="numero-vaga-estacionamento" required>
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

            <div class="modalEditarVagaEstacionamento">
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
