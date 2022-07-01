$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let global = $("#deuda_idglobal").val();
    
    findabonos(global);
    findnotas(global);
    findpagos(global);
    
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


    $('input[type=radio][name=condicionespago_idupdate]').change(function() {
        let res; let accept;
        let idglobal = $("#deuda_idglobal").val()
        if ($(this).val() == 2) {
            $('#contentpagos').removeClass('d-none');
        } else {
            res = $.get('findpagoopt/'+idglobal, function (data) { 
                return data;
                })
                if(res){
                accept = deletePagochangeoptione(idglobal);
                if(accept){
                    $('#contentpagos').addClass('d-none');
                } else {
                    $(this).val() == 2 ?? $(this).prop('checked', true)
                    $('#contentpagos').removeClass('d-none');
                }
                } else {
                    $('#contentpagos').addClass('d-none');
                }
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


        // actualizar deuda 
        $("#formDeudasEdit").submit(function (event) {
            event.preventDefault();   
            var frm = $(this).serialize();          
            $.ajax({
                url: '/updatedDeudas',
                type: 'GET',
                dataType: "JSON",
                data: frm,
                success: function (res) {                 
                    AlerSuccess();                 
                    location.href = "/deudas";
                },
                error: function (err) {
                    console.log(err)
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '¡Error algo salio mal!'
                    });
                }
            })
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



    function findabonos(id) {
        $("#bodyabo").empty();
        $.get('/findabonos/' + id, function(res) {
            $("#bodyabo").html(res);
        })
    }

    function findnotas(id) {
        $("#bodynot").empty();
        $.get('/findnotas/' + id, function(res) {
            $("#bodynot").html(res);
        });
    }

    function findpagos(id) {

        $.get('/findpagos/' + id, function(res) {  
            if(res.show) {
                $("#contentpagos").removeClass('d-none');
                let datares = res.data
               
                let present = false;
                
                datares.presentafactura == 'no' ? present == false :  present == true
                
                $('#presentafacturaeditpago').prop('checked', present);
                $('#numero_reciboedit').prop('readonly', datares.presentafactura == 'si' ? false : true);
                $('#numero_reciboedit').val(datares.numero_recibo);
                $('#pagoidedit').val(datares.id);                
                $('[name="forma_pagoedit"]').each(function(){
                    if($(this).val() == datares.formapago_id) {
                        $(this).prop('checked', true) 
                    }
                })
                $('#numerochequeedit').prop('readonly', datares.formapago_id == 3 ? true : false);
            } else {
                $("#contentpagos").addClass('d-none');

            }
        });
    }

    function deletePagochangeoptione(id) {
        let respo = false;
            Swal.fire({
                title: '¿Esta seguro?',
                text: "¡El pago se borrara por medidas de seguridad y no se podra recuperar!",
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
                    respo = true
                } else {
                    respo = false;
                }
                return respo;
            });
      
        
    }

    function validateInput(){
        let proveedor_id = false, numero_factura = false;

        if($('#proveedor_id').val() !== ''){
            proveedor_id = true;
            $('#proveedor_id').removeClass('is-invalid');
        } else {
            proveedor_id = false;
            $('#proveedor_id').addClass('is-invalid');
        }
        if($('#numero_factura').val() !== ''){
            numero_factura = true;
            $('#numero_factura').removeClass('is-invalid');
        } else {
            numero_factura = false;
            $('#numero_factura').addClass('is-invalid');
        }

        if(proveedor_id && numero_factura) {
            return true;
        } else {
            return false;
        }
    }