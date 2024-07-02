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
