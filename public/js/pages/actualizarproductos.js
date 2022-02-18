$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    showTime();
    var stockid = $('#stocks_id').val();

    listarExistencia(stockid); // listamos las existencias

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
        btns: [ ['strong', 'foreColor'],]
    });

    // para dejar el dato seleccionado
    let cateid = document.querySelector('#category_id').dataset.categoryid;
    let marcaid = document.querySelector('#manufacturer_id').dataset.maracid;
    let unidadmedida = document.querySelector('#measures_id').dataset.unidamedida;
    let proveedorid = document.querySelector('#suppliers_id').dataset.idproveedor;
    let branchoffice = document.querySelector('#branch_offices_id').dataset.branchoffice;
    obtenerPrecios(stockid, branchoffice); // para obtener el precio
    // validamos que los data set tenga algun dato para cargar un item en el select2
    $.get('../../categoriasid/'+cateid, function (res) {
        $('#category_id').append('<option value="'+res.id+'" selected="selected">'+res.name+'</option>');
    });

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
    // por porcentaje
    $( "#earn_porcent" ).change(function() {
        var preciofinal = $('#sale_price');
        var ganancia = $('#earn_c_iva');
        var costoconiva = $('#cost_c_iva');
        // mostramos el porcentaje de ganancia que tendra
        let resultadoporcentaje = Number(costoconiva.val() * ($(this).val() / 100))
        ganancia.val(resultadoporcentaje.toFixed(4));
        // sumamos costo con iva mas la ganancia para mostrar la venta final del consumidor3.25
        let precioventa =Number(resultadoporcentaje) + Number(costoconiva.val());
        preciofinal.val(precioventa.toFixed(4));
    });
    // precio venta final
    $( "#sale_price" ).change(function() {
        var preciofinal = $(this).val();
        var costoconiva = $('#cost_c_iva');
        var porcenaje = $('#earn_porcent');
        var ganancia = $('#earn_c_iva');
        // mostramos el porcentaje de ganancia que tendra
        let resultadoporcentaje = (((preciofinal / costoconiva.val()) - 1)  * 100)
        let resulporce = costoconiva.val() == 0 ? 0 : resultadoporcentaje;
        porcenaje.val(resulporce.toFixed(2))
        let resultadoganancia = Number(preciofinal - costoconiva.val()) ;
        let resulGan = costoconiva.val() == 0 ? 0 : resultadoganancia;
        ganancia.val(resulGan.toFixed(4));
    });


    $('#unit_price').change(function() {
        let preciosiniva = $(this).val();
        let cantidad = $('#quantity').val();
        let costoTotal = Number(cantidad) * Number(preciosiniva);
        $('#costototal').val(costoTotal.toFixed(4));
    });

    $('#quantity').change(function() {
        let preciosiniva  = $('#unit_price').val();
        let cantidad  = $(this).val();
        let costoTotal = Number(cantidad) * Number(preciosiniva);
        $('#costototal').val(costoTotal.toFixed(4));
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
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '¡Error algo salio mal!'
                    });
                }
            },
            error: function (response) {
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
                    setTimeout(function() {
                        location.reload();
                    }, 3000);
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

    // para hacer la transferencia de productos a otra sucursal
    $("#desde").change(function () {
        var desde = $(this).val();
        if(desde == 1) {
            $("#hasta").val(2)
        } else {
            $("#hasta").val(1)
        }
    });

    $("#hasta").change(function () {
        var desde = $(this).val();
        if(desde == 1) {
            $("#desde").val(2)
        } else {
            $("#desde").val(1)
        }
    });

    /**
     * Debemos valiar que el almacen tenga stock para hacer transferencia
     * verificar que no sea al mismo almacen
     * */

    $("#traslado").submit(function (event) {
        var frm = $(this).serialize();
        var cantidad = $("#cantidadtransferrer").val();
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();

        if(Number(cantidad) == 0){
            AlertError("La cantidad debe ser mayor a 0");
        } else if(desde == 0){
            AlertError("Debe seleccionar la sucursal desde donde realizará el envio");
        }
         else if(hasta == 0){
            AlertError("Debe seleccionar la sucursal que recibira el producto enviado");
        }
        else{
            $.ajax({
                url: "/transferencia",
                type: "POST",
                dataType: "JSON",
                data: frm,
                success: function (response) {
                    $("#cantidadtransferrer").val(0);
                    AlertConfirmacin(response.message);
                    listarExistencia(stockid);
                },
                error: function (response) {
                    AlertError(response.responseJSON.error.message);
                }
            });
        }
        event.preventDefault();
    })
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

function showTime() {
    var fecha = new Date(); //Fecha actual
    var month = fecha.getMonth() + 1; //obteniendo mes
    var day = fecha.getDate(); //obteniendo dia
    var year = fecha.getFullYear(); //obteniendo año
    // hora
    hours = fecha.getHours();
    minutes = fecha.getMinutes();
    seconds = fecha.getSeconds();
    let hora =  fecha.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true })
    if (hours < 10) hours = 0 + hours;
    if (minutes < 10) minutes = "0" + minutes;
    if (seconds < 10) seconds = "0" + seconds;
    $("#fechaingreso").val(day + "-" + month + "-" + year + " " + hora);
    setTimeout("showTime()", 1000);
}

function obtenerPrecios(producto, sucursal){
    $.get('../../precioRealdelProducto/'+producto+'/'+sucursal, function (res) {
        let costosiniva     = $("#cost_s_iva");
        let costoconiva     = $("#cost_c_iva");
        let ganancia        = $("#earn_c_iva");
        let porcentaje      = $("#earn_porcent");
        let precioventa     = $("#sale_price");
        let precioid        = $("#precioid");
        // mostramos el precio viejo si no hay nuevo
        if(res.cambio == 'no hay nuevo precio' && res.cambioViejos == 'no viejo')
        {
            costosiniva.val(res.costosinivaViejos.toFixed(4));
            costoconiva.val(res.costoconivaViejos.toFixed(4));
            ganancia.val(res.gananciaViejos.toFixed(4));
            porcentaje.val(res.porcentajeViejos);
            precioventa.val(res.precioventaViejos.toFixed(4));
            precioid.val(res.idviejo);
            numeronegativo(res.gananciaViejos.toFixed(4), res.porcentajeViejos.toFixed(4), res.precioventaViejos.toFixed(4), res.costoconivaViejos.toFixed(4));
        } else if(res.cambio != 'no hay nuevo precio' && res.cambioViejos == 'no viejo') {
            costosiniva.val(res.costosiniva.toFixed(4));
            costoconiva.val(res.costoconiva.toFixed(4));
            ganancia.val(res.ganancia.toFixed(4));
            porcentaje.val(res.porcentaje);
            precioventa.val(res.precioventa.toFixed(4));
            precioid.val(res.idnuevo);
            numeronegativo(res.ganancia.toFixed(4), res.porcentaje.toFixed(4), res.precioventa.toFixed(4), res.costoconiva.toFixed(4));
        } else {
            costosiniva.val(res.costosiniva.toFixed(4));
            costoconiva.val(res.costoconiva.toFixed(4));
            ganancia.val(res.ganancia.toFixed(4));
            porcentaje.val(res.porcentaje.toFixed(4));
            precioventa.val(res.precioventa.toFixed(4));
            precioid.val(res.idnuevo);
            numeronegativo(res.ganancia.toFixed(4), res.porcentaje.toFixed(4), res.precioventa.toFixed(4), res.costoconiva.toFixed(4));
        }
    });

}

function numeronegativo(ganancia, porcentaje, precioventa, costoconiva){
    let gananciamessage;
    let porcentamessage;
    let ventamessage;
    let showga, showpor, showvent;
    if(ganancia > 0){
        $("#earn_c_iva").removeClass("is-invalid");
        showga = false;
    } else {
        showga = true;
        gananciamessage = "\n * La ganancia esta en números negativos por favor corregir la GANANCIA";
        $("#earn_c_iva").addClass("is-invalid");
    }
    if(porcentaje > 0){
        showpor = false;
        $("#earn_porcent").removeClass("is-invalid");
    } else {
        showpor = true;
        $("#earn_porcent").addClass("is-invalid");
        porcentamessage = "\n * El porcentaje está en números negativos por favor corregir el PORCENTAJE";
    }
    if(costoconiva > precioventa){
        showvent = true;
        $("#sale_price").addClass("is-invalid");
        ventamessage = "\n * El PRECIO DE VENTA es menor que el COSTO MAS IVA";
    } else {
        showvent = false;
        $("#sale_price").removeClass("is-invalid");
    }
    if(showga == true || showpor == true || showvent == true) {
        timeShowchange(20000);
        AlertError("POR FAVOR CORREGIR LOS DATOS SIGUIENTES Y QUE APARECEN MARCADOS EN ROJO \n"+gananciamessage + porcentamessage + ventamessage)
    }
}
