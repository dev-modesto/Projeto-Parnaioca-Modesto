<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_SEGURANCA;
    include ARQUIVO_NAVBAR;

    $sql = "SELECT * FROM tbl_acomodacao";
    $consulta = mysqli_query($con, $sql);

    $sqlInner = "SELECT a.id_acomodacao, a.numero_acomodacao, t.nome_tp_acomodacao, a.nome_acomodacao, a.valor, a.capacidade_max, a.id_status 
                    FROM tbl_acomodacao a 
                    INNER JOIN tbl_tp_acomodacao t ON a.id_tp_acomodacao = t.id_tp_acomodacao";

    $consultaInner = mysqli_query($con, $sqlInner);
    $array = mysqli_fetch_array($consultaInner);
    
    $nomeTpAcomodacao = $array['nome_tp_acomodacao'];

    // $sqlInnerStatus = "SELECT s.nome_status FROM tbl_acomodacao a INNER JOIN tbl_status_geral s ON a.id_status = s.id_status";
    // $consultaInnerStatus = mysqli_query($con, $sqlInnerStatus);
    // $arrayInnerStatus = mysqli_fetch_array($consultaInnerStatus);

    if (session_status() == PHP_SESSION_ACTIVE) {
        $nomeLogado = $_SESSION['id'];
    }

?>
    
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Administração | Acomodação</title>
        <!-- link bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- meu css -->
        <link rel="stylesheet" href="../../../css/style.css"> <!--- precisa colocar a constante -->
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

            <?php
                if(isset($_GET['msgInvalida'])){
                    $msg = $_GET['msgInvalida'];
                    echo '<div class="alert alert-danger  alert-dismissible fade show" role="alert">
                            '. $msg .'
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                }
            
            ?>

            <span class="separador"></span>

            <!-- Tabela -->
            <div class="container-tabela">
                <div class="container-button">
                    <button type="button" class="cadastrar-acomodacao btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <span class="material-symbols-rounded">add</span>Nova acomodação</button>
                </div>
                <table id="myTable" class="table nowrap order-column table-hover text-left">
                    <thead class="">
                        <tr>
                            <th scope="col">Nº</th>
                            <th scope="col">id</th>
                            <th scope="col">Número</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Nome acomodação</th>
                            <th scope="col">Valor(R$)</th>
                            <th scope="col">Capacidade</th>
                            <th scope="col">Status</th>
                            <th scope="col">Controle</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            $nroLinha = 1;
                            while($exibe = mysqli_fetch_array($consulta)){
                                    $id = $exibe['id_acomodacao'];
                                ?>
                                <tr>
                                    <td class="numero-linha"><?php echo $nroLinha++; ?></td>
                                    <td class="id-acomodacao"><?php echo $exibe['id_acomodacao']?></td>
                                    <td><?php echo $exibe['numero_acomodacao']?></td>
                                    <td><?php echo $array['nome_tp_acomodacao']?></td>
                                    <td><?php echo $exibe['nome_acomodacao']?></td>
                                    <td><?php echo $exibe['valor']?></td>
                                    <td><?php echo $exibe['capacidade_max']?></td>
                                    <!-- <td><?php echo $exibe['id_status']?></td> -->
                                    <td><?php echo $exibe['id_status']?></td>
                                    <td class="td-icons">
                                        <a class="btn-editar-acomodacao icone-controle-editar" href="#"><span class="icon-btn-controle material-symbols-rounded">edit</span></a>
                                        <a class="btn-excluir-acomodacao icone-controle-excluir" href="#"><span class="icon-btn-controle material-symbols-rounded">delete</span></a>
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
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar acomodação</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- formulario envio -->
                        <form class="was-validated form-container" action="include/gAcomodacao.php" method="post">
                            <div class="mb-3">
                                <label for="id-tp-acomodacao">Tipo acomodação</label>
                                <select class="form-select" name="id-tp-acomodacao" required aria-label="select example">
                                    <option value="">-</option>
                                    
                                    <?php
                                        $sqlConsulta1 = "SELECT * FROM tbl_tp_acomodacao";
                                        $consultaTpAcomodacao = mysqli_query($con, $sqlConsulta1);

                                        while($row = mysqli_fetch_assoc($consultaTpAcomodacao)){
                                            echo "<option value='" . $row['id_tp_acomodacao'] . "'>" . $row['nome_tp_acomodacao'] . "</option>";
                                        }
                                    ?>

                                </select>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col mb-6">
                                    <label class="font-1-s" for="nome-titulo">Nome título</label>
                                    <input class="form-control" type="text" name="nome-titulo" id="validationText" required>
                                </div>

                                <div class="col mb-6">
                                    <label class="font-1-s" for="numero">Número</label>
                                    <input class="form-control" type="text" name="numero" id="validationText" required>
                                </div>

                            </div>
                            
                            <div class="mb-3">
                                <label class="font-1-s" for="valor">Valor</label>
                                <input class="form-control monetario" type="text" name="valor" id="validationText" required>
                            </div>



                            <div class="mb-3">
                                <label class="font-1-s" for="capacidade">Capacidade máxima</label>
                                <input class="form-control" type="text" name="capacidade" id="validationText" required>
                            </div>

                            <div class="mb-3">
                                <label for="id-status">Status</label>
                                <select class="form-select" name="id-status" required aria-label="select example">
                                    <option value="">Selecione um status</option>
                                    
                                    <?php
                                        $sqlConsulta = "SELECT * FROM tbl_status_geral";
                                        $consultaStatus = mysqli_query($con, $sqlConsulta);

                                        while($row = mysqli_fetch_assoc($consultaStatus)){
                                            echo "<option value='" . $row['id_status'] . "'>" . $row['nome_status'] . "</option>";
                                        }
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

            <div class="modalEditarAcomodacao">
            </div>

            <div class="modalExcluir">
            </div>

        </div>

    </div>

    <?php
        include __DIR__ . '/../../../include/footer.php';
    ?>

    <!-- <script src="../../js/modal.js"></script> -->
    <script src="<?php echo BASE_URL ?>/js/modal.js"></script>
    <script src="<?php echo BASE_URL ?>/js/table.js"></script>

