<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    include './aFuncionario.php';

    if(isset($_GET['id'])){
        $id = $_GET['id'];

        $sql = "SELECT * FROM tbl_funcionario WHERE id_funcionario = '$id'";
        $consulta = mysqli_query($con, $sql);

        if($array = mysqli_fetch_array($consulta)){
            // echo "<pre>";
            // echo print_r($array);

            $nome = $array['nome'];
            $cpf = $array['cpf'];
            $telefone = $array['telefone'];
            $id_cargo = $array['id_cargo'];

            $sql2 = "SELECT * FROM tbl_cargo WHERE id_cargo = '$id_cargo'";
            $consulta2 = mysqli_query($con, $sql2);
            $arrayCargo = mysqli_fetch_array($consulta2);
            
            $nomeCargo = $arrayCargo['nome_cargo'];


        }else{
            echo "nada encontrado!";
        }
        // header('location: ../index.php?');
    }else{
        echo "id nao encontrado!!";
    }
?>

<!-- Modal editar informações -->
<div class="modal fade" id="modalEditar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar funcionário</h1>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>

            <!-- formulario envio cargo -->
            <form class="was-validated form-container" action="aFuncionario.php?id=<?php echo $_GET['id']?>" method="post">
                
                <div class="mb-3">
                    <label class="font-1-s" for="nome">Nome completo</label>
                    <input class="form-control" type="text" name="nome" id="nome" value="<?php echo $nome ?>" required>
                    <div class="invalid-feedback">
                        
                    </div>
                </div>

                <div class="mb-3">
                    <label class="font-1-s" for="cpf">CPF</label>
                    <input class="form-control" type="text" name="cpf" class="cpf" id="cpf" value="<?php echo $cpf ?>" required>
                    <!-- <p id="info-validaCpf"></p> -->
                    <div class="invalid-feedback">
                        
                    </div>
                </div>

                <div class="mb-3">
                    <label class="font-1-s" for="telefone">Telefone</label>
                    <input class="form-control" type="fone" name="telefone" class="telefone" id="telefone"  value="<?php echo $telefone ?>"required>
                    <div class="invalid-feedback">
                        
                    </div>
                </div>

                <div class="mb-3">
                    <label for="id_cargo">Cargo</label>
                    <select class="form-select" name="id_cargo" id="id_cargo" required aria-label="select example">
                        <option value="<?php echo $id_cargo?>"><?php echo $nomeCargo ?></option>
                        <?php
                            // include '../../config/conexao.php';
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
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $mensagem ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div> 
                <?php }else {
                        echo '';
                    }
                ?>

                <div class="modal-footer form-container-button">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button class='btn btn-primary' type="submit" name="update-data">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>