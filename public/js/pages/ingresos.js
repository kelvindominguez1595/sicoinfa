$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // variables globales
    var categoria = document.querySelector("#categoria").dataset.categorias;
    var marca = document.querySelector("#marca").dataset.marcas;
    var almacen = document.querySelector("#almacen").dataset.almacenes;

    // cargamos los select2 
    $('#categoria').select2({
        theme: "bootstrap-5",
        placeholder: 'Seleccione...',
        allowClear: true,
        ajax: {
            url: '/listarcategorias',
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
            url: '/listarmarcas',
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
    $('#almacen').select2({
        theme: "bootstrap-5",
        placeholder: 'Seleccione...',
        allowClear: true,
        ajax: {
            url: '/listaralmacenes',
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
    // validamos que los data set tenga algun dato para cargar un item en el select2
    if(categoria !== ''){
        $.get('buscarunicacategoria/'+categoria, function (res) {            
            $('#categoria').append('<option value="'+res.CategoriaProductoID+'" selected="selected">'+res.Nombre+'</option>');
        });
    }
    if(marca !== ''){
        $.get('buscarunicamarca/'+marca, function (res) {            
            $('#marca').append('<option value="'+res.MarcaID+'" selected="selected">'+res.Nombre+'</option>');
        });
    }
    if(almacen !== ''){
        $.get('buscarunicoalmacen/'+almacen, function (res) {            
            $('#almacen').append('<option value="'+res.AlmacenID+'" selected="selected">'+res.NombreAlmacen+'</option>');
        });
    }

    $('.imgzoom').popover({
        html: true,
        trigger: 'hover',
        content: function () {
            return '<img src="'+$(this).attr('src') + '" width="150" height="150" />';
        }
    });
});