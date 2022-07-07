
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
