$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // esto me sirve para cargar los listado de select2 con paginacion de 10
  /*  $('#categoria').select2({
        theme: "bootstrap-5",
        placeholder: 'Seleccione...',
        allowClear: true,
        ajax: {
            url: '/list_categoriasempleado',
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
            url: '/list_marcasempleado',
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
    });*/
    // para obtener el registro buscado
   /* let categoria = document.querySelector('#categoria').dataset.categoria;
    let marca = document.querySelector('#marca').dataset.marca;

    if(categoria !== ''){
        $.get('findcategoriesempl/'+categoria, function (res) {
            $('#categoria').append('<option value="'+res.id+'" selected="selected">'+res.name+'</option>');
        });
    }
    if(marca !== ''){
        $.get('marcasidemp/'+marca, function (res) {
            $('#marca').append('<option value="'+res.id+'" selected="selected">'+res.name+'</option>');
        });
    } */

    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    })

    $('.imgzoom').popover({
        html: true,
        trigger: 'hover',
        content: function () {
            return '<img src="'+$(this).attr('src') + '" width="150" height="150" />';
        }
    });


})
