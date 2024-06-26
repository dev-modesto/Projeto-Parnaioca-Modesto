<?php
    include __DIR__  . '/../../config/conexao.php';
    include __DIR__  . '/../../config/valida.php';

    include '../../include/navbar-lateral/navbar-lateral.php';
    include '../login/include/cLogin.php';

    $sql2=  "SELECT f.id_funcionario, f.nome, f.cpf, f.telefone, c.nome_cargo FROM tbl_funcionario f INNER JOIN tbl_cargo c ON f.id_cargo = c.id_cargo ORDER BY f.nome";
    $consulta = mysqli_query($con, $sql2);
    

    if(session_status() == PHP_SESSION_ACTIVE){
        echo 'ha uma sessao ativa!';
        $nomeLogado = $_SESSION['nome'];
        echo $nomeLogado;

    }
    

?>
    <div class="conteudo">
        <div class="container-conteudo-principal">
        
            <h1>Funcionarios</h1>
            <div class="container-button">
                <button type="button" class="btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <span class="material-symbols-rounded">add</span>Novo funcionário</button>
                <?php echo '<a href="./../../config/logoff.php">Fechar</a>'?>
                
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
                <table class="table table-hover text-center">
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
                                        <a class="editar-funcionario" href="#"><span class="icon-btn-controle material-symbols-rounded">edit</span></a>
                                        <a href="include/eFuncionario.php?id=<?php echo $id ?>" onclick="return confirm('Confirmar a exclusão do usuario?')"><span class="icon-btn-controle material-symbols-rounded">delete</span></a>
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
                                <input class="form-control" type="text" name="cpf" class="cpf" id="cpf" required>
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
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button class='btn btn-primary' type="submit">Adicionar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modalEditarFuncionario">
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js" integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js" integrity="sha512-0XDfGxFliYJPFrideYOoxdgNIvrwGTLnmK20xZbCAvPfLGQMzHUsaqZK8ZoH+luXGRxTrS46+Aq400nCnAT0/w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $('#cpf').mask('000.000.000-00', {reverse: true});
        $('#telefone').mask('0000000000000');

    </script>

    <script src="script.js"></script>
    <script src="../../js/modal.js"></script>
</body>
</html>