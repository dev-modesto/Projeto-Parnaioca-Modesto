<?php
    include __DIR__  . '/../../config/conexao.php';
    include '../../include/navbar-lateral/navbar-lateral.php';
    // include __DIR__  . '/../../config/seguranca.php';

    $maxItensPagina = 10;

    $sql_count = "SELECT COUNT(id_acomodacao) AS total FROM tbl_acomodacao";
    $result_count = mysqli_query($con, $sql_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $total_results = $row_count['total'];

    $total_pages = ceil($total_results / $maxItensPagina);

    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
    if ($page > $total_pages) {
        $page = $total_pages;
    } elseif ($page < 1) {
        $page = 1;
    }

    $offset = ($page - 1) * $maxItensPagina;

    if (session_status() == PHP_SESSION_ACTIVE) {
        $nomeLogado = $_SESSION['id'];
    }

    // consulta sql para exibir dados da tabela
    $sql = 'SELECT * FROM tbl_acomodacao';
    $consulta = mysqli_query($con, $sql);

?>
    <div class="conteudo">
        <div class="container-conteudo-principal">
            <div class="titulo-pagina">
                <h1>Lista de acomodações</h1>
            </div>

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

            <?php if(!empty($newMensage)){ ?>  
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $newMensage ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div> 
            <?php }else {
                    echo '';
                }
            ?>

            <!-- Tabela -->
            <div class="container-tabela">
                <div class="container-button">
                    <button type="button" class="cadastrar-funcionario btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <span class="material-symbols-rounded">add</span>Nova acomodação</button>
                    
                    </div>
                    <table class="table table-hover text-center">
                        <thead class="">
                            <tr>
                                <th scope="col">Nº</th>
                                <th scope="col">id tipo</th>
                                <th scope="col">Número</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Valor</th>
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
                                        <td class="id-acomodacao" hidden><?php echo $exibe['id_acomodacao']?></td>
                                        <td><?php echo $exibe['numero_acomodacao']?></td>
                                        <td><?php echo $exibe['id_tp_acomodacao']?></td>
                                        <td><?php echo $exibe['nome_acomodacao']?></td>
                                        <td><?php echo $exibe['valor']?></td>
                                        <td><?php echo $exibe['capacidade']?></td>
                                        <td><?php echo $exibe['status']?></td>
                                        <td class="td-icons">
                                            <a class="btn-editar-acomodacao" href="#"><span class="icon-btn-controle material-symbols-rounded">edit</span></a>
                                            <a href="include/eAcomodacao.php?id=<?php echo $id ?>" onclick="return confirm('Confirmar a exclusão da acomodação?')"><span class="icon-btn-controle material-symbols-rounded">delete</span></a>
                                        </td>

                                        
                                        </td>
                                    </tr>
                                    <?php
                                }
                            ?>
                        </tbody>
                    
                    </table>
                
                    <!-- Paginação -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end">
                            <?php if ($page > 1): ?>
                                <li class="page-item <?php if ($page == 1) echo "disabled"; ?>">
                                    <a class="page-link" href="?page=<?php echo $page-1; ?>" aria-label="Previous">
                                        <span class="material-symbols-rounded">chevron_left</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                            
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                    <a class="page-link page-link-ativo" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?php echo $page+1; ?>" aria-label="Next">
                                        <span class="material-symbols-rounded">chevron_right</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>

                </div>

                <!-- Modal cadastrar informações -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar acomodação</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <!-- formulario envio acomodação -->
                            <form class="was-validated form-container" action="include/gAcomodacao.php" method="post">
                                <div class="mb-3">
                                    <label class="font-1-s" for="acomodacao">Nome da acomodação</label>
                                    <input class="form-control" type="text" name="acomodacao" id="acomodacao" required>
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
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button class='btn btn-primary' type="submit">Adicionar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modalEditarAcomodacao">
                </div>

            </div>

    </div>

    <?php
       include ARQUIVO_FOOTER;;
    ?>

    <script src="../../js/modal.js"></script>
