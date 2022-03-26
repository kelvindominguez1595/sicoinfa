$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#proveedoradd').select2({
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
    // voy a controlar el tipo de pago
    $('input[type=radio][name=estadoadd]').change(function() {
        if (this.value == 'PAGADO') {
            $('#pagototaladd').val($('#totalcompraadd').val())
            $('#abonoadd').prop('readonly', true);
            $('#saldopendienteadd').prop('readonly', true);
            $("#abonoadd").val('0');
            $("#saldopendienteadd").val('0');
            $("#notacreditoadd").val('0');
            $("#valornotacreditoadd").val('0');
        }
        else if (this.value == 'ABONADO') {
            $('#abonoadd').prop('readonly', false);
            $('#saldopendienteadd').prop('readonly', false);
        }
    });
    // para agregar las filar a la tabla
    $("#btnadd").click(function (e){
        e.preventDefault();
        if(validateInput()){
            /** DATOS DE PRECIO */
            let totalcompraadd      = $('#totalcompraadd').val();
            let abonoadd            = $('#abonoadd').val();
            let saldopendienteadd   = $('#saldopendienteadd').val();
            let notacreditoadd      = $('#notacreditoadd').val();
            let valornotacreditoadd = $('#valornotacreditoadd').val();
            let pagototaladd        = $('#pagototaladd').val();
            let numreciboadd        = $('#numreciboadd').val();
            let numchequeremesa     = $('#numchequeremesa').val();
            let formapagoadd        = $('input:radio[name=formapagoadd]:checked').val();
            /** DATOS DE FACTURA */
            let fechafacturaadd     = $('#fechafacturaadd').val();
            let fechaabonoadd       = $('#fechaabonoadd').val();
            let numfacturaadd       = $('#numfacturaadd').val();
            let proveedoradd        = $('#proveedoradd').val();
            let tipofacturadd       = $('input:radio[name=tipofacturadd]:checked').val();
            let estadoadd           = $('input:radio[name=estadoadd]:checked').val();

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
    $("#frmcuentas").submit(function (e) {
        e.preventDefault();
        let frm = $(this).serialize();
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
        })
    });

    });


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
