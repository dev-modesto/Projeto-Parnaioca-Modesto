<?php
    $setorPagina = "SAC";
    $pagina = "Cadastro de clientes";
    $grupoPagina = "";
    $tituloMenuPagina = "Clientes";
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    include ARQUIVO_FUNCAO_SQL;
    include PASTA_FUNCOES . "funcaoData.php";

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        $nomeFuncionario = $_SESSION['nome'];
        segurancaSac($con, $idLogado);
        $arrayAcessoArea = consultaAcessoArea($con, $idLogado);
        $adm = $arrayAcessoArea['administracao'];
    }

    $sql = 
            "SELECT 
                c.id_cliente, 
                c.nome, 
                c.dt_nascimento, 
                c.cpf, 
                c.email, 
                c.telefone, 
                c.estado, 
                c.cidade, 
                c.id_funcionario, 
                c.dt_cadastro, 
                c.dt_atualizacao, 
                s.nome_status
            FROM tbl_cliente c
            INNER JOIN tbl_status_geral s
            ON c.id_status = s.id_status 

    ";
    $consulta = mysqli_query($con, $sql);

    $sqlInfoCliente = "SELECT s.nome_status FROM tbl_cliente c INNER JOIN tbl_status_geral s ON c.id_status = s.id_status WHERE s.nome_status = 'Ativo'";
    $consultaClienteCriterio = mysqli_query($con, $sqlInfoCliente);

    $totalClientes = mysqli_num_rows($consulta);
    $totalClientesAtivos = mysqli_num_rows($consultaClienteCriterio);
    $totalClientesInativos = ($totalClientes - $totalClientesAtivos);


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
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
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/utilidades/cards-info.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/setor/setor.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/login/login.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/reserva/disponibilidade-reserva.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/reserva/visao-geral-reservas.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/reserva/consumo-frigobar-reserva.css'?>">
    <link rel="stylesheet" href="<?php echo BASE_URL . '/css/reserva/info-reserva.css'?>">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@1,900&family=Poppins:wght@200;300;400;600;700&family=Roboto:wght@200;300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />

</head>
<body>

    <?php 
        include ARQUIVO_NAVBAR;
    ?>

    <div class="conteudo conteudo-user">
        <div class="container-conteudo-principal">

            <div class="container-cards-info-top">
                <div class="card card-top" style="border: none">
                    <div class="card-body card-info-top">
                        <span class="cor-8"><?php echo $totalClientes ?></span>
                        <p class="card-title cor-8">Total clientes</p>
                    </div>
                </div>

                <div class="card card-top" style="border: none">
                    <div class="card-body card-info-top">
                        <span class="cor-a-green4"><?php echo $totalClientesAtivos ?></span>
                        <p class="card-title cor-a-green4">Ativos</p>
                    </div>
                </div>

                <div class="card card-top" style="border: none">
                    <div class="card-body card-info-top">
                        <span class="cor-a-red4"><?php echo $totalClientesInativos ?></span>
                        <p class="card-title cor-a-red4">Inativos</p>
                    </div>
                </div>
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
                    <button type="button" class="cadastrar-cliente btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <span class="material-symbols-rounded">add</span>Novo cliente</button>
                </div>
                <table id="myTable" class="table  nowrap order-column dt-right table-hover text-center">
                    <thead class="">
                        <tr>
                            <th scope="col">ID#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">CPF</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Telefone</th>
                            <th scope="col">Data cadastro</th>
                            <th scope="col">Status</th>
                            <th scope="col">Controle</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            while($exibe = mysqli_fetch_array($consulta)){
                                    $idCliente = $exibe['id_cliente'];
                                    $dtOcorrencia = $exibe['dt_cadastro'];
                                    $dtOcorrenciaFormatada = dataHoraFormatada($dtOcorrencia);
                                ?>
                                <tr data-id-cliente="<?php echo $idCliente ?>">
                                    <td class="id-cliente"><?php echo $exibe['id_cliente']?></td>
                                    <td><?php echo $exibe['nome']?></td>
                                    <td class="cpf"><?php echo $exibe['cpf']?></td>
                                    <td><?php echo $exibe['email']?></td>
                                    <td><?php echo $exibe['telefone']?></td>
                                    <td><?php echo $dtOcorrenciaFormatada ?></td>
                                    <td><span class="status-geral"><?php echo $exibe['nome_status']?></span></td>
                                    <td class="td-icons">
                                        <a class="btn-visualizar-info-cliente icone-controle-visualizar " href="#"><span class="icon-btn-controle material-symbols-rounded">visibility</span></a>
                                        <a class="btn-editar-cliente icone-controle-editar " href="#"><span class="icon-btn-controle material-symbols-rounded">edit</span></a>
                                        <a class="btn-excluir-cliente icone-controle-excluir" href="#"><span class="icon-btn-controle material-symbols-rounded">delete</span></a>
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
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Cadastrar cliente</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- formulario envio cargo -->
                        <form class="was-validated form-container" action="include/gCliente.php" method="post">
                            <ul class="nav nav-underline">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="dados-pessoais-cliente-tab" data-bs-toggle="tab" data-bs-target="#dados-pessoais-cliente-tab-pane" type="button" role="tab" aria-controls="dados-pessoais-cliente-tab-pane" aria-selected="true">Dados pessoais</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="endereco-cliente-tab" data-bs-toggle="tab" data-bs-target="#endereco-cliente-tab-pane" type="button" role="tab" aria-controls="endereco-cliente-tab-pane" aria-selected="false">Endereço</button>
                                </li>
                            </ul>
                            <br>

                            <div class="tab-content" id="myTabContent">

                                <div class="tab-pane fade show active" id="dados-pessoais-cliente-tab-pane" role="tabpanel" aria-labelledby="dados-pessoais-cliente-tab" tabindex="0">

                                    <div class="mb-3">
                                        <label class="font-1-s" for="nome">Nome completo <em>*</em></label>
                                        <input class="form-control" type="text" name="nome" id="nome" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="font-1-s" for="cpf">CPF <em>*</em></label>
                                        <input class="form-control cpf" type="text" name="cpf" id="cpf" required>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="font-1-s" for="email">E-mail <em>*</em></label>
                                            <input class="form-control" type="email" name="email" class="email" id="email" required>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="font-1-s" for="telefone">Telefone <em>*</em></label>
                                            <input class="form-control" type="fone" name="telefone" class="telefone" id="telefone" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="font-1-s" for="data-nascimento">Data nascimento <em>*</em></label>
                                        <input class="form-control" type="date" name="data-nascimento" id="data-nascimento" required>
                                    </div>
                                    
                                </div>

                                <div class="tab-pane fade" id="endereco-cliente-tab-pane" role="tabpanel" aria-labelledby="endereco-cliente-tab" tabindex="0">
                                    <div class="mb-3">
                                        <label for="estado">Estado <em>*</em></label>
                                        <select class="form-select" name="estado" id="estado" required aria-label="select example">
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="cidade">Cidade <em>*</em></label>
                                        <select class="form-select" name="cidade" id="cidade" required aria-label="select example">
                                            <option value=""/>Escolha primeiro um estado
                                        </select>
                                    </div>
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
                                <button type="button" class="btn btn-secondary btn-modal-cancelar" data-bs-dismiss="modal">Cancelar</button>
                                <button class='btn btn-primary' type="submit">Adicionar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modalEditarCliente">
            </div>

            <div class="modalVisualizarInfoCliente">
            </div>

            <div class="modalExcluir">
            </div>

        </div>

    </div>

<?php
    include ARQUIVO_FOOTER;
?>

<script src="<?= BASE_URL ?>/js/modal.js"></script>

<script>

    document.querySelectorAll('.status-geral').forEach(function(element) {
        if (element.textContent.trim() === 'Ativo') {
            element.classList.add('ativo');
        } else if (element.textContent.trim() === 'Inativo') {
            element.classList.add('inativo');
        }
    });

    window.onload = function () {
        new dgCidadesEstados(
            document.getElementById('estado'),
            document.getElementById('cidade'),
            true
        );
    }
</script>

<script type="text/javascript" src="<?= BASE_URL ?>/js/cidades-estados-v0.2.js"></script> 
