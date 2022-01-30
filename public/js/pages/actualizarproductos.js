$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var stockid = $('#stocks_id').val();
    // cargamos los select2
    $('#category_id').select2({
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

    $('#manufacturer_id').select2({
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

    $('#measures_id').select2({
        theme: "bootstrap-5",
        placeholder: 'Seleccione...',
        allowClear: true,
        ajax: {
            url: '/list_unidaddenedida',
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

    $('#suppliers_id').select2({
        theme: "bootstrap-5",
        placeholder: 'Seleccione...',
        allowClear: true,
        ajax: {
            url: '/list_proveedores',
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

    $('#branch_offices_id').select2({
        theme: "bootstrap-5",
        placeholder: 'Seleccione...',
        allowClear: true,
        ajax: {
            url: '/list_sucursales',
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

    // para que cambie la imagen y ver la vista previa
    $("#imagen").change(function() {
        readURL(this);
    });

    $('#editor').trumbowyg({
        btns: [
            ['strong', 'foreColor'],
        ]
    });

    // para dejar el dato seleccionado
    let cateid = document.querySelector('#category_id').dataset.categoryid;
    let marcaid = document.querySelector('#manufacturer_id').dataset.maracid;
    let unidadmedida = document.querySelector('#measures_id').dataset.unidamedida;
    let proveedorid = document.querySelector('#suppliers_id').dataset.idproveedor;
    let branchoffice = document.querySelector('#branch_offices_id').dataset.branchoffice;

    // validamos que los data set tenga algun dato para cargar un item en el select2
    $.get('../../categoriasid/'+cateid, function (res) {
        $('#category_id').append('<option value="'+res.id+'" selected="selected">'+res.name+'</option>');
    });

    listarExistencia(stockid); // listamos las existencias

    $.get('../../marcasid/'+marcaid, function (res) {
        $('#manufacturer_id').append('<option value="'+res.id+'" selected="selected">'+res.name+'</option>');
    });

    $.get('../../unidadmedidaid/'+unidadmedida, function (res) {
        $('.measures_id').append('<option value="'+res.id+'" selected="selected">'+res.name+'</option>');
    });

    if(proveedorid > 0){
        $.get('../../proveedoresid/'+proveedorid, function (res) {
            $('#suppliers_id').append('<option value="'+res.id+'" selected="selected">'+res.nombre_comercial+'</option>');
        });
    }

    $.get('../../sucursalid/'+branchoffice, function (res) {
        $('#branch_offices_id').append('<option value="'+res.id+'" selected="selected">'+res.name+'</option>');
    });

    // aqui estan la formulas para hacer los calulos de los precios
    // precio venta final
    $( "#sale_price" ).change(function() {
        var preciofinal = $(this).val();
        var porcenaje = $('#earn_porcent');
        var ganancia = $('#earn_c_iva');
        var costoconiva = $('#cost_c_iva');
        // mostramos el porcentaje de ganancia que tendra
        let resultadoporcentaje = (((preciofinal / costoconiva.val()) - 1)  * 100)
        porcenaje.val(resultadoporcentaje.toFixed(2))
        let resultadoganancia = Number(preciofinal - costoconiva.val()) ;
        ganancia.val(resultadoganancia.toFixed(4));
    });

    // por porcentaje
    $( "#earn_porcent" ).change(function() {
        var preciofinal = $('#sale_price');
        var ganancia = $('#earn_c_iva');
        var costoconiva = $('#cost_c_iva');
        // mostramos el porcentaje de ganancia que tendra
        let resultadoporcentaje = Number(costoconiva.val() * ($(this).val() / 100))
        ganancia.val(resultadoporcentaje.toFixed(4));
        // sumamos costo con iva mas la ganancia para mostrar la venta final del consumidor
        let precioventa =Number(resultadoporcentaje) + Number(costoconiva.val());
        preciofinal.val(precioventa.toFixed(4));
    });

    // ganancia del producto
    $( "#earn_c_iva" ).change(function() {
        var porcenaje = $('#earn_porcent');
        var preciofinal = $('#sale_price');
        var costoconiva = $('#cost_c_iva');
        let resultpreciofinal = Number($(this).val()) + Number(costoconiva.val()); // precio final
        let resulporcentaje = (((resultpreciofinal / costoconiva.val()) - 1)  * 100); //  porcentaje final
        porcenaje.val(resulporcentaje.toFixed(2));
        preciofinal.val(resultpreciofinal.toFixed(4))
    });

    $('#unit_price').change(function() {
        let preciosiniva = $(this).val();
        let cantidad = $('#quantity').val();
        let costoTotal = Number(cantidad) * Number(preciosiniva);
        $('#costototal').val(costoTotal);
    });

    $('#quantity').change(function() {
        let preciosiniva  = $('#unit_price').val();
        let cantidad  = $(this).val();
        let costoTotal = Number(cantidad) * Number(preciosiniva);
        $('#costototal').val(costoTotal);
    });

    // actutilizar los datos del producto
    $( "#frmupdate" ).submit(function( event ) {
        var form = new FormData($("#frmupdate")[0]);
        var id = $('#stocks_id').val();
        $.ajax({
            url: "/productos/"+ id,
            type: "POST",
            dataType: 'JSON',
            data: form,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.message) {
                    AlertConfirmacin(response.message);
                    $('#messagedanger').addClass("d-none");
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '¡Error algo salio mal!'
                    });
                }

            },
            error: function (response) {
                //4
                if (response.responseJSON.errors.name) {
                    $("#idCpro4").addClass("has-error");
                    $("#txt_name").text('El campo nombre es obligatorio.');

                } else {
                    $("#idCpro4").addClass("has-error");
                    $("#txt_name").text('');
                }
            }
        });
        event.preventDefault();
    });
    // creamos un nuevo ingresos de productos
    $( "#frmentradaproductos" ).submit(function( event ) {
        var form = new FormData($("#frmentradaproductos")[0]);

        $.ajax({
            url: "/ingresos",
            type: "POST",
            dataType: 'JSON',
            data: form,
            contentType: false,
            processData: false,
            success: function (response) {
                // console.log(data);
                if (response.message) {
                    // location.reload();
                    //  confirm("Producto actualizado correctamente");
                    listarExistencia(stockid);
                    AlertConfirmacin('Nuevo ingreso de producto correctamente');
                    $('#cost_s_iva').val(response.sinva);
                    $('#cost_c_iva').val(response.coniva);
                    $('#earn_c_iva').val(0);
                    $('#earn_porcent').val(0);
                    $('#sale_price').val(0);
                    $('#quantity').val(0);
                    $('#unit_price').val(0);
                    $('#costototal').val(0);
                    $('#messagedanger').removeClass("d-none");
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '¡Error algo salio mal!'
                    });
                    // AlertError('¡Error algo salio mal!');
                }
            },
            error: function (response) {
                //4
                if (response.responseJSON.errors.name) {
                    $("#suppliers_id").addClass("is-invalid");
                    $("#txt_name").text('El campo nombre es obligatorio.');

                } else {
                    $("#suppliers_id").addClass("is-invalid");
                    $("#txt_name").text('');
                    AlertError("El campo proveedor es obligatorio");
                }
            }
        });
        event.preventDefault();
    });

});

function listarExistencia(id){
    // para obtener la existencia del producto
    $.get('/existenciaProducto/'+id, function (res) {
        $("#existenciaproducto > tbody").empty();
        res.map((item, index) => {
            $("#existenciaproducto > tbody").append("<tr> <td>"+item.name+"</td> <td>"+item.quantity+"</td> <td>"+item.updated_at+"</td> </tr>")
        })
    });
}
// esto sirve para el editor y para visualizar la imagen
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            // Asignamos el atributo src a la tag de imagen
            $('#imagenmuestra').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
