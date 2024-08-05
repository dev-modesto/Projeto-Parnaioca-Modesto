
$(document).ready(function () {
    $('.btn-excluir-item').click(function (e) { 
        e.preventDefault();
        var idItem = $(this).closest('tr').find('.id-item').text()
        var idSku = $(this).closest('tr').find('.id-sku').text()

        $.ajax({
            type: "POST",
            url: "../../../estoque/produto/cadastro/include/eModalExcluirCadastroProduto.php",

            data: {
                'click-btn-excluir-item':true,
                'idItem':idItem,
                'idSku':idSku,
            },
            success: function (response) {
                $('.modalExcluir').html(response)
                $('#modalExcluir').modal('show');
            }
        });
    });
});

$(document).ready(function () {
    $('.btn-editar-item').click(function (e) { 
        e.preventDefault();
        var idItem = $(this).closest('tr').find('.id-item').text()
        var idSku = $(this).closest('tr').find('.id-sku').text()

        $.ajax({
            type: "POST",
            url: "../../../estoque/produto/cadastro/include/cModalEditarCadastroProduto.php",

            data: {
                'click-btn-editar-cadastro-item':true,
                'idItem':idItem,
                'idSku':idSku,
            },
            success: function (response) {
                $('.modalEditarCadastroProduto').html(response)
                $('#modalEditarCadastroProduto').modal('show');
            }
        });
    });
});


// var botaoClick = '.btn-editar-item';
// var classIdTabela = '.id-item';
// var idDataPesquisa = 'id-meu-id';
// var urlCaminho = '../../../estoque/produto/cadastro/include/cModalEditarCadastroProduto.php';
// var classClickTrue = 'click-btn-editar-cadastro-item';
// var classModal = '.modalEditarCadastroProduto';
// var idModal = '#modalEditarCadastroProduto';

function abrirModal(botaoClick, classIdTabela, idDataPesquisa, urlCaminho, classClickTrue, classModal, idModal) {
    $(document).ready(function () {
        $(document).on('click', botaoClick, function (e) {
            e.preventDefault();
            var idPrincipal = $(this).closest(classIdTabela).data(idDataPesquisa);

            $.ajax({
                type: "POST",
                url: urlCaminho,
                data: {
                    [classClickTrue]: true,
                    idPrincipal: idPrincipal,
                },
                success: function (response) {
                    $(classModal).html(response);
                    $(idModal).modal('show');
                }
            });
        });
    });
}


// entrada estoque
abrirModal('.btn-excluir-entrada-item-estoque', 'tr', 'id-entrada-item-estoque', '../../../estoque/produto/entrada/include/eModalExcluirEntradaItemEstoque.php', 'click-btn-excluir-entrada-item-estoque', '.modalExcluir', '#modalExcluir');
abrirModal('.btn-editar-entrada-item-estoque', 'tr', 'id-entrada-item-estoque', '../../../estoque/produto/entrada/include/cModalEditarEntradaProdutoEstoque.php', 'click-btn-editar-entrada-item-estoque', '.modalEditarEntradaItemEstoque', '#modalEditarEntradaItemEstoque');

// cargo
abrirModal('.btn-editar-cargo', 'tr','id-cargo', '../cargo/include/cModalEditarCargo.php', 'click-editar-cargo', '.modalEditarCargo', '#modalEditarCargo');
abrirModal('.btn-excluir-cargo', 'tr', 'id-cargo', '../cargo/include/eModalExcluirCargo.php', 'click-excluir-cargo', '.modalExcluir', '#modalExcluir');

// funcionario
abrirModal('.btn-excluir-funcionario', 'tr', 'id-funcionario', '../funcionario/include/eModalExcluirFuncionario.php', 'click-excluir-funcionario', '.modalExcluir', '#modalExcluir');
abrirModal('.btn-editar-funcionario', 'tr', 'id-funcionario', '../funcionario/include/cModalFuncionario.php', 'click-botao-editar', '.modalEditarFuncionario', '#modalEditarFuncionario');

// setor
abrirModal('.btn-editar-setor', 'tr','id-setor', '../setor/include/cModalEditarSetor.php', 'click-editar-setor', '.modalEditarSetor', '#modalEditarSetor');
abrirModal('.btn-excluir-setor', 'tr', 'id-setor', '../setor/include/eModalExcluirSetor.php', 'click-excluir-setor', '.modalExcluir', '#modalExcluir');

// tipo de acomodacao
abrirModal('.btn-editar-tp-acomodacao', 'tr', 'id-tp-acomodacao', '../tipoAcomodacao/include/cModalEditarTpAcomodacao.php', 'click-editar-tp-acomodacao', '.modalEditarTpAcomodacao', '#modalEditarTpAcomodacao');
abrirModal('.btn-excluir-tp-acomodacao', 'tr', 'id-tp-acomodacao', '../tipoAcomodacao/include/eModalExcluirTpAcomodacao.php', 'click-excluir-tp-acomodacao', '.modalExcluir', '#modalExcluir');

// status geral
abrirModal('.btn-excluir-status-geral', 'tr', 'id-status-geral', '../statusGeral/include/eModalExcluirStatusGeral.php', 'click-excluir-status-geral', '.modalExcluir', '#modalExcluir');
abrirModal('.btn-editar-status-geral', 'tr', 'id-status-geral', '../statusGeral/include/cModalEditarStatusGeral.php', 'click-editar-status-geral', '.modalEditarStatusGeral', '#modalEditarStatusGeral');

// acomodacao
abrirModal('.btn-editar-acomodacao', 'tr', 'id-acomodacao', '../acomodacao/include/cModalEditarAcomodacao.php', 'click-editar-acomodacao', '.modalEditarAcomodacao', '#modalEditarAcomodacao');
abrirModal('.btn-excluir-acomodacao', 'tr', 'id-acomodacao', '../acomodacao/include/eModalExcluirAcomodacao.php', 'click-excluir-acomodacao', '.modalExcluir', '#modalExcluir');

// vaga estacionamento
abrirModal('.btn-excluir-vaga-estacionamento', 'tr', 'id-vaga-estacionamento', '../estacionamento/include/eModalExcluirVagaEstacionamento.php', 'click-excluir-vaga-estacionamento', '.modalExcluir', '#modalExcluir');
abrirModal('.btn-editar-vaga-estacionamento', 'tr', 'id-vaga-estacionamento', '../estacionamento/include/cModalEditarVagaEstacionamento.php', 'click-editar-vaga-estacionamento', '.modalEditarVagaEstacionamento', '#modalEditarVagaEstacionamento');

// frigobar
abrirModal('.btn-excluir-frigobar', 'tr', 'id-frigobar', '../frigobar/include/eModalExcluirFrigobar.php', 'click-excluir-frigobar', '.modalExcluir', '#modalExcluir');
abrirModal('.btn-editar-frigobar', 'tr', 'id-frigobar', '../frigobar/include/cModalEditarFrigobar.php', 'click-editar-frigobar', '.modalEditarFrigobar', '#modalEditarFrigobar');

// cliente
abrirModal('.btn-excluir-cliente', 'tr', 'id-cliente', '../cliente/include/eModalExcluirCliente.php', 'click-excluir-cliente', '.modalExcluir', '#modalExcluir');
abrirModal('.btn-editar-cliente', 'tr', 'id-cliente', '../cliente/include/cModalEditarCliente.php', 'click-editar-cliente', '.modalEditarCliente', '#modalEditarCliente');
abrirModal('.btn-visualizar-info-cliente', 'tr', 'id-cliente', '../cliente/include/cModalVisualizarInfoCliente.php', 'click-visualizar-info-cliente', '.modalVisualizarInfoCliente', '#modalVisualizarInfoCliente');

// acesso area
abrirModal('.btn-editar-acesso-area', 'tr', 'id-funcionario', '../acessoArea/include/cModalEditarAcessoArea.php', 'click-editar-acesso-area', '.modalEditarAcessoArea', '#modalEditarAcessoArea');


