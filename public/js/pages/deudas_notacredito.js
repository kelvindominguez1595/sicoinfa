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

    $(document).on('click', '#btndeletenota', function (){
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
                    url: "destroycredito/" + id,
                    type: "DELETE",
                    dataType: "JSON",
                    success: function (res) {
                        findnotas(deudaid);
                        AlertConfirmacin("La nota se ha borrado Correctamente!");
                        listdata();
                    },
                    error: function (err) {
                        erroSwal("¡Algo salió mal!");
                    }
                });
            }
        });
    });
    