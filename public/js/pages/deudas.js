$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    listdata();

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

    // para obtener el onchagen 
    $("#deudas_idpago").change(function() {
        $.get('/deudashow/'+$(this).val(), function(res) {
            $('#totalfactura').val(res.total_compra)
            $('#totalpagoshow').val(res.total_compra)
            $('#fechafacturado_pago').val(res.fecha_factura)
            $('#fechapago_pago').val(res.fecha_pago)
        })
    })

    $("#fecha_factura").change(function(){
        let val = $(this).val();
        let fechapago = $("#fecha_pago");
        $.get("/addModdate/"+val, function(res){
            console.log(res.dateforma);
            fechapago.val(res.dateforma);
        });
    });

     // voy a controlar el tipo de pago
    $('input[type=radio][name=formapago_idpago]').change(function() {
        if ($(this).val() == 3) {
            $('#numerochequepago').prop('readonly', true);
        } else {
            $('#numerochequepago').prop('readonly', false);
        }
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
        var frm = $(this).serialize();
        event.preventDefault();   
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

    function validateFrmSave() {
        let proveedor = false, tipofactura = false, numerofactura = false, fechafacturado = false, fechapago = false;
        let containercondicipago = false, totalcompra = false;

        let formapago = false, numerocheque = false;

        if ($('input[type=radio][name=estado]:checked').val() === 'CONTADO') {
            if($('input:radio[name=formapago]:checked').val() === undefined){
                formapago = false;
                $('#contenedorpagofrm').addClass('border border-danger');
            } else {
                formapago = true;
                $('#contenedorpagofrm').removeClass('border border-danger');
            }

            if($('input[type=radio][name=formapago]').val() == 'EFECTIVO') {
                numerocheque = true;
                $('#numerocheque').removeClass('is-invalid');
            } else {
                $('#numerocheque').addClass('is-invalid');
                numerocheque = false;
            }
        } else {
            formapago = true;
            numerocheque = true;
        }


        if($('#proveedor').val() === '' || $('#proveedor').val() == null){
            proveedor = false;
            $('#proveedor').addClass('is-invalid');
        } else {
            proveedor = true;
            $('#proveedor').removeClass('is-invalid');
        }

        if($('input:radio[name=tipofactura]:checked').val() === undefined){
            tipofactura = false;
            $('#contenedortipofactura').addClass('border border-danger');
        } else {
            tipofactura = true;
            $('#contenedortipofactura').removeClass('border border-danger');
        }

       if($('#numerofactura').val() === '' || $('#proveedor').val() == null){
            numerofactura = false;
           $('#numerofactura').addClass('is-invalid');
       } else {
            numerofactura = true;
           $('#numerofactura').removeClass('is-invalid');
       }

       if($('#fechafacturado').val() === '' || $('#proveedor').val() == null){
            fechafacturado = false;
           $('#fechafacturado').addClass('is-invalid');
       } else {
            fechafacturado = true;
           $('#fechafacturado').removeClass('is-invalid');
       }

       if($('#fechapago').val() === '' || $('#proveedor').val() == null){
            fechapago = false;
           $('#fechapago').addClass('is-invalid');
       } else {
            fechapago = true;
           $('#fechapago').removeClass('is-invalid');
       }

       if($('#totalcompra').val() === '' || $('#proveedor').val() == null){
            totalcompra = false;
           $('#totalcompra').addClass('is-invalid');
       } else {
            totalcompra = true;
           $('#totalcompra').removeClass('is-invalid');
       }

       if($('input:radio[name=estado]:checked').val() === undefined){
        containercondicipago = false;
        $('#containercondicipago').addClass('border border-danger');
        } else {
            containercondicipago = true;
            $('#containercondicipago').removeClass('border border-danger');
        }

        if( proveedor
            && tipofactura
            && numerofactura
            && fechafacturado
            && fechapago
            && containercondicipago
            && totalcompra
            && formapago
            && numerocheque
            ) {
            return true;
        } else {
            return false;
        }
    }


    function validateInput(){
        let fechafacturaadd = false, fechaabonoadd = false, numfacturaadd = false, proveedoradd = false, tocomp = false, tipocdocumentocontenedor = false, formpago = false, numchequeremesa = false, numreciboadd = false, estadoadd = false, nota = false;

        if($('#fechafacturaadd').val() !== ''){
            fechafacturaadd = true;
            $('#fechafacturaadd').removeClass('is-invalid');
        } else {
            fechafacturaadd = false;
            $('#fechafacturaadd').addClass('is-invalid');
        }
        if($('#fechaabonoadd').val() !== ''){
            fechaabonoadd = true;
            $('#fechaabonoadd').removeClass('is-invalid');
        } else {
            fechaabonoadd = false;
            $('#fechaabonoadd').addClass('is-invalid');
        }
        if($('#numfacturaadd').val() !== ''){
            numfacturaadd = true;
            $('#numfacturaadd').removeClass('is-invalid');
        } else {
            numfacturaadd = false;
            $('#numfacturaadd').addClass('is-invalid');
        }

        if($('#proveedoradd').val() !== null){
            proveedoradd = true;
            $('#proveedoradd').removeClass('is-invalid');
        } else {
            proveedoradd = false;
            $('#proveedoradd').addClass('is-invalid');
        }

        if($('#tocomp').val() !== ''){
            tocomp = true;
            $('#tocomp').removeClass('is-invalid');
        } else {
            tocomp = false;
            $('#tocomp').addClass('is-invalid');
        }

        if($('#numreciboadd').val() !== ''){
            numreciboadd = true;
            $('#numreciboadd').removeClass('is-invalid');
        } else {
            numreciboadd = false;
            $('#numreciboadd').addClass('is-invalid');
        }

        if($('input:radio[name=tipofacturadd]:checked').val() !== undefined){
            tipocdocumentocontenedor = true;
            $('#tipocdocumentocontenedor').removeClass('border border-danger');
        } else {
            tipocdocumentocontenedor = false;
            $('#tipocdocumentocontenedor').addClass('border border-danger');
        }

        if($('input:radio[name=formapagoadd]:checked').val() !== undefined){
            formpago = true;
            $('#contenedorformapago').removeClass('border border-danger');

            if($('input:radio[name=formapagoadd]:checked').val() == 'EFECTIVO'){
                numchequeremesa = true;
                $('#numchequeremesa').removeClass('is-invalid');
            } else {
                if($('#numchequeremesa').val() !== ''){
                    numchequeremesa = true;
                    $('#numchequeremesa').removeClass('is-invalid');
                } else {
                    numchequeremesa = false;
                    $('#numchequeremesa').addClass('is-invalid');
                }
            }
        } else {
            formpago = false;
            $('#contenedorformapago').addClass('border border-danger');
        }

        if($('input:radio[name=estadoadd]:checked').val() == 'ABONADO'){
            estadoadd = false;
            if($('#abonoadd').val() == '0' || $('#abonoadd').val() == ''){
                estadoadd = false;
                $('#abonoadd').addClass('is-invalid');
            } else {
                estadoadd = true;
                $('#abonoadd'). removeClass('is-invalid');
            }
        } else {
            estadoadd = true;
        }

        if(  $('#aplicarcredito').is(':checked')){
            nota = false;
            if($('#notacreditoadd').val() == '0' && $('#valornotacreditoadd').val() == '0'){
                nota = false;
                $('#notacreditoadd').addClass('is-invalid');
                $('#valornotacreditoadd').addClass('is-invalid');
            } else {
                nota = true;
                $('#notacreditoadd'). removeClass('is-invalid');
                $('#valornotacreditoadd'). removeClass('is-invalid');
            }
        } else {
            nota = true;
        }

        if(fechafacturaadd && fechaabonoadd && numfacturaadd && proveedoradd && tipocdocumentocontenedor && formpago && numchequeremesa && numreciboadd && tocomp && estadoadd && nota) {
            return true;
        } else {
            return false;
        }
    }

    function clearInpust(){
        $('#fechafacturaadd').val('');
        $('#fechaabonoadd').val('');
        $('#numfacturaadd').val('');
        $("#proveedoradd").empty();
        $('#tocomp').val('');
        $('input[name="tipofacturadd"]').prop('checked', false);
        $('input[name="aplicarcredito"]').prop('checked', false);
        if($('input:radio[name=estadoadd]:checked').val() == 'ABONADO'){
            $('input:radio[name=estadoadd]').filter('[value="PAGADO"]').prop('checked', true)
        }
        $('#totalcompraadd').val('');
        $('#abonoadd').val('0');
        $('#saldopendienteadd').val('0');
        $('#notacreditoadd').val('0');
        $('#valornotacreditoadd').val('0')

        $('#abonoadd').prop('readonly', true);
        $('#saldopendienteadd').prop('readonly', true);
        $('#notacreditoadd').prop('readonly', true);
        $('#valornotacreditoadd').prop('readonly', true)

        $('#pagototaladd').val('');
        $('#numreciboadd').val('');
        $('#numchequeremesa').val('');
        $('input[name="formapagoadd"]').prop('checked', false);
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
        // $.get("/listardeudas", function (res){
        //     $("#tbcontentdata").html(res);
        // })
    }

