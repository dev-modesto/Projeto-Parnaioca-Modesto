$(document).ready(function () {
    $('.editar-funcionario').click(function() { //definir função click a minha classe do botao de editar
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
