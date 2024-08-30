<?php
    $setorPagina = "Administração";
    $pagina = "Funcionários";
    $grupoPagina = 'Administração geral';
    $tituloMenuPagina = 'Administração';
    
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    include BASE_PATH . '/include/funcoes/diversas/mensagem.php';
    
    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaAdm($con, $idLogado);
    }

    $sql2= "SELECT f.id_funcionario, f.nome, f.cpf, f.telefone, c.nome_cargo FROM tbl_funcionario f INNER JOIN tbl_cargo c ON f.id_cargo = c.id_cargo ORDER BY f.nome";
    $consulta = mysqli_query($con, $sql2);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração | Funcionários</title>
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
                    <button type="button" class="cadastrar-funcionario btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#staticBackdrop"> <span class="material-symbols-rounded">add</span>Novo funcionário</button>
                </div>
                <table id="myTable" class="table table-bordered table-striped table-bordered table-striped nowrap order-column dt-right table-hover text-center">
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
                                    $idFuncionario = $exibe['id_funcionario'];
                                ?>
                                <tr data-id-funcionario="<?php echo $idFuncionario ?>">
                                    <td class="numero-linha"><?php echo $nroLinha++; ?></td>
                                    <td class="id-funcionario"><?php echo $exibe['id_funcionario']?></td>
                                    <td><?php echo $exibe['nome']?></td>
                                    <td class="cpf"><?php echo $exibe['cpf']?></td>
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
                                <label class="font-1-s" for="nome">Nome completo <em>*</em></label>
                                <input class="form-control" type="text" name="nome" id="nome" required>
                                <div class="invalid-feedback">
                                    
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="font-1-s" for="cpf">CPF <em>*</em></label>
                                <input class="form-control cpf" type="text" name="cpf" id="cpf" required>
                                <!-- <p id="info-validaCpf"></p> -->
                                <div class="invalid-feedback">
                                
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="font-1-s" for="telefone">Telefone <em>*</em></label>
                                <input class="form-control" type="fone" name="telefone" class="telefone" id="telefone" required>
                                <div class="invalid-feedback">
                                    
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="id_cargo">Cargo <em>*</em></label>
                                <select class="form-select" name="id_cargo" id="id_cargo" aria-label="select example">
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
    include ARQUIVO_FOOTER;
?>

<script src="<?php echo BASE_URL ?>/js/modal.js"></script>

