<?php
    // include __DIR__  . '/../../../config/conexao.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;


    if(isset($_POST['click-botao-editar'])){
        $id = $_POST['idPrincipal'];

        $sql = "SELECT * FROM tbl_funcionario WHERE id_funcionario = '$id'";
        $consulta = mysqli_query($con, $sql);

        if ($array = mysqli_fetch_array($consulta)) {
            // print_r($array);
            $nome = $array['nome'];
            $cpf = $array['cpf'];
            $telefone = $array['telefone'];
            $id_cargo = $array['id_cargo'];

            $sql2 = "SELECT * FROM tbl_cargo WHERE id_cargo = '$id_cargo'";
            $consulta2 = mysqli_query($con, $sql2);
            $arrayCargo = mysqli_fetch_array($consulta2);
            
            $nomeCargo = $arrayCargo['nome_cargo'];

        } else {
            echo "nada encontrado.";
        }
    } else {
        echo "nada foi postado";
    }

?>


<!-- este modal sera carregado quando eu o chamar em outra pagina -->
<!-- Modal editar funcionario -->
<div class="modal fade" id="modalEditarFuncionario" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditarFuncionarioLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarFuncionarioLabel">Editar funcionário <em>*</em></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <!-- formulario envio cargo -->
            <form class="was-validated form-container" action="include/aFuncionario.php" method="post">
                    <input class="form-control" type="hidden" name="id-funcionario" id="id-funcionario" value="<?php echo $id ?>">

                <div class="mb-3">
                    <label class="font-1-s" for="nome">Nome completo <em>*</em></label>
                    <input class="form-control nome" type="text" name="nome" id="nome" value="<?php echo $nome ?>" required>
                </div>

                <div class="mb-3">
                    <label class="font-1-s" for="cpf">CPF <em>*</em></label>
                    <input class="form-control cpf" type="text" name="cpf" id="cpf" value="<?php echo $cpf ?>" required>
                </div>

                <div class="mb-3">
                    <label class="font-1-s" for="telefone">Telefone <em>*</em></label>
                    <input class="form-control telefone" type="fone" name="telefone" value="<?php echo $telefone ?>" id="telefone" required>
                </div>

                <div class="mb-3">
                    <label for="id_cargo">Cargo <em>*</em></label>
                    <select class="form-select id_cargo" name="id_cargo" required aria-label="select example">
                        <?php
                            include '../../config/conexao.php';
                            $query = "SELECT id_cargo, nome_cargo FROM tbl_cargo";
                            $result = mysqli_query($con, $query);
                
                                while ($row = mysqli_fetch_assoc($result)) {
                                $selected = ($row['id_cargo'] == $id_cargo) ? 'selected' : '';
                                echo "<option value='" . $row['id_cargo'] . "' $selected>" . $row['nome_cargo'] . "</option>";
                            }
                            mysqli_close($con);
                        ?>
                    </select>
                </div>

                <div class="modal-footer form-container-button">
                    <button type="button" class="btn btn-secondary btn-modal-cancelar" data-bs-dismiss="modal">Cancelar</button>
                    <button class='btn btn-primary' type="submit">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
        $('.cpf').mask('000.000.000-00', {reverse: true});
</script>