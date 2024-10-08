<?php
    $setorPagina = "Administração";
    $pagina = "Acomodação";
    $grupoPagina = "Administração geral";
    $tituloMenuPagina = "Administração";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    include BASE_PATH . '/include/funcoes/diversas/mensagem.php';

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaAdm($con, $idLogado);
    }

    $sqlInner = 
                "SELECT 
                    a.id_acomodacao, 
                    a.numero_acomodacao, 
                    t.nome_tp_acomodacao, 
                    a.nome_acomodacao, 
                    a.valor, 
                    a.capacidade_max, 
                    s.nome_status 
                FROM ((tbl_acomodacao a 
                INNER JOIN tbl_tp_acomodacao t 
                ON a.id_tp_acomodacao = t.id_tp_acomodacao)
                INNER JOIN tbl_status_geral s
                ON a.id_status = s.id_status)
    ";

    $consultaInner = mysqli_query($con, $sqlInner);

    $sqlInnerStatus = "SELECT s.nome_status FROM tbl_acomodacao a INNER JOIN tbl_status_geral s ON a.id_status = s.id_status";
    $consultaInnerStatus = mysqli_query($con, $sqlInnerStatus);
    $arrayInnerStatus = mysqli_fetch_array($consultaInnerStatus);

?>
    
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração | Acomodação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/global/global.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/navbar/navbar-lateral.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/navbar/navbar-top.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/tipografia.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/cores.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/componentes.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/modal.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/formulario.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/tabela.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/reserva/disponibilidade-reserva.css'?>">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@1,900&family=Poppins:wght@200;300;400;600;700&family=Roboto:wght@200;300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
</head>
<body>

    <?php 
        include ARQUIVO_NAVBAR;
    ?>

    <div class="conteudo">
        <div class="container-conteudo-principal">

            <?php
                msgGetValida();
                msgGetInvalida();
            ?>

            <span class="separador"></span>

            <!-- Tabela -->
            <div class="container-tabela">
                <div class="container-button">
                    <button type="button" class="cadastrar-acomodacao btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <span class="material-symbols-rounded">add</span>Nova acomodação</button>
                </div>
                <table id="myTable" class="table nowrap table-bordered table-striped order-column table-hover text-left">
                    <thead class="">
                        <tr>
                            <th scope="col">ID#</th>
                            <th scope="col">Número</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Nome acomodação</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Capacidade</th>
                            <th scope="col">Status</th>
                            <th scope="col">Controle</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            while($exibe = mysqli_fetch_array($consultaInner)){
                                    $idAcomodacao = $exibe['id_acomodacao'];
                                ?>
                                <tr data-id-acomodacao="<?php echo $idAcomodacao ?>">
                                    <td class="id-acomodacao"><?php echo $exibe['id_acomodacao']?></td>
                                    <td><?php echo $exibe['numero_acomodacao']?></td>
                                    <td><?php echo $exibe['nome_tp_acomodacao']?></td>
                                    <td><?php echo $exibe['nome_acomodacao']?></td>
                                    <td class="monetario"><?php echo $exibe['valor']?></td>
                                    <td><?php echo $exibe['capacidade_max']?></td>
                                    <!-- <td><?php echo $exibe['id_status']?></td> -->
                                    <td><span class="status-geral"><?php echo $exibe['nome_status']?></span></td>
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
                                <label for="id-tp-acomodacao">Tipo acomodação <em>*</em></label>
                                <select class="form-select" name="id-tp-acomodacao" id="id-tp-acomodacao" required aria-label="select example">
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
                                    <label class="font-1-s" for="nome-titulo">Nome título <em>*</em></label>
                                    <input class="form-control" type="text" name="nome-titulo" id="nome-titulo" required>
                                </div>

                                <div class="col mb-6">
                                    <label class="font-1-s" for="numero">Número <em>*</em></label>
                                    <input class="form-control" type="text" name="numero" id="numero" required>
                                </div>

                            </div>
                            
                            <div class="mb-3">
                                <label class="font-1-s" for="valor">Valor <em>*</em></label>
                                <input class="form-control monetario" type="text" name="valor" id="valor" required>
                            </div>

                            <div class="mb-3">
                                <label class="font-1-s" for="capacidade">Capacidade máxima <em>*</em></label>
                                <input class="form-control" type="text" name="capacidade" id="capacidade" required>
                            </div>

                            <div class="mb-3">
                                <label for="id-status">Status <em>*</em></label>
                                <select class="form-select" name="id-status" id="id-status" required aria-label="select example">
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
    include ARQUIVO_FOOTER;
?>

<script src="<?php echo BASE_URL ?>/js/modal.js"></script>


<script>

    document.querySelectorAll('.status-geral').forEach(function(element) {
        if (element.textContent.trim() === 'Ativo') {
            element.classList.add('ativo');
        } else if (element.textContent.trim() === 'Inativo') {
            element.classList.add('inativo');
        }
    });

</script>