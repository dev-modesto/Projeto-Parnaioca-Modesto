<?php
    include __DIR__  . '/../../config/conexao.php';
    include __DIR__  . '/../../config/seguranca.php';
    // include __DIR__  . '/../../config/config.php';

    include '../../include/navbar/navbar-lateral.php';
    include '../login/include/cLogin.php';

    $maxItensPagina = 10;

    $sql_count = "SELECT COUNT(id_funcionario) AS total FROM tbl_funcionario";
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

    $sql2= "SELECT f.id_funcionario, f.nome, f.cpf, f.telefone, c.nome_cargo FROM tbl_funcionario f INNER JOIN tbl_cargo c ON f.id_cargo = c.id_cargo ORDER BY f.nome LIMIT $offset, $maxItensPagina";
    $consulta = mysqli_query($con, $sql2);

    if (session_status() == PHP_SESSION_ACTIVE) {
        $nomeLogado = $_SESSION['id'];
    }

?>

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
                <button type="button" class="cadastrar-funcionario btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <span class="material-symbols-rounded">add</span>Novo funcionário</button>
                


            </div>
                <table class="table  table-hover text-center">
                    <thead class="">
                        <tr>
                            <th scope="col">Nº</th>
                            <th scope="col">Matrícula</th>
                            <th scope="col">Nome</th>
                            <th scope="col">CPF</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Cargo</th>
                            <th scope="col">Controle</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            $nroLinha = 1;
                            while($exibe = mysqli_fetch_array($consulta)){
                                    $id = $exibe['id_funcionario'];
                                ?>
                                <tr>
                                    <td class="numero-linha"><?php echo $nroLinha++; ?></td>
                                    <td class="id-funcionario"><?php echo $exibe['id_funcionario']?></td>
                                    <td><?php echo $exibe['nome']?></td>
                                    <td><?php echo $exibe['cpf']?></td>
                                    <td><?php echo $exibe['telefone']?></td>
                                    <td><?php echo $exibe['nome_cargo']?></td>
                                    <td class="td-icons">
                                        <a class="btn-editar-funcionario icone-controle-editar " href="#"><span class="icon-btn-controle material-symbols-rounded">edit</span></a>
                                        <a class="btn-excluir-funcionario icone-controle-excluir" href="#"><span class="icon-btn-controle material-symbols-rounded">delete</span></a>
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
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar funcionário</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- formulario envio cargo -->
                        <form class="was-validated form-container" action="include/gFuncionario.php" method="post">
                            <div class="mb-3">
                                <label class="font-1-s" for="nome">Nome completo</label>
                                <input class="form-control" type="text" name="nome" id="validationText" required>
                                <div class="invalid-feedback">
                                    
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="font-1-s" for="cpf">CPF</label>
                                <input class="form-control cpf" type="text" name="cpf" id="cpf" required>
                                <!-- <p id="info-validaCpf"></p> -->
                                <div class="invalid-feedback">
                                
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="font-1-s" for="telefone">Telefone</label>
                                <input class="form-control" type="fone" name="telefone" class="telefone" id="telefone" required>
                                <div class="invalid-feedback">
                                    
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="id_cargo">Cargo</label>
                                <select class="form-select" name="id_cargo" required aria-label="select example">
                                    <option value="">Selecione um cargo</option>
                                    <?php
                                        include '../../config/conexao.php';
                                        $query = "SELECT id_cargo, nome_cargo FROM tbl_cargo";
                                        $result = mysqli_query($con, $query);
                            
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='" . $row['id_cargo'] . "'>" . $row['nome_cargo'] . "</option>";
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

            <div class="modalEditarFuncionario">
            </div>

            <div class="modalExcluir">
            </div>

        </div>

    </div>

    <?php
        include __DIR__ . '/../../include/footer.php';
    ?>

    <script src="../../js/modal.js"></script>
