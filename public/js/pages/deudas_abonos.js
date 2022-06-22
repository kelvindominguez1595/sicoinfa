$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    // buscar numero factura abonos
    $('#deudas_idabonos').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#abonosModal'),
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

         // voy a controlar el tipo de abinios
         $('input[type=radio][name=form_pagoabono]').change(function() {
            if ($(this).val() == 3) {
                $('#numcheque_abono').prop('readonly', true);
            } else {
                $('#numcheque_abono').prop('readonly', false);
            }
        });
        
        $("#frmAbonos").submit(function (event) {
            var frm = $(this).serialize();
            event.preventDefault();   
                $.ajax({
                    url: '/abonos',
                    type: 'POST',
                    dataType: "JSON",
                    data: frm,
                    success: function (res) {
                        console.log(res)
                        AlerSuccess();
                        // AlertConfirmacin(res.message);
                        $("#frmAbonos").trigger("reset");
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

    $(document).on('click', '#btndeleteAbonos', function (){
        let id = $(this).val();
        let deudaid = $('#deuda_idglobal').val();
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
                    url: "destroyabonos/" + id,
                    type: "DELETE",
                    dataType: "JSON",
                    success: function (res) {
                        findabonos(deudaid);
                        AlertConfirmacin("El abono se ha borrado Correctamente!");
                    },
                    error: function (err) {
                        erroSwal("¡Algo salió mal!");
                    }
                });
            }
        });
    });
    