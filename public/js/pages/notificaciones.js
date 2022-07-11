$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

});

    $(document).on('click', '#btnverdetalle', function (){
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



