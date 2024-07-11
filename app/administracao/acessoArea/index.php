<?php
    $setorPagina = "Administração";
    $pagina = "Nível de acesso";
    $grupoPagina = "Nível de acesso";
    $tituloMenuPagina = "Administração";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaAdm($con, $idLogado);
    }
    
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
        ON a.id_funcionario = f.id_funcionario
    ";

    $consulta = mysqli_query($con, $sql);

?>
    
    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Administração | Nível de acesso</title>
        <!-- link bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <!-- meu css -->
        <link rel="stylesheet" href="../../../css/style.css">
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
                <!-- <div class="container-button">
                    <button type="button" class="cadastrar-acomodacao btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <span class="material-symbols-rounded">add</span>Nova acomodação</button>
                </div> -->
                <table id="myTable" class="table nowrap order-column table-hover text-left">
                    <thead class="">
                        <tr>
                            <th scope="col">Nº</th>
                            <th scope="col">id</th>
                            <th scope="col">Matrícula</th>
                            <th scope="col">Nome</th>
                            <th scope="col">SAC</th>
                            <th scope="col">Logística</th>
                            <th scope="col">Administração</th>
                            <th scope="col">Controle</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            $nroLinha = 1;
                            while($exibe = mysqli_fetch_array($consulta)){
                                    $id = $exibe['id'];
                                ?>
                                <tr>
                                    <td class="numero-linha"><?php echo $nroLinha++; ?></td>
                                    <td class="id"><?php echo $exibe['id']?></td>
                                    <td class="id-funcionario"><?php echo $exibe['id_funcionario']?></td>
                                    <td><?php echo $exibe['nome']?></td>
                                    <td class="legenda"><span class="legenda-acesso"><?php echo $exibe['sac']?></span></td>
                                    <td class="legenda"><span class="legenda-acesso"><?php echo $exibe['logistica']?></span></td>
                                    <td class="legenda"><span class="legenda-acesso"><?php echo $exibe['administracao']?></span></td>
                                    <td class="td-icons">
                                        <a class="btn-editar-acesso-area icone-controle-editar" href="#"><span class="icon-btn-controle material-symbols-rounded">edit</span></a>
                                    </td>
                                </tr>
                                <?php
                            }
                        ?>
                    </tbody>

                </table>
            </div>

            <div class="modalEditarAcessoArea">
            </div>

        </div>

    </div>

    <?php
        include __DIR__ . '/../../../include/footer.php';
    ?>

    <script src="<?php echo BASE_URL ?>/js/modal.js"></script>
    <script src="<?php echo BASE_URL ?>/js/table.js"></script>


    <script>

        var legenda = document.querySelectorAll('.legenda-acesso').forEach(function (element) {
            if (element.textContent.trim() == 1 ) {
                element.innerHTML = 'Sim';
                element.classList.add('sim');
            } else {
                element.innerHTML = 'Não';
                element.classList.add('não');
            }
        })

    </script>