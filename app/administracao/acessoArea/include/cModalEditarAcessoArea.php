<?php
    // include __DIR__  . '/../../../config/conexao.php';
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    session_start();

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
    }

    if(isset($_POST['click-editar-acesso-area'])){
        $id = $_POST['idPrincipal'];
        $nivelAcessoLogado = verificaNivelAcesso($con, $idLogado);
        $nivelLogado = $nivelAcessoLogado['nivel_acesso'];

        $sql = 
            "SELECT
                a.id, 
                a.id_funcionario,
                f.nome, 
                a.sac, 
                a.logistica, 
                a.administracao 
            FROM tbl_acesso_area a
            INNER JOIN tbl_funcionario f
            ON a.id_funcionario = f.id_funcionario WHERE a.id_funcionario = '$id'
        ";

        $consulta = mysqli_query($con, $sql);

        if($consulta){
            $array = mysqli_fetch_array($consulta);

            $nomeFuncionario = $array['nome'];
            $sac = $array['sac'];
            $logistica = $array['logistica'];
            $administracao = $array['administracao'];

        }

        $consultaNivelAcesso = verificaNivelAcesso($con, $id);
        $nivelAcesso = $consultaNivelAcesso['nivel_acesso'];

    } else {
        echo "";
    }
?>

<!-- Modal cadastrar informações -->
<div class="modal fade" id="modalEditarAcessoArea" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditarAcessoArea" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalEditarAcessoArea">Permissão de acesso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form class="was-validated form-container" id="accessForm" action="include/aAcessoArea.php" method="post">
                <input type="text" name="id-funcionario" id="id-funcionario" value="<?php echo $id ?>" hidden>
                
                <div class="row mb-3">
                    <div class="col mb-6">
                        <h6>Nome: <?php echo $nomeFuncionario ?></h6> 
                        <h6>Matrícula: <?php echo $id ?></h6> 
                    </div>
                </div>
                
                <div class="mb-3 btn-group container-paginas-acesso" role="group" aria-label="Basic checkbox toggle button group">
                    <label for="nivel">Páginas de acesso <em>*</em></label>
                    <div>
                        <input type="checkbox" class="btn-check" id="btn-sac" name="sac" autocomplete="off" <?php echo $sac == 1 ? 'checked' : '' ?> >
                        <label class="btn btn-outline-primary btn-sac" for="btn-sac">SAC</label>

                        <input type="checkbox" class="btn-check" id="btn-logistica" name="logistica" autocomplete="off" <?php echo $logistica == 1 ? 'checked' : '' ?>>
                        <label class="btn btn-outline-primary" for="btn-logistica">Logística</label>

                        <input type="checkbox" class="btn-check" id="btn-administracao" name="administracao" autocomplete="off" <?php echo $administracao == 1 ? 'checked' : '' ?>>
                        <label class="btn btn-outline-primary" for="btn-administracao">Administração</label>
                    </div>
                </div>
                
                <?php
                    if($nivelLogado > 0) {
                        ?>
                            <div class="mb-3" required>
                                <label for="nivel">Nível de Usuário <em>*</em></label>
                                <div>
                                    <input type="radio" id="nivel-usuario" name="nivel-usuario" value="0" <?php if($nivelAcesso == 0) echo 'checked' ?> > Usuário padrão <br>
                                    <input type="radio" id="nivel-usuario" name="nivel-usuario" value="1" <?php if($nivelAcesso == 1) echo 'checked' ?> > Administrador<br>
                                </div>
                            </div>
                        <?php
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

<script>

    document.getElementById('accessForm').addEventListener('submit', function(event) {
        var sac = document.getElementById('btn-sac');
        var logistica = document.getElementById('btn-logistica');
        var administracao = document.getElementById('btn-administracao');

        sac.value = sac.checked ? 1 : 0;
        logistica.value = logistica.checked ? 1 : 0;
        administracao.value = administracao.checked ? 1 : 0;
    });

    document.getElementById('btn-administracao').addEventListener('change', function() {
        var sacCheckbox = document.getElementById('btn-sac');
        var logisticaCheckbox = document.getElementById('btn-logistica');
        var adminChecked = this.checked;

        sacCheckbox.checked = adminChecked;
        logisticaCheckbox.checked = adminChecked;
    });

</script>

