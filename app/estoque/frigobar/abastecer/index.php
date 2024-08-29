<?php
    $setorPagina = "Logística";
    $pagina = "Abastecer frigobar";
    $grupoPagina = "Frigobar";
    $tituloMenuPagina = "Estoque | Frigobar";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';
    include ARQUIVO_FUNCAO_SQL;
    include BASE_PATH . '/include/funcoes/diversas/mensagem.php';

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaLogistica($con, $idLogado);
    }

    $sqlInner = 
                "SELECT f.id_frigobar, f.nome_frigobar, f.id_acomodacao, a.numero_acomodacao, a.nome_acomodacao, f.capacidade_itens
                FROM tbl_frigobar f
                INNER JOIN tbl_acomodacao a
                ON f.id_acomodacao = a.id_acomodacao 
                ORDER BY id_frigobar"
    ;
    $consulta = mysqli_query($con, $sqlInner);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frigobar | Abastecer frigobar</title>
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

    <div class="conteudo">
        <div class="container-conteudo-principal">

            <?php
                msgGetValida();
                msgGetInvalida();
            ?>

            <span class="separador"></span>

            <section class="container-cards-frigobar">
                
                <?php

                    while($array = mysqli_fetch_assoc($consulta)) {
                        // echo "<pre>";
                        // print_r($array);
                        $idFrigobar = $array['id_frigobar'];
                        $nomeFrigobar = $array['nome_frigobar'];
                        $idAcomodacao = $array['id_acomodacao'];
                        $numeroAcomodacao = $array['numero_acomodacao'];
                        $nomeAcomodacao = $array['nome_acomodacao'];
                        $capacidadeItens = $array['capacidade_itens'];
                        $totalItensFrigobar = totalItensFrigobar($con, $idFrigobar);

                        ?>
                            <div class="card card-frigobar" style="width: 15rem; min-height: 18rem; border: none" data-id-frigobar="<?php echo $idFrigobar ?>" data-id-acomodacao="<?php echo $idAcomodacao?>">
                                <a href="" class="card-body card-frigobar-body">
                                    <div class="card-frigobar-cabecalho">
                                        <span class="material-symbols-rounded">kitchen</span>
                                        <p class="cor-6 font-1-xs"><?php echo $nomeFrigobar ?></p>
                                    </div>
                                    <div class="card-frigobar-acomodacao">
                                        <p class="card-title font-1-m-b cor-7"><?php echo $nomeAcomodacao ?></p>
                                        <p class="font-1-xl cor-7"><?php echo $numeroAcomodacao ?></p>
                                    </div>
                                    <div class="card-frigobar-armazenamento">
                                        <p class="cor-6 font-1-xs">Armazenamento</p>
                                        <p class="cor-7"><?php echo $totalItensFrigobar ?>/<?php echo $capacidadeItens ?></p>
                                    </div>
                                </a>
                                <a href="" class="card-frigobar-btn click-botao-abastecer-frigobar">Abastecer</a>
                                <!-- <a href="" class="card-frigobar-btn click-botao-abastecer-frigobar" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Abastecer</a> -->
                            </div>
        
                        <?php
                    }

                ?>
            </section>

            <!-- Modal cadastrar informações -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Abastecer Frigobar</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <!-- formulario envio -->
                        <form class="was-validated form-container" action="include/gAbastecerFrigobar.php" method="post">
                            <div class="mb-3">
                                <label class="font-1-s" for="sku">SKU do produto <em>*</em></label>
                                <input class="form-control" type="text" name="sku" id="sku" required>
                            </div>

                            <div class="mb-3">
                                <label class="font-1-s" for="nome-produto">Nome produto</label>
                                <input class="form-control" type="text" name="nome-produto" id="nome-produto" readonly required>
                            </div>

                            <div class="mb-3">
                                <label class="font-1-s" for="quantidade">Quantidade <em>*</em></label>
                                <input class="form-control" type="text" name="quantidade" id="quantidade" required>
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

            <div class="modalAbastecerFrigobar">
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

    $(document).ready(function () {
        
        $(".click-botao-abastecer-frigobar").click(function (e) { 
            e.preventDefault();
            var idFrigobar = $(this).closest('.card-frigobar').data('id-frigobar');
            var idAcomodacao = $(this).closest('.card-frigobar').data('id-acomodacao');

            $.ajax({
                type: "POST",
                url: "include/cModalAbastecerFrigobar.php",
                data: {
                    'click-botao-abastecer-frigobar':true,
                    'id-frigobar':idFrigobar,
                    'id-acomodacao':idAcomodacao,
                },  
                success: function (response) {
                    $('.modalAbastecerFrigobar').html(response)
                    $('#modalAbastecerFrigobar').modal('show');
                }
            });
        });
    });


</script>
