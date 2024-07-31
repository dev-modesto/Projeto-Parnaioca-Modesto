<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    if(isset($_POST['click-botao-nova-saida-frigobar'])){
        $idReserva = $_POST['id-reserva'];
        $idFrigobar = $_POST['id-frigobar'];
        $idItem = $_POST['id-item'];

        $arrayFrigobar = consultaInfoFrigobar($con, $idFrigobar, 0);
        $nomeFrigobar = $arrayFrigobar['nome_frigobar'];

        $arrayItem = totalItensEspecificoFrigobar($con, $idItem, $idFrigobar);
        $nomeItem = $arrayItem['nome_item'];
        $precoUnit = $arrayItem['preco_unit'];
        $totalItensDiponivel = $arrayItem['total_disponivel'];
    }

?>

    <!-- Modal cadastrar informações -->
    <div class="modal fade" id="modalSaidaItemFrigobar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalSaidaItemFrigobar" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalSaidaItemFrigobar"><?php echo $nomeFrigobar ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- formulario envio -->
                <form class=" form-container form-modal-saida-frigobar" action="gSaidaItemFrigobar.php" method="post" data-id-reserva="<?php echo $idReserva ?>"  data-id-frigobar="<?php echo $idFrigobar ?>" data-id-item="<?php echo $idItem ?>">
                    <div class="row mb-3">
                        
                        <div class="col-md-8">
                            <label class="font-1-s" for="nome-produto">Nome produto</label>
                            <input class="form-control" type="text" name="nome-produto" id="nome-produto-frigobar" value="<?php echo $nomeItem ?>" disabled required>
                        </div>

                        <div class="col-md-4">
                            <label class="font-1-s" for="preco-unit">Valor unit.</label>
                            <input class="form-control monetario preco-unit" type="text" name="preco-unit" id="preco-unit" value="<?php echo $precoUnit ?>" disabled required>
                        </div>
                    </div>

                    <div class="mb-3 container-info-produto-frigobar">
                        <div>
                            <p class="font-1-xs">Qnt. disponível </p>
                            <span class="total-item-estoque font-1-m-b"><?php echo $totalItensDiponivel ?></span>
                        </div>
                    </div>
                
                    <div class="mb-3">
                        <label class="font-1-s" for="quantidade">Quantidade</label>
                        <input class="form-control quantidade numero" type="text" name="quantidade" id="quantidade" value="1" required>
                        <div class="qnt-invalida-frigobar invalid-feedback"></div>
                    </div>

                    <div class="mb-3">
                        <label class="font-1-s" for="valor-total">Valor total</label>
                        <input class="form-control monetario valor-total" type="text" name="valor-total" id="valor-total" value="" disabled required>
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
                        <button class='btn btn-primary btn-salvar-saida-item-frigobar' type="submit">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<script>
    $('.monetario').mask('000.000.000.000.000,00', {reverse: true});
    $('.numero').mask('00000', {reverse: true});

    $(document).ready(function () {

        const precoUnit = $('.preco-unit').val();

        const totalEstoque = $('.total-item-estoque').text();
        const totalEstoqueConvertido = Number(totalEstoque);

        precoUnitFormatado = precoUnit.replace(/\./g, '').replace(',', '.');

        function formatarValor(valor) {
            return parseFloat(valor).toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        $('.valor-total').val(precoUnitFormatado);

        $('.quantidade').keyup(function (e) { 
            
            var quantidadeDigitada = $(this).val();

            if (!isNaN(quantidadeDigitada) && !isNaN(precoUnitFormatado)) {
                var valorTotal = quantidadeDigitada * precoUnitFormatado;
                valorTotal = formatarValor(valorTotal);
                $('.valor-total').val(valorTotal);
            }

            if (quantidadeDigitada > totalEstoqueConvertido ) {
                $('.quantidade').addClass('is-invalid');
                $('.btn-salvar-saida-item-frigobar').attr('disabled', '');
                var mensagem = 'A quantidade informada é superior a quantidade disponível.';
                $('.qnt-invalida-frigobar').text(mensagem);
                
            } else if (quantidadeDigitada == "" || quantidadeDigitada == 0) {
                $('.btn-salvar-saida-item-frigobar').attr('disabled', '');
                $('.quantidade').removeClass('is-invalid');
                $('.quantidade').removeClass('is-valid');

            } else {
                $('.quantidade').addClass('is-valid');
                $('.quantidade').removeClass('is-invalid');
                $('.btn-salvar-saida-item-frigobar').removeAttr('disabled');
            }
        });
        
        $('.btn-salvar-saida-item-frigobar').click(function (e) { 
            e.preventDefault();

            const idReserva = $(this).closest('.form-modal-saida-frigobar').data('id-reserva');
            const idFrigobar = $(this).closest('.form-modal-saida-frigobar').data('id-frigobar');
            const idItem = $(this).closest('.form-modal-saida-frigobar').data('id-item');
            quantidade = $('.quantidade').val();
            quantidadeFormatada = (quantidade);


            $.ajax({
                type: "POST",
                url: "gSaidaItemFrigobar.php",
                data: {
                    'click-btn-saida-frigobar':true,
                    'id-reserva':idReserva,
                    'id-frigobar':idFrigobar,
                    'id-item':idItem,
                    'quantidade':quantidadeFormatada
                },

                success: function (response) {
                    // console.log(response);
 
                    if (response.sucesso) {
                        console.log(response.sucesso);
                        window.location.href = '../index.php?msg=' + encodeURIComponent(response.mensagem);

                    } else {
                        window.location.href = '../index.php?msgInvalida=' + encodeURIComponent(response.mensagem);
                    }

                },
                error: function () {
                    alert("Não foi possível realizar a operação.");
                }
            });
        });
    });

</script>