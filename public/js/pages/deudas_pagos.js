$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

        // buscar factuara en modal pagos
        $('#deudas_idpago').select2({
            theme: "bootstrap-5",
            dropdownParent: $('#pagosModal'),
            placeholder: 'Seleccione...',
            allowClear: true,
            ajax: {
                url: '/searchfactura',
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

            // para obtener el onchagen 
    $("#deudas_idpago").change(function() {
        $.get('/deudashow/'+$(this).val(), function(res) {
            let sumadtotal = res[0].total_compra - (res[0].totalpago_abono + res[0].totalpago_nota)
            console.log(sumadtotal)
            $('#totalfactura').val(res[0].total_compra)
            $('#totalpagoshow').val(sumadtotal)
            $('#fechafacturado_pago').val(res[0].fecha_factura)
            $('#fechapago_pago').val(res[0].fecha_pago)
        })
    })
     // voy a controlar el tipo de pago
     $('input[type=radio][name=formapago_idpago]').change(function() {
        if ($(this).val() == 3) {
            $('#numerochequepago').prop('readonly', true);
        } else {
            $('#numerochequepago').prop('readonly', false);
        }
    });

    $("#frmpagos").submit(function (event) {
        var frm = $(this).serialize();
        event.preventDefault();   
            $.ajax({
                url: '/pagos',
                type: 'POST',
                dataType: "JSON",
                data: frm,
                success: function (res) {
                    console.log(res)
                    AlerSuccess();
                    // AlertConfirmacin(res.message);
                    $("#frmpagos").trigger("reset");
                    listdata();
                   // $("#nuevoModal").modal("hide");
                },
                error: function (err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '¡Error algo salio mal!'
                    });
                }
            })       
    });

});

$(document).on('click', '#btnborrarpago', function (){
    let id = $(this).val();
    Swal.fire({
        title: '¿Esta seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, bórralo!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                data: {
                    "_token": $("meta[name='csrf-token']").attr("content")
                },
                url: "destroypagos/" + id,
                type: "DELETE",
                dataType: "JSON",
                success: function (res) {
                    findpagos(id);
                    AlertConfirmacin("El pago se ha borrado Correctamente!");
                    listdata();
                },
                error: function (err) {
                    erroSwal("¡Algo salió mal!");
                }
            });
        }
    });
});
