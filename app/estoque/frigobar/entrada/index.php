<?php
    $setorPagina = "Logística";
    $pagina = "Abastecer frigobar";
    $grupoPagina = "Frigobar";
    $tituloMenuPagina = "Estoque | Frigobar";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    
    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaLogistica($con, $idLogado);
    }

    $sqlInner = 
            "SELECT 
                e.id_e_item_f, 
                e.id_frigobar, 
                e.id_acomodacao, 
                a.numero_acomodacao,
                a.nome_acomodacao,
                e.id_item, 
                e.id_sku, 
                i.nome_item,
                e.quantidade,
                e.id_funcionario, 
                e.dt_entrada 
            FROM tbl_entrada_item_frigobar e 
            INNER JOIN tbl_item i 
            ON e.id_item = i.id_item
            INNER JOIN tbl_acomodacao a
            ON e.id_acomodacao = a.id_acomodacao
    ";
            
    $consulta = mysqli_query($con, $sqlInner);

?>

    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Frigobar | Abastecer frigobar</title>
        <!-- link bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- meu css -->
        <link rel="stylesheet" href="../../../../css/style.css"> <!--- precisa colocar a constante -->
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
                    <button type="button" class="cadastrar-funcionario btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <span class="material-symbols-rounded">add</span>Abastecer frigobar</button>
                </div>
                <table id="myTable" class="table  nowrap order-column dt-right table-hover text-center">
                    <thead class="">
                        <tr>
                            <th scope="col">Nº</th>
                            <th scope="col">ID item</th>
                            <th scope="col">ID frigobar</th>
                            <th scope="col">ID acomodação</th>
                            <th scope="col">Número acomodação</th>
                            <th scope="col">Nome acomodação</th>
                            <th scope="col">SKU</th>
                            <th scope="col">Nome item</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">ID funcionário</th>
                            <th scope="col">Data entrada</th>
                            <th scope="col">Controle</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            $nroLinha = 1;
                            while($exibe = mysqli_fetch_array($consulta)){
                                    $idItem = $exibe['id_item'];
                                ?>
                                <tr>
                                    <td class="numero-linha"><?php echo $nroLinha++; ?></td>
                                    <td class="id-item"><?php echo $exibe['id_item']?></td>
                                    <td class="id-frigobar"><?php echo $exibe['id_frigobar']?></td>
                                    <td class="id-acomodacao"><?php echo $exibe['id_acomodacao']?></td>
                                    <td class="numero-acomodacao"><?php echo $exibe['numero_acomodacao']?></td>
                                    <td class="nome-acomodacao"><?php echo $exibe['nome_acomodacao']?></td>
                                    <td class="id-sku"><?php echo $exibe['id_sku']?></td>
                                    <td class="Nome item"><?php echo $exibe['nome_item']?></td>
                                    <td><?php echo $exibe['quantidade']?></td>
                                    <td class="id-funcionario"><?php echo $exibe['id_funcionario']?></td>
                                    <td><?php echo $exibe['dt_entrada']?></td>
                                    <td class="td-icons">
                                        <a class="btn-editar-item icone-controle-editar " href="#"><span class="icon-btn-controle material-symbols-rounded">edit</span></a>
                                        <a class="btn-excluir-item icone-controle-excluir" href="#"><span class="icon-btn-controle material-symbols-rounded">delete</span></a>
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
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Abastecer Frigobar</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- formulario envio -->
                        <form class="was-validated form-container" action="include/gAbastecerFrigobar.php" method="post">
                            <div class="mb-3">
                                <label for="id-acomodacao">Acomodação</label>
                                <select class="form-select" name="id-acomodacao" id="id-acomodacao" required aria-label="select example">
                                    <option value="">Selecione uma acomodação</option>
                                    <?php
                                        include '../../config/conexao.php';
                                        $query = "SELECT id_acomodacao, numero_acomodacao, nome_acomodacao FROM tbl_acomodacao";
                                        $result = mysqli_query($con, $query);
                            
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='" . $row['id_acomodacao'] . "'>" . $row['numero_acomodacao'] . "</option>";
                                        }
                                        mysqli_close($con);
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="font-1-s" for="sku">SKU do produto</label>
                                <input class="form-control" type="text" name="sku" id="sku" required>
                            </div>

                            <div class="mb-3">
                                <label class="font-1-s" for="nome-produto">Nome produto</label>
                                <input class="form-control" type="text" name="nome-produto" id="nome-produto" readonly required>
                            </div>

                            <div class="mb-3">
                                <label class="font-1-s" for="quantidade">Quantidade</label>
                                <input class="form-control" type="text" name="quantidade" id="quantidade" required>
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

            <div class="modalEditarAbastecimentoFigobar">
            </div>

            <div class="modalExcluir">
            </div>

        </div>

    </div>

    <?php
        include ARQUIVO_FOOTER;
    ?>

    <script src="<?php echo BASE_URL ?>/js/modal.js"></script>
    <script src="<?php echo BASE_URL ?>/js/table.js"></script>

