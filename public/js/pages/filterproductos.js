
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
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

// para mostrar la iamgen
$(document).on('click', '#imgzoom', function () {
    var imgsrc = $(this).data('pathimage');
    $('#my_image').attr('src',imgsrc);
    $("#showimagen").modal("show");
});

$(document).on('click', '#btnshowmodalproducto', function (){
    let id = $(this).val();

    $.get('/showdetialsproduct/'+ id, function (res){
        let data = res.query;

        $("#showdetailsclient").modal('show');
        $('#categoriashow').val(data.category_name);
        $('#marcashow').val(data.marca_name);
        $('#codigoshow').val(data.code);
        $('#unidaddemedidashow').val(data.medida_name);
        $('#codigobarrashow').val(data.barcode);
        $('#nombreshow').val(data.name);
        $('#contentshow').html(data.description);

        let costosinniva = $("#costosinivashow")
        let costoconiva = $("#costoconivashow")
        let ganancia = $("#gananciashow")
        let procentaje = $("#porcentajeshow")
        let venta = $("#ventashow")

        if(data.costosiniva !== null) {
            costosinniva.val(data.costosiniva.toFixed(2))
        } else {
            costosinniva.val(data.cost_s_iva.toFixed(2))
        }

        if(data.costoconiva !== null) {
            costoconiva.val(data.costoconiva.toFixed(2))
        } else {
            costoconiva.val(data.cost_c_iva.toFixed(2))
        }

        if(data.ganancia !== null) {
            ganancia.val(data.ganancia.toFixed(2))
        } else {
            ganancia.val(data.earn_c_iva.toFixed(2))
        }

        if(data.porcentaje !== null) {
            procentaje.val(data.porcentaje)
        } else {
            procentaje.val(data.earn_porcent)
        }

        if(data.precioventa !== null) {
            venta.val(data.precioventa.toFixed(2))
        } else {
            venta.val(data.sale_price.toFixed(2))

        }
        let checkedimage;
        if(data.state == 1) {
            checkedimage = "/images/checkactive.png";
        } else {
            checkedimage = "/images/checkinactive.png";
        }
        let poster;
        if(data.image !== '') {
            poster = "/images/productos/"+data.image;
        } else {
            poster = "/images/logoFerreteria.png"
        }

        $('#statecheckedshow').attr('src', checkedimage);
        $('#posteproductshow').attr('src', poster);
        let contenhtml = '<div>';
        res.quantity.map((item) => {
            contenhtml  += '<strong>';
            contenhtml  += item.almacen+": ";
            contenhtml  += '</strong>';
            contenhtml  += item.quantity;
            contenhtml  += '<br>';
        })
        contenhtml  += '</div>';
        $("#contenedorstock").html(contenhtml);

    });
});
