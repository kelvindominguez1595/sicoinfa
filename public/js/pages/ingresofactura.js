$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#showmodalSearch").click(function (){
        $("#exampleModal").modal("show");
    })
    ///==========================
    showTime(); // mostrar fecha y hora actual
    // $("#btnadd").click(function (){
    //
    // })
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

    // guardar los datos del ingreso
    $("#btnguardar").click(function (event){
        let form = $("#frmdataingresofactura").serialize();
        $.ajax({
            url: '/ingresofactura',
            type: 'POST',
            dataType: 'JSON',
            data: form,
            success: function (res){
                AlertConfirmacin("Guardado correctamente el ingreso");
                /*setTimeout(function (){
                    location.reload();
                }, 3000); */

            },
            error: function (err){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Error algo salio mal!'
                });
            }
        })
        event.preventDefault();
    });

    $("#btnmodalSearch").click(function (){
        let codigo      = $("#codigosearch").val();
        let categoria   = $("#categoriasearch").val();
        let marca       = $("#marcasearch").val();
        let producto    = $("#productosearch").val();

        $("#tblcontent").html("")
        $("#tblcontent").LoadingOverlay("show");

        $.ajax({
            url: '/buscarProductosIngreso',
            type: 'GET',
            dataType: 'JSON',
            data: {codigo: codigo, categoria: categoria, marca: marca, producto: producto},
            success: function (data){
                $("#tblcontent").LoadingOverlay("hide");
                $("#tblcontent").html(data);
            },
            error: function (err){
                $("#tblcontent").LoadingOverlay("hide");
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Error algo salio mal!'
                });
            }
        });
    });
    // seleccionar tr modal
    var pickedup;

    // esto es para cuando haga una modificacion en el costo sin iva
    $(document).on( "click","#tbldataselected tbody tr", function( event ) {
        let productoid = $(this).find('.proid');
        let marca = $(this).find('.marca');
        let categoria = $(this).find('.categoria');
        let nproducto = $(this).find('.nombreproducto');
        let rowTable = $('#rowstable');

        $(this).closest('tr').remove(); // esto es para remover el tr seleccionado
        // si se repite mando un alerta que s repite el producto
        if (checkId(nproducto.val())) {
            AlertInformacion("El producto "+nproducto.val()+" ya esta en proceso de ingreso por favor actualice la cantidad manualmente!");
            return false;
        }
            let html = '<tr>';
            // aqui estaran los id del productos
            html += '<td for="nproducto">';
            html += '<input type="hidden" class=".productid" id="productid" name="productid[]" value="'+productoid.val()+'">'+nproducto.val();
            html += '</td>';
            html += '<td>'+marca.val()+'</td>';
            html += '<td>'+categoria.val()+'</td>';
            html += '<td width="20px">';
            html += '<input type="number" class="form-control cant" min="0" id="cant" name="cant[]" value="0">';
            html += '</td>';
            html += '<td width="120px">';
            html += '<input type="number" class="form-control cotsin" min="0" step="any" id="cotsin" name="cotsin[]" value="0">';
            html += '</td>';
            html += '<td width="120px">';
            html += '<input type="number" class="form-control costotal" min="0" step="any" id="costotal" name="costotal[]" value="0" readonly>';
            html += '</td>';
            html += '<td class="text-center"><button  type="button" class="btn btn-danger quitar"><i class="fas fa-trash"></i></button></td>'
            html += '</tr>';
            rowTable.append(html);
        pickedup = $( this );
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

$(document).on('click', '#paginationmodal .pagination a', function (e){
    e.preventDefault()
    let codigo      = $("#codigosearch").val();
    let categoria   = $("#categoriasearch").val();
    let marca       = $("#marcasearch").val();
    let producto    = $("#productosearch").val();

    let page = $(this).attr('href').split('page=')[1];
    $.ajax({
        url: '/buscarProductosIngreso',
        data: {page: page, codigo: codigo, categoria: categoria, marca: marca, producto: producto},
        type: 'GET',
        dataType: 'JSON',
        success: function (data){
            $("#tblcontent").html(data);
        }
    })
})


function dataAddSelected(){
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
}
