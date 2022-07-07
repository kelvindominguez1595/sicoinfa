$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $("#btnverdetalle").on('click', function(){
        let id = $(this).data("productoid");
        $.get("/detalleProductoNotificaction/"+id, function(res){
            $("#categoriatxt").val(res.data.category_name)
            $('#marcatxt').val(res.data.marca_name);
            $('#codigotxt').val(res.data.code);
            $('#unidadmedidatxt').val(res.data.medida_name);
            $('#codigobarratxt').val(res.data.barcode);
            $('#descripcciontxt').val(res.data.name);
            $('#cantidadtxt').val(res.data.stock_min);
            $('#detallestxt').html(res.data.description);
            let precioventafinal = res.data.precioventa.toFixed(2)
            $('#precioventafinaltxt').val("$"+precioventafinal);
            if(res.existimage) {
              let  pathroute = res.image;
                $('#contentimage').html('<img class="img-fluid" src="'+ pathroute +'" width="350" height="350" alt="Hello Image" />');
            }
            $("#shownoti").modal("show")
        })
    });
});

