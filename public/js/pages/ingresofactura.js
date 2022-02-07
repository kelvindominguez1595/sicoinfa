$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    showTime(); // mostrar fecha y hora actual
    $("#btnadd").click(function (){
        // obtemos los id para darle valor luego
        let rowTable = $('#rowstable');
        let proid = $('#proid').val();
        let nproducto = $('#nombreproducto');
        let marca = $('#marca').val();
        let categoria = $('#categoria').val();
        let unidadmedida = $('#unidadmedida').val();

        let cantidad = $('#cantidad');
        let costosiniva = $('#costosiniva');
        let costototal = $('#costototal').val();
        // si se repite mando un alerta que s repite el producto
        if (checkId(nproducto.val())) {
            AlertInformacion("El producto "+nproducto.val()+" ya esta en proceso de ingreso por favor actualice la cantidad manualmente!");
            return false; }
        if(nproducto.val() == ''){
            AlertError("El producto es obligatorio");
            nproducto.addClass("is-invalid");
        } else if(cantidad.val() == '') {
            AlertError("la cantidad es obligatoria");
            cantidad.addClass("is-invalid");
        } else if(costosiniva.val() == '') {
            AlertError("El costo sin iva es obligatorio");
            costosiniva.addClass("is-invalid");
        } else {

            let html = '<tr>';
            // aqui estaran los id del productos
            html += '<td for="nproducto">';
                html += '<input type="hidden" class=".productid" id="productid" name="productid[]" value="'+proid+'">'+nproducto.val();
            html += '</td>';
            html += '<td>'+marca+'</td>';
            html += '<td>'+categoria+'</td>';
            html += '<td width="20px">';
                html += '<input type="number" class="form-control cant" min="0" id="cant" name="cant[]" value="'+cantidad.val()+'">';
            html += '</td>';
            html += '<td width="120px">';
                html += '<input type="number" class="form-control cotsin" min="0" step="any" id="cotsin" name="cotsin[]" value="'+costosiniva.val()+'">';
            html += '</td>';
            html += '<td width="120px">';
                html += '<input type="number" class="form-control costotal" min="0" step="any" id="costotal" name="costotal[]" value="'+costototal+'" readonly>';
            html += '</td>';
            html += '<td class="text-center"><button  type="button" class="btn btn-danger quitar"><i class="fas fa-trash"></i></button></td>'
            html += '</tr>';
            rowTable.append(html);
            // limpiar
            nproducto.removeClass("is-invalid")
            cantidad.removeClass("is-invalid")
            costosiniva.removeClass("is-invalid")
            // si todo sale bien reseteo los input
            $("#producto_id").empty();
            $("#producto_id").val('').trigger('change');
            nproducto.val('')
            cantidad.val('')
            costosiniva.val('')
            $("#costototal").val('')
            sumarCostoTotalFinal()

        }
    })
    // para borrar el item
    $(document).on("click",".quitar",function (){
        $(this).closest('tr').remove();
        sumarCostoTotalFinal()
    });

    $('#proveedor_id').select2({
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

    $('#producto_id').select2({
        theme: "bootstrap-5",
        placeholder: 'Seleccione...',
        allowClear: true,
        ajax: {
            url: '/listarproductos',
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

    $(document).on("change", "#producto_id", function () {
        let id = $("#producto_id").val();
        $.get("/productoid/"+id, function (res){
            $('#proid').val(res.id)
            $('#nombreproducto').val(res.text)
            $('#marca').val(res.marca)
            $('#categoria').val(res.categoria)
            $('#unidadmedida').val(res.unidademedida)
        })
    })
    // esto es antes de ingresar la cantidad a la tabla
    $(document).on("change", "#cantidad", function () {
        let cantidad = $(this).val();
        let costo = $("#costosiniva").val();
        let res = Number(cantidad) * Number(costo);
        $("#costototal").val(res)
    })
    // esto es antes de ingresa el costo sin iva a la tabla
    $(document).on("change", "#costosiniva", function () {
        let cantidad = $(this).val();
        let costo = $("#cantidad").val();
        let res = Number(cantidad) * Number(costo);
        $("#costototal").val(res)
    })
    // esto es para cuando haga una modificacion en la cantidad de la tabla
    $(document).on("change",".cant",function (){
        let cant = $(this).parents("tr").find('.cant');
        let cotsin = $(this).parents("tr").find('.cotsin');
        let cototal = $(this).parents("tr").find('.costotal');
        // multiplica cantidad por costo
        let res = Number(cant.val()) * Number(cotsin.val());
        cototal.val(res)
        sumarCostoTotalFinal()
    });
    // esto es para cuando haga una modificacion en el costo sin iva
    $(document).on("change",".cotsin",function (){
        let cant = $(this).parents("tr").find('.cant');
        let cotsin = $(this).parents("tr").find('.cotsin');
        let cototal = $(this).parents("tr").find('.costotal');
        // multiplica cantidad por costo
        let res = Number(cant.val()) * Number(cotsin.val());
        cototal.val(res)
        sumarCostoTotalFinal()
    });

});
// para que no se repita el producto
function checkId (id) {
    let ids = document.querySelectorAll('#rowstable td[for="nproducto"]');
    return [].filter.call(ids, td => td.textContent === id).length === 1;
}

// para sumar todos los costos totales del ingreso

function sumarCostoTotalFinal(){
    let total = 0;
    $(".costotal").each(function(){
        total += Number($(this).val());
    });
    let da = "$"+total.toFixed(2);
    $("#result").text(da)
}

function showTime() {
    var fecha = new Date(); //Fecha actual
    var month = fecha.getMonth() + 1; //obteniendo mes
    var day = fecha.getDate(); //obteniendo dia
    var year = fecha.getFullYear(); //obteniendo año
    // hora
    hours = fecha.getHours();
    minutes = fecha.getMinutes();
    seconds = fecha.getSeconds();
    let hora =  fecha.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true })
    if (hours < 10) hours = 0 + hours;
    if (minutes < 10) minutes = "0" + minutes;
    if (seconds < 10) seconds = "0" + seconds;
    $("#fechaingreso").val(day + "-" + month + "-" + year + " " + hora);
    setTimeout("showTime()", 1000);
}

