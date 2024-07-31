<?php
    ob_start();
    $setorPagina = "SAC";
    $pagina = "Reservas";
    $grupoPagina = "";
    $tituloMenuPagina = "Reservas";

    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/base.php';

    if (session_status() == PHP_SESSION_ACTIVE) {
        $idLogado = $_SESSION['id'];
        segurancaSac($con, $idLogado);
    }
    include ARQUIVO_FUNCAO_SQL;
    include ARQUIVO_FUNCAO_SQL_RESERVA;

    if(isset($_GET['click-consumir-itens-frigobar']) && $_GET['click-consumir-itens-frigobar'] === 'true') {
        $idReserva = $_GET['id-reserva'];

        $sqlReserva = mysqli_prepare($con, "SELECT * FROM tbl_reserva WHERE id_reserva = ?");
        mysqli_stmt_bind_param($sqlReserva, "i", $idReserva);
        mysqli_stmt_execute($sqlReserva);
        $resultado = mysqli_stmt_get_result($sqlReserva);

        if($array = mysqli_fetch_assoc($resultado)) {

            $idAcomodacao = $array['id_acomodacao'];
            $valorAcomodacao = $array['valor'];
            $idCliente = $array['id_cliente'];

            $consulta = consultaInfoAcomodacao($con, 0, $idAcomodacao);
            $arrayAcomodacao = mysqli_fetch_assoc($consulta);

            $numeroAcomodacao = $arrayAcomodacao['numero_acomodacao'];
            $nomeAcomodacao = $arrayAcomodacao['nome_acomodacao'];

            $consultaInfoCliente = consultaInfoCliente($con, $idCliente, 0);

            $nomeCliente = $consultaInfoCliente['nome'];
            $cpfCliente = $consultaInfoCliente['cpf'];
            $telefoneCliente = $consultaInfoCliente['telefone'];

            $arrayFrigobar = consultaInfoFrigobar($con, 0, $idAcomodacao);
            $nomeFrigobar = $arrayFrigobar['nome_frigobar'];
            $idFrigobar = $arrayFrigobar['id_frigobar'];

            $totalItensFrigobar = totalItensFrigobar($con, $idFrigobar);

        }   
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas</title>
    <!-- link bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- meu css -->
    <link rel="stylesheet" href="../../../css/style.css"> <!--- precisa colocar a constante -->
    <!-- meus icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,1,0" />

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@1,900&family=Poppins:wght@200;300;400;500;600;700&family=Roboto:wght@200;300;400;500&display=swap" rel="stylesheet">
    
    <!-- link css datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />
</head>
<body>

    <div class="conteudo">
        <div class="container-conteudo-principal">

            <div class="form-container frigobar cabecalho">
                <div class="container-cabecalho-padrao">
                    <h1 class="modal-title fs-5 cor-8 peso-semi-bold" id="staticBackdropLabel"><?php echo $nomeAcomodacao ?> - <?php echo $numeroAcomodacao ?> </h1>
                    <span class="cor-6"><?php echo $nomeFrigobar ?> </span>
                </div>
            </div>
            
            <!-- formulario envio -->
            <form class="was-validated form-container reservas-informacao">
                <div class="form-container container-cards-produto-frigobar">
                    <div class="cabecalho-container-conteudo-form">
                        <h1 class="font-1-m">Total de itens no frigobar: <?php echo $totalItensFrigobar ?></h1>
                    </div>

                    <div class="cards-produto-frigobar">
                        <?php 
                            $sql = 
                                "SELECT 
                                    i.id_item,
                                    i.nome_item,
                                    i.preco_unit,
                                    COALESCE(e.total_entrada, 0) AS total_entrada,
                                    COALESCE(s.total_saida, 0) AS total_saida,
                                    (COALESCE(e.total_entrada, 0) - COALESCE(s.total_saida, 0)) AS total_disponivel

                                FROM (
                                    SELECT 
                                        id_item,
                                        id_frigobar,
                                        SUM(quantidade) AS total_entrada
                                    FROM tbl_entrada_item_frigobar
                                    WHERE id_frigobar = '$idFrigobar'
                                    GROUP BY id_item, id_frigobar
                                ) AS e
                                
                                LEFT JOIN (
                                    SELECT 
                                        id_item,
                                        id_frigobar,
                                        SUM(quantidade) AS total_saida
                                    FROM tbl_consumo_item_frigobar
                                    WHERE id_frigobar = '$idFrigobar'
                                    GROUP BY id_item, id_frigobar
                                ) AS s 

                                ON e.id_item = s.id_item AND e.id_frigobar = s.id_frigobar
                                INNER JOIN tbl_item i 
                                ON e.id_item = i.id_item
                                WHERE e.id_frigobar = $idFrigobar
                                HAVING total_disponivel > 0
                            ";
  
                            $consultaFrigobar = mysqli_query($con, $sql);

                            while($arrayProduto = mysqli_fetch_assoc($consultaFrigobar)) {
                                $idItem = $arrayProduto['id_item'];
                                $nomeItem = $arrayProduto['nome_item'];
                                $precoUnit = $arrayProduto['preco_unit'];
                                $totalDisponivel = $arrayProduto['total_disponivel'];
                                
                                ?>  
                                    
                                    <div class="card card-produto-frigobar" style="width: 15rem; min-height: 19rem; border: none" data-id-reserva="<?php echo $idReserva ?>" data-id-frigobar="<?php echo $idFrigobar ?>" data-id-item="<?php echo $idItem?>">
                                        <a class="card-body card-produto-frigobar-body">
                                            <div class="card-produto-frigobar-cabecalho">
                                                <p class="cor-6 font-1-xs">Qnt: <?php echo $totalDisponivel ?></p>
                                            </div>
                                            <div class="card-produto-frigobar-img">
                                                <p class="font-1-xl cor-3">IMG</p>
                                            </div>
                                            <div class="card-produto-frigobar-footer">
                                                <p class="font-2-xs-2 peso-medio"><?php echo $nomeItem ?></p>
                                                <p class="font-1-xs cor-6">R$ <span class="font-1-xs monetario"><?php echo $precoUnit ?></span></p>
                                                
                                            </div>
                                        </a>
                                        <a class="card-frigobar-btn click-botao-nova-saida-frigobar">Nova saída</a>
                                    </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            
                <br>

                <div class="modalConfirmaCheckIn">
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
            </form>

            <div class="modalSaidaItemFrigobar">
            </div>
        </div>
    </div>

<?php
    include ARQUIVO_FOOTER;
    ob_end_flush();
?>

<script src="<?php echo BASE_URL ?>/js/modal.js"></script>
<script src="<?php echo BASE_URL ?>/js/table.js"></script>

<script>
    $('.cpf').mask('000.000.000-00', {reverse: true});
</script>


<script>
    $(document).ready(function () {
            
        $(".click-botao-nova-saida-frigobar").click(function (e) { 
            e.preventDefault();

            var idFrigobar = $(this).closest('.card-produto-frigobar').data('id-frigobar');
            var idItem = $(this).closest('.card-produto-frigobar').data('id-item');
            var idReserva = $(this).closest('.card-produto-frigobar').data('id-reserva');

            $.ajax({
                type: "POST",
                url: "cModalSaidaItemFrigobar.php",
                data: {
                    'click-botao-nova-saida-frigobar':true,
                    'id-frigobar':idFrigobar,
                    'id-item':idItem,
                    'id-reserva':idReserva
                },  
                success: function (response) {
                    console.log(response);
                    $('.modalSaidaItemFrigobar').html(response)
                    $('#modalSaidaItemFrigobar').modal('show');
                }
            });
        });
    });
</script>