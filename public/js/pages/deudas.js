$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    listdata();

    // para ver el estado
    $('#presentafactura').on('change', function () {
        let numrecibo = $('#numero_recibonuevo')
        if($(this).is(':checked')){
            numrecibo.prop('readonly', false);
        } else {
            numrecibo.val('')
            numrecibo.prop('readonly', true);
        }
    });


    $('input[type=radio][name=condicionespago_id]').change(function() {
        if ($(this).val() == 2) {
            $('#contenedorpagos').removeClass('d-none');
        } else {
            $('#contenedorpagos').addClass('d-none');
        }
    });

    $('input[type=radio][name=formpago_nuevo]').change(function() {
        if ($(this).val() == 3) {
            $('#numerochequenuevo').prop('readonly', true);
        } else {
            $('#numerochequenuevo').prop('readonly', false);
        }
    });

    // buscar proveedores
    $('#proveedor_id').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#nuevoModal'),
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

    $("#fecha_factura").change(function(){
        let val = $(this).val();
        let fechapago = $("#fecha_pago");
        $.get("/addModdate/"+val, function(res){
            console.log(res.dateforma);
            fechapago.val(res.dateforma);
        });
    });

    // para modal registrar proveedor
    $("#btnaddproveedor").click(function () {
        // abrir modal
        $("#frmdata").trigger("reset");
        $("#modaldata").modal("show");
        $(".modal-title").text("Nuevo Proveedor");
    });

    $("#frmdata").submit(function (event) {
        let frm = $(this).serialize();
        let id = $("#id").val();
        let btnname = $("#btnmodal").text();
        let route, typ;
        // guardar
        route = '/proveedores';
        typ = "POST";
        $.ajax({
            url: route,
            type: typ,
            dataType: "JSON",
            data: frm,
            success: function (res) {
                AlertConfirmacin(res.message);
                $("#frmdata").trigger("reset");
                $("#modaldata").modal("hide");
                // setTimeout(function (){
                //     location.reload();
                // }, 3000);
            },
            error: function (err) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Error algo salio mal!'
                });
            }
        })
        event.preventDefault();
    });

    // crear deuda nueva
    $("#frmnuevo").submit(function (event) {
        event.preventDefault();
        var frm = $(this).serialize();
        if(validateInput()){
            $.ajax({
                url: '/nuevadeuda',
                type: 'POST',
                dataType: "JSON",
                data: frm,
                success: function (res) {
                    console.log(res)
                    AlerSuccess();
                    // AlertConfirmacin(res.message);
                    $("#frmnuevo").trigger("reset");

                    let numrecibo = $('#numero_recibonuevo')
                    numrecibo.prop('readonly', true);
                    if ($('input[type=radio][name=condicionespago_id]').val() == 2) {
                        $('#contenedorpagos').removeClass('d-none');
                    } else {
                        $('#contenedorpagos').addClass('d-none');
                    }
                    listdata();
                   // $("#nuevoModal").modal("hide");
                },
                error: function (err) {
                    console.log()
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: err.responseJSON.errors.numero_factura[0]
                    });
                }
            })
        } else {
            AlertError("Los campos marcados en rojo son OBLIGATORIOS");
        }
    });

    $("#frmbusquedadeuda").submit(function (event) {
        event.preventDefault();
        var frm = $(this).serialize();
            $.ajax({
                url: '/loaddatadeuda',
                type: 'GET',
                dataType: "JSON",
                data: frm,
                success: function (res) {
                    $("#tbcontentdata").html(res);
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

    $("#mostrartododeuda").on('click', function(){
        listdata();
    })


});

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

    function formatDate(date){
        return moment(date).format('L');
    }

    $(document).on('click', '#btnupdate', function (){
        let id = $(this).val();
        $("#tblabono > tbody").empty();
        $.get('/editar_deudas/'+ id, function (res){
            $("#exampleModal").modal('show');

            // show deudas
            $('#totalcompraadd').prop('readonly', true);
            $('#abonoadd').prop('readonly', false);
            $('#saldopendienteadd').prop('readonly', false);
            $('#notacreditoadd').prop('readonly', false);
            $('#valornotacreditoadd').prop('readonly', false);
            $('#totalcompraadd').val(res.dlast[0].total_compra.toFixed(2));

            $('#ff').text(formatDate(res.deudas.fecha_factura));
            $('#nf').text(res.deudas.numero_factura);
            $('#tc').text("$"+res.dlast[0].total_compra.toFixed(2));
            $('#tp').text(res.deudas.tipo_factura);
            $('#pp').text(res.proveedor.nombre_comercial);
            // show detalle de deudas
            res.ddeudas.map((item) => {
                let row = "<tr>";
                row += "<td class='text-center'>";
                    row += item.forma_pago;
                row += "</td>";
                row += "<td class='text-center'>";
                    row += formatDate(item.fecha_abonopago);
                row += "</td>";
                row += "<td class='text-center'>";
                    row += item.num_documento == null ? "-" : item.num_documento;
                row += "</td>";
                row += "<td class='text-center'>";
                    row += "$"+item.abono.toFixed(2);
                row += "</td>";
                row += "<td class='text-center'>";
                    row += "$"+item.saldo.toFixed(2);
                row += "</td>";
                row += "<td class='text-center'>";
                    row += item.nota_credito;
                row += "</td>";
                row += "<td class='text-center'>";
                    row += "$"+item.valor_nota;
                row += "</td>";

                row += "</tr>";
                $("#tblabono").append(row);
            })
            // res.ddeudas.each(function (item, index){
            //     console.log(index);
            // })
        });
    });

    function listdata(){
        $.get("/loaddatadeuda", function (res){
            $("#tbcontentdata").html(res);
        })
    }

    function myFunction(id) {
        $("#editarDeudaModal").modal("show");
        $('#btndeleteall').val(id);
        $('#btnborrarpago').val(id);
        finddeudas(id);
        findabonos(id);
        findnotas(id);
        findpagos(id);
    }

    function finddeudas(id) {
        $.get('/finddeudas/' + id, function(res) {
           // $("#frmdatafacturaedit").html(res);
           $("#titlteprovedor").text("Proveedor: "+res.nombre_comercial);
           $("#deuda_idglobal").val(res.id);
           $("#proveedorid_selectedupdate").val(res.proveedor_id);
           $("#numero_facturaupdate").val(res.numero_factura);
           $('[name="documentoupdate"]').each(function(){
               if($(this).val() == res.documento_id) {
                   $(this).prop('checked', true)
                }
            })
            $("#fecha_facturaupdate").val(res.fecha_factura);
            $("#fecha_pagoupdate").val(res.fecha_pago);
            $("#total_compraupdate").val(res.total_compra);
            $('[name="condicionespago_idupdate"]').each(function(){
                if($(this).val() == res.condicionespago_id) {
                    $(this).prop('checked', true)
                 }
             })
        })
    }

    // pagination
    $(document).on('click', '#pagination .pagination a', function (e){
        e.preventDefault()
        let page = $(this).attr('href').split('page=')[1];
        let data = $('#numfacturabuscar').val();
        let data2 = $('#estadofacturadeuda').val();
        $.ajax({
            url: '/loaddatadeuda',
            data: {page: page, numfacturabuscar: data, estadofacturadeuda: data2},
            type: 'GET',
            dataType: 'JSON',
            success: function (data){
                $("#tbcontentdata").html(data);
            }
        })
    });

    $(document).on('click', '#rowtable', function (){
        let deudaid = $(this).data("deudaid");
        let estadodeuda = $(this).data("estadodeuda");
        $("#id").val(deudaid)
        if(estadodeuda == 1) {
            $("#txtshowestado").text("CRÉDITO");
        } else {
            $("#txtshowestado").text("PAGADO");
        }
        $("#showselecteditem").modal('show')
    });
