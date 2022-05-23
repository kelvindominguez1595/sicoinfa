$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#proveedor').select2({
        theme: "bootstrap-5",
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

    $("#fechafacturado").change(function(){
        let val = $(this).val();
        let fechapago = $("#fechapago");

        $.get("/addModdate/"+val, function(res){
            console.log(res.dateforma);
            fechapago.val(res.dateforma);
        });
    });
   
    $('input[type=radio][name=estado]').change(function(){
        let val = $(this).val();
        let conte = $('#contenedorformapago');
        if(val == 'CONTADO') {
            conte.removeClass('d-none');
        } else {
            conte.addClass('d-none');
        }
    })

    // voy a controlar el tipo de pago
    $('input[type=radio][name=formapago]').change(function() {
        if (this.value === 'EFECTIVO') {
            $('#numerocheque').prop('readonly', true);
        } else {
            $('#numerocheque').prop('readonly', false);
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
    // para mostrar el total de la compra en el otro input
    $("#tocomp").keyup(function (){
        $("#totalcompraadd").val($(this).val());
        if($('input:radio[name=estadoadd]:checked').val() == 'PAGADO'){
            $("#pagototaladd").val($(this).val());
            $("#abonoadd").val('0');
            $("#saldopendienteadd").val('0');
            $("#notacreditoadd").val('0');
            $("#valornotacreditoadd").val('0');
        }
    });
    // para hacer la resta del pago de total de la compra
    $("#abonoadd").keyup(function (){
      let totalcompra =  $("#totalcompraadd").val();
      let pagototal =  $("#pagototaladd");
      let saldopendienteadd =  $("#saldopendienteadd");
      let abono = $(this).val();

      if(Number(abono) <= Number(totalcompra)){
        let cal =  Number(totalcompra) - Number(abono);
        pagototal.val('0');
        saldopendienteadd.val(cal);
      }else{
          console.log("se paso el valor del abono "+abono +" al total de la compra "+totalcompra)
      }
    });
    // para quitar el readonly
    $("#aplicarcredito").change(function (){

        if($(this).prop('checked')){
            $('#notacreditoadd').prop('readonly', false);
            $('#valornotacreditoadd').prop('readonly', false);

        } else {
            $('#notacreditoadd').prop('readonly', true);
            $('#valornotacreditoadd').prop('readonly', true);
        }
    })

    // para agregar las filar a la tabla
    $("#btnadd").click(function (e){
        e.preventDefault();
        if(validateInput()){
            /** DATOS DE FACTURA */
            let proveedoradd        = $('#proveedoradd').val();
            let numfacturaadd       = $('#numfacturaadd').val();
            let tipofacturadd       = $('input:radio[name=tipofacturadd]:checked').val();
            let fechafacturaadd     = $('#fechafacturacionadd').val();
            let fechaabonoadd       = $('#fechapagoadd').val();
            let tocomp              = $('#tocomp').val();
            let estadoadd           = $('input:radio[name=estadoadd]:checked').val();
            let formapagoadd        = $('input:radio[name=formapagoadd]:checked').val();
            let numchequeremesa     = $('#numchequeremesa').val();
            /** DATOS DE PRECIO */
           

            let proveedor = $('select[name="proveedoradd"] option:selected').text();

            let rowTable = $('#rowstable');

            let fechafacformated = moment(fechafacturaadd).format('L');
            let fechafacpago = moment(fechaabonoadd).format('L');

            let html = "<tr>";
            html += "<td class='text-center'>";
                html += fechafacformated;
                html += "<input type='hidden' name='proveedor_id[]' value='"+proveedoradd+"'>";
                html += "<input type='hidden' name='fecha_factura[]' value='"+fechafacturaadd+"'>";
                html += "<input type='hidden' name='numero_factura[]' value='"+numfacturaadd+"'>";
                html += "<input type='hidden' name='tipo_factura[]' value='"+tipofacturadd+"'>";
                html += "<input type='hidden' name='estado[]' value='"+estadoadd+"'>";

                html += "<input type='hidden' name='total_compra[]' value='"+totalcompraadd+"'>";
                html += "<input type='hidden' name='forma_pago[]' value='"+formapagoadd+"'>";
                html += "<input type='hidden' name='fecha_abonopago[]' value='"+fechaabonoadd+"'>";

                html += "<input type='hidden' name='num_documento[]' value='"+numchequeremesa+"'>";
                html += "<input type='hidden' name='num_recibo[]' value='"+numreciboadd+"'>";

                html += "<input type='hidden' name='abono[]' value='"+abonoadd+"'>";
                html += "<input type='hidden' name='saldo[]' value='"+saldopendienteadd+"'>";
                html += "<input type='hidden' name='nota_credito[]' value='"+notacreditoadd+"'>";
                html += "<input type='hidden' name='valor_nota[]' value='"+valornotacreditoadd+"'>";
                html += "<input type='hidden' name='pagototal[]' value='"+pagototaladd+"'>";
            html += "</td>";
            html += "<td class='text-center'>"+numfacturaadd+"</td>";
            html += "<td class='text-center'>"+tipofacturadd+"</td>";
            html += "<td class='text-center'>$"+totalcompraadd+"</td>";
            html += "<td class='text-center'>$"+notacreditoadd+"</td>";
            html += "<td class='text-center'>"+valornotacreditoadd+"</td>";
            html += "<td class='text-center'>"+fechafacpago+"</td>";
            html += "<td class='text-center'>"+formapagoadd+"</td>";
            html += "<td class='text-center'>"+numreciboadd+"</td>";
            html += "<td class='text-center'>"+numchequeremesa+"</td>";
            html += "<td class='text-center'>$"+abonoadd+"</td>";
            html += "<td class='text-center'>$"+saldopendienteadd+"</td>";
            html += "<td class='text-center'>$"+pagototaladd+"</td>";
            html += "<td class='text-center'>"+estadoadd+"</td>";
            html += "</tr>";
            rowTable.append(html);
            // limpiamos los query
            clearInpust();
        }else{
            AlertError("Los campos marcados en rojo son OBLIGATORIOS");
        }
    });

    /** GUARDAR LAS FACTURAS */
    $("#frmsavefactura").submit(function (e) {
        e.preventDefault();
        if(validateFrmSave()){
                alert("hola todo bien culo")
                /*let frm = $(this).serialize();
                $.ajax({
                    url: '/guardar_deudas',
                    type: 'POST',
                    dataType: 'JSON',
                    data: frm,
                    success: function (res) {
                        console.log(res);
                        AlertConfirmacin("Se ha guardado correctamente");
                        setTimeout(function (){
                            location.reload();
                        }, 3000);
                    },
                    error: function (err){
                        AlertError("No se pudo realizar esta acción");
                    }
                })*/
            
        } else {
            AlertError("Todos los campos son obligatorios");
        }
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
