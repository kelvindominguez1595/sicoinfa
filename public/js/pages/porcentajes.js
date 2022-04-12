$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#tiporeporte").change(function(){
        let data = $(this).val();
        let contentcategoria = $('#contentcategoria');
        let contentmarcar = $('#contentmarcar');
        if(data === 'marca') {
            contentmarcar.removeClass('d-none');
            contentcategoria.addClass('d-none');
        } else if(data === 'categoria') {
            contentcategoria.removeClass('d-none');
            contentmarcar.addClass('d-none');
        } else {
            contentcategoria.addClass('d-none');
            contentmarcar.addClass('d-none');
        }
    });

    // cargamos los select2
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

});
