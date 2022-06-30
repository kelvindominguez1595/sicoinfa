$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
        $('#proveedor_idedit').select2({
            theme: "bootstrap-5",
            dropdownParent: $('#editarDeudaModal'),
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


        $('#presentafacturaeditpago').on('change', function () {
            let numrecibo = $('#numero_reciboedit')
            if($(this).is(':checked')){
                numrecibo.prop('readonly', false);
            } else {
                numrecibo.val('')
                numrecibo.prop('readonly', true);
            }
        });

    });


    $(document).on('click', '#btndeleteall', function (){
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
                    url: "deletedeudasall/" + id,
                    type: "DELETE",
                    dataType: "JSON",
                    success: function (res) {
                        listdata();
                        AlertConfirmacin("La deuda se ha borrado!");
                        $("#editarDeudaModal").modal('hide');
                    },
                    error: function (err) {
                        erroSwal("¡Algo salió mal!");
                    }
                });
            }
        });
    });
