$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $("#btnverdetalle").on('click', function(){
        let id = $(this).data("productoid");
        $.get("/detalleProductoNotificaction/"+id, function(res){
            $("#categoriatxt").text(res.data.category_name)
            $('#marcatxt').text(res.data.marca_name);
            $('#codigotxt').text(res.data.code);
            $('#unidadmedidatxt').text(res.data.medida_name);
            $('#codigobarratxt').text(res.data.barcode);
            $('#descripcciontxt').text(res.data.name);
            $('#cantidadtxt').text(res.data.stock_min);
            $('#detallestxt').html(res.data.description);
            let precioventafinal = res.data.precioventa.toFixed(2)
            $('#precioventafinaltxt').text("$"+precioventafinal);
            if(res.existimage) {
              let  pathroute = res.image;
                $('#contentimage').html('<img class="img-fluid" src="'+ pathroute +'" width=150 height=150 alt="Hello Image" />');
            }
            $("#shownoti").modal("show")
        })
    });
});

