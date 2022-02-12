
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // esto me sirve para cargar los listado de select2 con paginacion de 10
    $('#categoria').select2({
        theme: "bootstrap-5",
        placeholder: 'Seleccione...',
        allowClear: true,
        ajax: {
            url: '/list_categorias',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    term: params.term || '',
                    page: params.page || 1
                }
            },
            cache: true
        }
    });

    $('#marca').select2({
        theme: "bootstrap-5",
        placeholder: 'Seleccione...',
        allowClear: true,
        ajax: {
            url: '/list_marcas',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    term: params.term || '',
                    page: params.page || 1
                }
            },
            cache: true
        }
    });

    // para obtener el registro buscado
    let categoria = document.querySelector('#categoria').dataset.categoria;
    let marca = document.querySelector('#marca').dataset.marca;

    if(categoria !== ''){
        $.get('categoriasid/'+categoria, function (res) {
            $('#categoria').append('<option value="'+res.id+'" selected="selected">'+res.name+'</option>');
        });
    }
    if(marca !== ''){
        $.get('marcasid/'+marca, function (res) {
            $('#marca').append('<option value="'+res.id+'" selected="selected">'+res.name+'</option>');
        });
    }

    $('.imgzoom').popover({
        html: true,
        trigger: 'hover',
        content: function () {
            return '<img src="'+$(this).attr('src') + '" width="150" height="150" />';
        }
    });

    /// para modificar las cantidades en existencias
    $(document).on('keyup', '.cantidad', function (event) {
        if (event.keyCode === 13) {
            $("#Updated_canti").click();
        }
    });

    $("#Updated_canti").on('click', function () {
        let newFrm = [];
        var idProducto = $("input[name='idProducto[]']");
        for (var i = 0; i < idProducto.length; i++) {
            newFrm.push({ name: 'idProducto[]', value: $(idProducto[i]).val() });
        }
        var update_quantity = $("input[name='update_quantity[]']");
        for (var i = 0; i < update_quantity.length; i++) {
            newFrm.push({ name: 'update_quantity[]', value: $(update_quantity[i]).val() });
        }
        //console.log($.param(newFrm + '<br>'));
        $.ajax({
            data: $.param(newFrm),
            url: "/ajusteproducto",
            type: "POST",
            dataType: 'JSON',
            success: function (data) {
                if (data.detalle_producto) {
                    AlertConfirmacin('Cantidad actualizado correctamente');
                    location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '¡Error algo salio mal!'
                    });
                }

            }
        });
    });
})
