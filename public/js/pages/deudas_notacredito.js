$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
        // buscar factura 
        $('#deudas_id').select2({
            theme: "bootstrap-5",
            dropdownParent: $('#notacreditoModal'),
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
        $("#frmNotacredito").submit(function (event) {
            var frm = $(this).serialize();
            event.preventDefault();   
                $.ajax({
                    url: '/notacredito',
                    type: 'POST',
                    dataType: "JSON",
                    data: frm,
                    success: function (res) {
                        console.log(res)
                        AlerSuccess();
                        // AlertConfirmacin(res.message);
                        $("#frmNotacredito").trigger("reset");
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