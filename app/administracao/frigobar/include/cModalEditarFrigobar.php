<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if(isset($_POST['click-editar-frigobar'])){

        $id = $_POST['idFrigobar'];

        $stmt = mysqli_prepare($con, "SELECT * FROM tbl_frigobar WHERE id_frigobar = ?");
        mysqli_stmt_bind_param($stmt, 'i', $id);
        $consulta = mysqli_stmt_execute($stmt);

        if($consulta){
            $retorno = mysqli_stmt_get_result($stmt);
            $array = mysqli_fetch_all($retorno, MYSQLI_ASSOC)[0];

            $idAcomodacao = $array['id_acomodacao'];
            $nomeFrigobar = $array['nome_frigobar'];
            $capacidade = $array['capacidade_itens'];

        }
    }

?>

<!-- Modal cadastrar informações -->
<div class="modal fade" id="modalEditarFrigobar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditarFrigobarLabel" aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarFrigobarLabel">Editar frigobar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- formulario envio -->
            <form class="was-validated form-container" action="include/aFrigobar.php" method="post">
                <input type="text" name="id" id="id" value="<?php echo $id ?>" hidden>

                <div class="mb-3">
                    <label for="id-acomodacao">Número da acomodação <em>*</em></label>
                    <select class="form-select" name="id-acomodacao" required aria-label="select example">
                        <?php
                            include '../../config/conexao.php';
                            $query = "SELECT id_acomodacao, numero_acomodacao FROM tbl_acomodacao";
                            $result = mysqli_query($con, $query);
                
                            while ($row = mysqli_fetch_assoc($result)) {
                                $selected = ($row['id_acomodacao'] == $idAcomodacao) ? 'selected' : '';
                                echo "<option value='" . $row['id_acomodacao'] . "' $selected>" . $row['numero_acomodacao'] . "</option>";
                            }
                            mysqli_close($con);
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="font-1-s" for="nome-frigobar">Nome frigobar <em>*</em></label>
                    <input class="form-control" type="text" name="nome-frigobar" id="nome-frigobar" value="<?php echo $nomeFrigobar ?>" required>
                </div>

                <div class="mb-3">
                    <label class="font-1-s" for="capacidade">Capacidade <em>*</em></label>
                    <input class="form-control" type="text" name="capacidade" id="capacidade" value="<?php echo $capacidade ?>" required>
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
