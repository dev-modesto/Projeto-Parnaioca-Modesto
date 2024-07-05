$(document).ready(function () {
    $('.btn-editar-funcionario').click(function() { //definir função click a minha classe do botao de editar
        var idFuncionario = $(this).closest('tr').find('.id-funcionario').text();//pegando a informação desejada do botao
        // console.log(idFuncionario);
        
        $.ajax({
            type: "POST",
            url: "../funcionario/include/cModalFuncionario.php",
            
            data: {
                'click-botao-editar':true,
                'idFuncionario':idFuncionario,
            },
            success: function (response) {
                // console.log(response);

                $('.modalEditarFuncionario').html(response);
                $('#modalEditarFuncionario').modal('show');
            }
        });
    });
});


$(document).ready(function () {
    $('.btn-editar-setor').click(function (e) { 
        e.preventDefault();
        var idSetor = $(this).closest('tr').find('.id-setor').text()
        // console.log('Numero do setor: ' + idSetor);

        $.ajax({
            type: "POST",
            url: "../setor/include/cModalEditarSetor.php",

            data: {
                'click-editar-setor':true,
                'idSetor':idSetor,
            },
            success: function (response) {
                // console.log('Response: ' + response);
                $('.modalEditarSetor').html(response)
                $('#modalEditarSetor').modal('show');
            }
        });
        
    });
});

$(document).ready(function () {
    $('.btn-editar-cargo').click(function (e) { 
        e.preventDefault();
        var idCargo = $(this).closest('tr').find('.id-cargo').text()
        // console.log('Numero do setor: ' + idCargo);

        $.ajax({
            type: "POST",
            url: "../cargo/include/cModalEditarCargo.php",

            data: {
                'click-editar-cargo':true,
                'idCargo':idCargo,
            },
            success: function (response) {
                // console.log('Response: ' + response);
                $('.modalEditarCargo').html(response)
                $('#modalEditarCargo').modal('show');
            }
        });
        
    });
});

$(document).ready(function () {
    $('.btn-excluir-cargo').click(function (e) { 
        e.preventDefault();
        var idCargo = $(this).closest('tr').find('.id-cargo').text()
        // console.log('Numero do setor: ' + idCargo);

        $.ajax({
            type: "POST",
            url: "../cargo/include/eModalExcluirCargo.php",

            data: {
                'click-excluir-cargo':true,
                'idCargo':idCargo,
            },
            success: function (response) {
                // console.log('Response: ' + response);
                $('.modalExcluir').html(response)
                $('#modalExcluir').modal('show');
            }
        });
        
    });
});

$(document).ready(function () {
    $('.btn-excluir-funcionario').click(function (e) { 
        e.preventDefault();
        var idFuncionario = $(this).closest('tr').find('.id-funcionario').text()
        // console.log('Numero do funcionario: ' + idFuncionario);

        $.ajax({
            type: "POST",
            url: "../funcionario/include/eModalExcluirFuncionario.php",

            data: {
                'click-excluir-funcionario':true,
                'idFuncionario':idFuncionario,
            },
            success: function (response) {
                console.log('Response: ' + response);
                $('.modalExcluir').html(response)
                $('#modalExcluir').modal('show');
            }
        });
        
    });
});

$(document).ready(function () {
    $('.btn-excluir-setor').click(function (e) { 
        e.preventDefault();
        var idSetor = $(this).closest('tr').find('.id-setor').text()
        // console.log('Numero do setor: ' + idSetor);

        $.ajax({
            type: "POST",
            url: "../setor/include/eModalExcluirSetor.php",

            data: {
                'click-excluir-setor':true,
                'idSetor':idSetor,
            },
            success: function (response) {
                console.log('Response: ' + response);
                $('.modalExcluir').html(response)
                $('#modalExcluir').modal('show');
            }
        });
        
    });
});

$(document).ready(function () {
    $('.btn-editar-tp-acomodacao').click(function (e) { 
        e.preventDefault();
        var idTpAomocadao = $(this).closest('tr').find('.id-tp-acomodacao').text()
        // console.log('Numero do tipo de acomodação: ' + idTpAomocadao);

        $.ajax({
            type: "POST",
            url: "../tipoAcomodacao/include/cModalEditarTpAcomodacao.php",

            data: {
                'click-editar-tp-acomodacao':true,
                'idTpAomocadao':idTpAomocadao,
            },
            success: function (response) {
                console.log('Response: ' + response);
                $('.modalEditarTpAcomodacao').html(response)
                $('#modalEditarTpAcomodacao').modal('show');
            }
        });
        
    });
});

$(document).ready(function () {
    $('.btn-excluir-tp-acomodacao').click(function (e) { 
        e.preventDefault();
        var idTpAomocadao = $(this).closest('tr').find('.id-tp-acomodacao').text()
        // console.log('Numero do tipo de acomodação: ' + idTpAomocadao);

        $.ajax({
            type: "POST",
            url: "../tipoAcomodacao/include/eModalExcluirTpAcomodacao.php",

            data: {
                'click-excluir-tp-acomodacao':true,
                'idTpAomocadao':idTpAomocadao,
            },
            success: function (response) {
                console.log('Response: ' + response);
                $('.modalExcluir').html(response)
                $('#modalExcluir').modal('show');
            }
        });
        
    });
});


$(document).ready(function () {
    $('.btn-editar-status-geral').click(function (e) { 
        e.preventDefault();
        var idStatusGeral = $(this).closest('tr').find('.id-status').text()
        // console.log('Status: ' + idStatusGeral);

        $.ajax({
            type: "POST",
            url: "../statusGeral/include/cModalEditarStatusGeral.php",

            data: {
                'click-editar-status-geral':true,
                'idStatusGeral':idStatusGeral,
            },
            success: function (response) {
                console.log('Response: ' + response);
                $('.modalEditarStatusGeral').html(response)
                $('#modalEditarStatusGeral').modal('show');
            }
        });
        
    });
});

$(document).ready(function () {
    $('.btn-excluir-status-geral').click(function (e) { 
        e.preventDefault();
        var idStatusGeral = $(this).closest('tr').find('.id-status').text()
        // console.log('Status: ' + idStatusGeral);

        $.ajax({
            type: "POST",
            url: "../statusGeral/include/eModalExcluirStatusGeral.php",

            data: {
                'click-excluir-status-geral':true,
                'idStatusGeral':idStatusGeral,
            },
            success: function (response) {
                console.log('Response: ' + response);
                $('.modalExcluir').html(response)
                $('#modalExcluir').modal('show');
            }
        });
        
    });
});

$(document).ready(function () {
    $('.btn-excluir-acomodacao').click(function (e) { 
        e.preventDefault();
        var idAcomodacao = $(this).closest('tr').find('.id-acomodacao').text()
        // console.log('id acomodacao: ' + idAcomodacao);

        $.ajax({
            type: "POST",
            url: "../acomodacao/include/eModalExcluirAcomodacao.php",

            data: {
                'click-excluir-acomodacao':true,
                'idAcomodacao':idAcomodacao,
            },
            success: function (response) {
                // console.log('Response: ' + response);
                $('.modalExcluir').html(response)
                $('#modalExcluir').modal('show');
            }
        });
    });
});

$(document).ready(function () {
    $('.btn-editar-acomodacao').click(function (e) { 
        e.preventDefault();
        var idAcomodacao = $(this).closest('tr').find('.id-acomodacao').text()
        console.log('id acomodacao: ' + idAcomodacao);

        $.ajax({
            type: "POST",
            url: "../acomodacao/include/cModalEditarAcomodacao.php",

            data: {
                'click-editar-acomodacao':true,
                'idAcomodacao':idAcomodacao,
            },
            success: function (response) {
                // console.log('Response: ' + response);
                $('.modalEditarAcomodacao').html(response)
                $('#modalEditarAcomodacao').modal('show');
            }
        });
    });
});

$(document).ready(function () {
    $('.btn-excluir-vaga-estacionamento').click(function (e) { 
        e.preventDefault();
        var idVagaEstacionamento = $(this).closest('tr').find('.id-vaga-estacionamento').text()
        // console.log('id vaga: ' + idVagaEstacionamento);

        $.ajax({
            type: "POST",
            url: "../estacionamento/include/eModalExcluirVagaEstacionamento.php",

            data: {
                'click-excluir-vaga-estacionamento':true,
                'idVagaEstacionamento':idVagaEstacionamento,
            },
            success: function (response) {
                // console.log('Response: ' + response);
                $('.modalExcluir').html(response)
                $('#modalExcluir').modal('show');
            }
        });
    });
});

$(document).ready(function () {
    $('.btn-editar-vaga-estacionamento').click(function (e) { 
        e.preventDefault();
        var idVagaEstacionamento = $(this).closest('tr').find('.id-vaga-estacionamento').text()
        // console.log('id vaga: ' + idVagaEstacionamento);

        $.ajax({
            type: "POST",
            url: "../estacionamento/include/cModalEditarVagaEstacionamento.php",

            data: {
                'click-editar-vaga-estacionamento':true,
                'idVagaEstacionamento':idVagaEstacionamento,
            },
            success: function (response) {
                // console.log('Response: ' + response);
                $('.modalEditarVagaEstacionamento').html(response)
                $('#modalEditarVagaEstacionamento').modal('show');
            }
        });
    });
});


$(document).ready(function () {
    $('.btn-excluir-frigobar').click(function (e) { 
        e.preventDefault();
        var idFrigobar = $(this).closest('tr').find('.id-frigobar').text()
        console.log('id frigobar: ' + idFrigobar);

        $.ajax({
            type: "POST",
            url: "../frigobar/include/eModalExcluirFrigobar.php",

            data: {
                'click-excluir-frigobar':true,
                'idFrigobar':idFrigobar,
            },
            success: function (response) {
                // console.log('Response: ' + response);
                $('.modalExcluir').html(response)
                $('#modalExcluir').modal('show');
            }
        });
    });
});

$(document).ready(function () {
    $('.btn-editar-frigobar').click(function (e) { 
        e.preventDefault();
        var idFrigobar = $(this).closest('tr').find('.id-frigobar').text()
        // console.log('id frigobar: ' + idFrigobar);

        $.ajax({
            type: "POST",
            url: "../frigobar/include/cModalEditarFrigobar.php",

            data: {
                'click-editar-frigobar':true,
                'idFrigobar':idFrigobar,
            },
            success: function (response) {
                // console.log('Response: ' + response);
                $('.modalEditarFrigobar').html(response)
                $('#modalEditarFrigobar').modal('show');
            }
        });
    });
});

$(document).ready(function () {
    $('.btn-excluir-cliente').click(function (e) { 
        e.preventDefault();
        var idCliente = $(this).closest('tr').find('.id-cliente').text()
        // console.log('id cliente: ' + idCliente);

        $.ajax({
            type: "POST",
            url: "../cliente/include/eModalExcluirCliente.php",

            data: {
                'click-excluir-cliente':true,
                'idCliente':idCliente,
            },
            success: function (response) {
                // console.log('Response: ' + response);
                $('.modalExcluir').html(response)
                $('#modalExcluir').modal('show');
            }
        });
    });
});
