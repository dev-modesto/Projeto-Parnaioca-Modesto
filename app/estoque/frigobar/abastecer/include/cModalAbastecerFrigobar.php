<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/Projeto-Parnaioca-Modesto/config/config.php';
    include ARQUIVO_CONEXAO;
    include ARQUIVO_FUNCAO_SQL;

    if(isset($_POST['click-botao-abastecer-frigobar'])){

        $idFrigobar = $_POST['id-frigobar'];
        $idAcomodacao = $_POST['id-acomodacao'];

        $sqlInner = 
                mysqli_prepare(
                $con, 
                "SELECT 
                    f.id_frigobar, 
                    f.nome_frigobar, 
                    f.id_acomodacao, 
                    a.numero_acomodacao, 
                    a.nome_acomodacao, 
                    f.capacidade_itens
                FROM tbl_frigobar f
                INNER JOIN tbl_acomodacao a
                ON f.id_acomodacao = a.id_acomodacao WHERE id_frigobar = ? "
        );

        mysqli_stmt_bind_param($sqlInner, 'i', $idFrigobar);
        $consulta = mysqli_stmt_execute($sqlInner);
        $result = mysqli_stmt_get_result($sqlInner);
        $array = mysqli_fetch_assoc($result);
        $capacidadeItens = $array['capacidade_itens'];

    }

?>

    <!-- Modal cadastrar informações -->
    <div class="modal fade" id="modalAbastecerFrigobar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAbastecerFrigobar" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
   
                
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalAbastecerFrigobar"><?php echo $array['nome_frigobar']?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- formulario envio -->
                <form class="was-validated form-container" action="include/gAbastecerFrigobar.php" method="post">
                    <input class="form-control" type="text" name="id-frigobar" id="id-frigobar" value="<?php echo $idFrigobar?>" hidden required >
                    <input class="form-control" type="text" name="id-acomodacao" id="id-acomodacao" value="<?php echo $idAcomodacao?>" hidden  required >
                    <input class="form-control" type="text" name="capacidade-itens" id="capacidade-itens" value="<?php echo $capacidadeItens?>" hidden required >
                    <input class="form-control" type="text" name="id-item-frigobar" id="id-item-frigobar" value="" hidden required >
                    <div class="mb-3">
                        <label class="font-1-s" for="sku">SKU do produto</label>
                        <input class="form-control input-sku-produto" type="text" name="sku" id="sku" required>
                    </div>

                    <div class="mb-3">
                        <label class="font-1-s" for="nome-produto">Nome produto</label>
                        <input class="form-control" type="text" name="nome-produto" id="nome-produto-frigobar" readonly required>
                    </div>

                    <div class="mb-3">
                        <p class="font-1-xs">estoque disponível: <span class="total-item-estoque font-1-xs"></span></p>
                    </div>

                    <div class="mb-3">
                        <label class="font-1-s" for="quantidade">Quantidade</label>
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

<script>
        $(document).ready(function () {

            $(".input-sku-produto").keyup(function (e) { 
                e.preventDefault();

                var idSku = $(this).val();
                console.log(idSku);

                $.ajax({
                    type: "POST",
                    url: "include/cPesquisaEntradaProdutoEstoque.php",
                    data: {
                        'id-sku':idSku
                    },

                    success: function (response) {
                        if (response !== "") {
                            // console.log(response);
                            $('#id-item-frigobar').val(response.idItem);
                            $('#nome-produto-frigobar').val(response.nomeItem);
                            $('#total-estoque-item').val(response.totalEstoqueItem);

                            var totalEstoque = response.totalEstoqueItem;

                            var textoEstoque = document.querySelectorAll('.total-item-estoque').forEach( function (element) {
                                console.log(element.textContent);
                                element.innerHTML = totalEstoque;
                            });

                        } else {
                            $('#id-item-frigobar').val('');
                            $('#nome-produto-frigobar').val('');
                            $('#total-estoque-item').val('');

                            var textoEstoque = document.querySelectorAll('.total-item-estoque').forEach( function (element) {
                                console.log(element.textContent);
                                element.innerHTML = '';
                            });
                        }
                    },
                });
            });

        });
</script>