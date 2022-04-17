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

    // type report
    $('.type_report').change(function (){
        let type = $(this).val();
        if(type === 'PRECIO DE VENTAS') {
            $('#CODIGO').attr('checked', true);
            $('#CODIGODEBARRA').attr('checked', true);
            $('#CATEGORIA').attr('checked', true);
            $('#MARCA').attr('checked', true);
            $('#NOMBRE').attr('checked', true);
            $('#UNIDADDEMEDIDA').attr('checked', true);
            $('#CANTIDAD').attr('checked', true);
            $('#PRECIODEVENTA').attr('checked', true);
            $('#VENTATOTAL').attr('checked', true);
            // false
            $('#COSTOSIVA').attr('checked', false);
            $('#TOTALCOMPRACIVA').attr('checked', false);
            $('#FECHA').attr('checked', false);
            $('#TOTALEXISTENCIASIVA').attr('checked', false);
            $('#PORCENTAJE').attr('checked', false);
            // $('#GANANCIAUNITARIA').attr('checked', false);
            $('#TOTALEXISTENCIACIVA').attr('checked', false);
            $('#COSTOCIVA').attr('checked', false);
            $('#UTILIDADTOTAL').attr('checked', false);
            $('#TOTALCOMPRASIVA').attr('checked', false);
            $('#TOTALCOSTOS').attr('checked', false);
            $('#DIFERENCIAUNITARIA').attr('checked', false);
        } else if(type === 'COSTOS SIN IVA') {
            $('#CODIGO').attr('checked', true);
            $('#CODIGODEBARRA').attr('checked', true);
            $('#CATEGORIA').attr('checked', true);
            $('#MARCA').attr('checked', true);
            $('#NOMBRE').attr('checked', true);
            $('#UNIDADDEMEDIDA').attr('checked', true);
            $('#CANTIDAD').attr('checked', true);
            $('#COSTOSIVA').attr('checked', true);
            $('#TOTALCOSTOS').attr('checked', true);

            // false
            $('#VENTATOTAL').attr('checked', false);
            $('#PRECIODEVENTA').attr('checked', false);
            $('#TOTALCOMPRACIVA').attr('checked', false);
            $('#FECHA').attr('checked', false);
            $('#TOTALEXISTENCIASIVA').attr('checked', false);
            $('#PORCENTAJE').attr('checked', false);
            // $('#GANANCIAUNITARIA').attr('checked', false);
            $('#TOTALEXISTENCIACIVA').attr('checked', false);
            $('#COSTOCIVA').attr('checked', false);
            $('#UTILIDADTOTAL').attr('checked', false);
            $('#TOTALCOMPRASIVA').attr('checked', false);
            $('#DIFERENCIAUNITARIA').attr('checked', false);
        } else if(type === 'COSTOS Y PORCENTAJES DE UTILIDAD') {
            $('#CODIGO').attr('checked', true);
            $('#CODIGODEBARRA').attr('checked', true);
            $('#CATEGORIA').attr('checked', true);
            $('#MARCA').attr('checked', true);
            $('#NOMBRE').attr('checked', true);
            $('#UNIDADDEMEDIDA').attr('checked', true);
            $('#CANTIDAD').attr('checked', true);
            $('#COSTOSIVA').attr('checked', true);
            $('#TOTALCOMPRASIVA').attr('checked', true);
            $('#PRECIODEVENTA').attr('checked', true);
            $('#VENTATOTAL').attr('checked', true);
            $('#PORCENTAJE').attr('checked', true);
            $('#UTILIDADTOTAL').attr('checked', true);
            $('#DIFERENCIAUNITARIA').attr('checked', true);

            // false
            $('#TOTALCOSTOS').attr('checked', false);
            $('#TOTALCOMPRACIVA').attr('checked', false);
            $('#FECHA').attr('checked', false);
            $('#TOTALEXISTENCIASIVA').attr('checked', false);
            $('#TOTALEXISTENCIACIVA').attr('checked', false);
            $('#COSTOCIVA').attr('checked', false);
            // $('#GANANCIAUNITARIA').attr('checked', false);
        } else {
            $('#CODIGO').attr('checked', true);
            $('#FECHA').attr('checked', true);
            $('#CODIGODEBARRA').attr('checked', true);
            $('#CATEGORIA').attr('checked', true);
            $('#MARCA').attr('checked', true);
            $('#NOMBRE').attr('checked', true);
            $('#UNIDADDEMEDIDA').attr('checked', true);
            $('#CANTIDAD').attr('checked', true);

            $('#COSTOSIVA').attr('checked', true);
            $('#TOTALCOMPRASIVA').attr('checked', true);

            $('#PRECIODEVENTA').attr('checked', true);

            $('#VENTATOTAL').attr('checked', true);
            $('#PORCENTAJE').attr('checked', true);
            $('#DIFERENCIAUNITARIA').attr('checked', true);
            $('#UTILIDADTOTAL').attr('checked', true);

            // false
            $('#TOTALCOSTOS').attr('checked', false);
            $('#TOTALCOMPRACIVA').attr('checked', false);
            $('#TOTALEXISTENCIASIVA').attr('checked', false);
            $('#TOTALEXISTENCIACIVA').attr('checked', false);
            $('#COSTOCIVA').attr('checked', false);
        }
    });
});
