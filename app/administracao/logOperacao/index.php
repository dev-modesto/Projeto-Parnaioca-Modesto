<?php
    $setorPagina = "Administração";
    $pagina = "Logs de Operações";
    $grupoPagina = "Logs geral";
    $tituloMenuPagina = "Administração";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    include PASTA_FUNCOES . "funcaoData.php";

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaAdm($con, $idLogado);
    }
    
    $sql = 
        "SELECT
            l.id_log_op, 
            l.id_funcionario,
            f.nome,
            l.nome_tbl, 
            l.id_registro, 
            l.tp_operacao, 
            l.descricao, 
            l.dt_ocorrencia 
        FROM tbl_log_operacao l
        INNER JOIN tbl_funcionario f
        ON l.id_funcionario = f.id_funcionario
    ";

    $consulta = mysqli_query($con, $sql);

?>
    
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração | Log de Operações</title>
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

                <table id="myTable" class="table nowrap order-column table-hover text-left">
                    <thead class="">
                        <tr>
                            <!-- <th scope="col">Nº</th> -->
                            <th scope="col">#ID log</th>
                            <th scope="col">ID funcionario</th>
                            <th scope="col">Nome funcionário</th>
                            <th scope="col">Tabela</th>
                            <th scope="col">ID registro tabela</th>
                            <th scope="col">Tipo operação</th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Data ocorrência</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <?php 
                            $nroLinha = 1;
                            while($exibe = mysqli_fetch_array($consulta)){
                                    $id = $exibe['id_log_op'];
                                    $dtOcorrencia = $exibe['dt_ocorrencia'];
                                    $dtOcorrenciaFormatada = dataHoraFormatada($dtOcorrencia);
                                ?>
                                <tr>
                                    <!-- <td class="numero-linha"><?php echo $nroLinha++; ?></td> -->
                                    <td class="id"><?php echo $exibe['id_log_op']?></td>
                                    <td><?php echo $exibe['id_funcionario']?></td>
                                    <td><?php echo $exibe['nome']?></td>
                                    <td><?php echo $exibe['nome_tbl']?></td>
                                    <td><?php echo $exibe['id_registro']?></td>
                                    <td class="legenda"><span class="legenda-tp-operacao"><?php echo $exibe['tp_operacao']?></span></td>
                                    <td><?php echo $exibe['descricao']?></td>
                                    <td><?php echo $dtOcorrenciaFormatada ?></td>
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
    include ARQUIVO_FOOTER;
?>

<script src="<?php echo BASE_URL ?>/js/modal.js"></script>


<script>

    var legendaTpOperacao = document.querySelectorAll('.legenda-tp-operacao').forEach(function (element){
        switch (element.textContent) {
            case 'insercao':
                element.innerHTML = 'Inserção';
                element.classList.add('insercao');
                break;
            case 'atualizacao':
                element.innerHTML = 'Atualização';
                element.classList.add('atualizacao');
                break;
            default:
                element.innerHTML = 'Exclusão';
                element.classList.add('exclusao');
                break;
        }
    })

</script>