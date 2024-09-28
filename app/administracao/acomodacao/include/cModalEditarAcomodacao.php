<?php
    // include __DIR__  . '/../../../config/conexao.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;

    if(isset($_POST['click-editar-acomodacao'])){
        $id = $_POST['idPrincipal'];

        $sql = 
            "SELECT
            a.numero_acomodacao, 
            t.nome_tp_acomodacao, 
            a.nome_acomodacao, 
            a.valor, 
            a.capacidade_max, 
            s.nome_status 
            FROM tbl_acomodacao a
            INNER JOIN tbl_tp_acomodacao t
            ON a.id_tp_acomodacao = t.id_tp_acomodacao
            INNER JOIN tbl_status_geral s
            ON a.id_status = s.id_status WHERE id_acomodacao = '$id'
        ";

        $consultaInner = mysqli_query($con, $sql);


        if($consultaInner){
            $array = mysqli_fetch_all($consultaInner, MYSQLI_ASSOC)[0];

            $numero = $array['numero_acomodacao'];
            $nomeTpAcomodacao = $array['nome_tp_acomodacao'];
            $nomeAcomodacao = $array['nome_acomodacao'];
            $valor = $array['valor'];
            $capacidadeMax = $array['capacidade_max'];
            $nomeStatus = $array['nome_status'];

            $sqlStatus = "SELECT * FROM tbl_acomodacao WHERE id_acomodacao = '$id'";
            $consultaPadrao = mysqli_query($con, $sqlStatus);
            $arrayPadrao = mysqli_fetch_all($consultaPadrao, MYSQLI_ASSOC)[0];

            $idTpAcomodacao = $arrayPadrao['id_tp_acomodacao'];
            $idStatus = $arrayPadrao['id_status'];

        }
    } else {
        echo "";
    }
?>

<!-- Modal cadastrar informações -->
<div class="modal fade" id="modalEditarAcomodacao" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditarAcomodacaoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarAcomodacao">Cadastrar acomodação</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- formulario envio -->
            <form class="was-validated form-container" action="include/aAcomodacao.php" method="post">
                <input type="text" name="idAcomodacao" id="idAcomodacao" value="<?php echo $id ?>" hidden>

                <div class="mb-3">
                    <label for="id-tp-acomodacao">Tipo acomodação <em>*</em></label>
                    <select class="form-select" name="id-tp-acomodacao" id="id-tp-acomodacao" required aria-label="select example">
                        <?php
                            $sqlConsulta1 = "SELECT * FROM tbl_tp_acomodacao";
                            $consultaTpAcomodacao = mysqli_query($con, $sqlConsulta1);

                            while($row = mysqli_fetch_assoc($consultaTpAcomodacao)){
                                $selected = ($row['id_tp_acomodacao'] == $idTpAcomodacao) ? 'selected' : '';
                                echo "<option value='" . $row['id_tp_acomodacao'] . "' $selected>" . $row['nome_tp_acomodacao'] . "</option>";
                            }
                        ?>

                    </select>
                </div>
                
                <div class="row mb-3">
                    <div class="col mb-6">
                        <label class="font-1-s" for="nome-titulo">Nome título <em>*</em></label>
                        <input class="form-control" type="text" name="nome-titulo" id="nome-titulo" value="<?php echo $nomeAcomodacao ?>" required>
                    </div>

                    <div class="col mb-6">
                        <label class="font-1-s" for="numero">Número <em>*</em></label>
                        <input class="form-control" type="text" name="numero" id="numero" value="<?php echo $numero ?>" required>
                    </div>

                </div>
                
                <div class="mb-3">
                    <label class="font-1-s" for="valor">Valor <em>*</em></label>
                    <input class="form-control monetario" type="text" name="valor" id="valor" value="<?php echo $valor?>" required>
                </div>

                <div class="mb-3">
                    <label class="font-1-s" for="capacidade">Capacidade máxima <em>*</em></label>
                    <input class="form-control" type="text" name="capacidade" id="capacidade" value="<?php echo $capacidadeMax ?>" required>
                </div>

                <div class="mb-3">
                    <label for="id-status">Status <em>*</em></label>
                    <select class="form-select" name="id-status" id="id-status" required aria-label="select example">
                        <?php
                            $sqlConsulta = "SELECT * FROM tbl_status_geral";
                            $consultaStatus = mysqli_query($con, $sqlConsulta);

                            while($row = mysqli_fetch_assoc($consultaStatus)){
                                $selected = ($row['id_status'] == $idStatus) ? 'selected' : '';
                                echo "<option value='" . $row['id_status'] . "' $selected >" . $row['nome_status'] . "</option>";
                            }
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
    $('.monetario').mask('000.000.000.000.000,00', {reverse: true});
</script>

