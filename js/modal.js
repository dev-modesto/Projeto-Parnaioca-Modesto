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
