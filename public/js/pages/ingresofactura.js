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
            type: 'GET',
            dataType: 'JSON',
            data: form,
            success: function (res){
                AlertConfirmacin("Guardado correctamente el ingreso");
                setTimeout(function (){
                  //  location.reload();
                    location.href = "/modificarPrecioVenta/"+res.factura;
                }, 3000);
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

    $("#frmseachproducto").submit(function (e) {
        e.preventDefault();
        let frm = $(this).serialize();
        $("#tblcontent").html("")
        $("#tblcontent").LoadingOverlay("show");

        $.ajax({
            url: '/buscarProductosIngreso',
            type: 'GET',
            dataType: 'JSON',
            data: frm,
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
    })

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
    let estado      = $("#estado").val();

    let page = $(this).attr('href').split('page=')[1];
    $.ajax({
        url: '/buscarProductosIngreso',
        data: {page: page, codigosearch: codigo, categoriasearch: categoria, marcasearch: marca, productosearch: producto, estado: estado},
        type: 'GET',
        dataType: 'JSON',
        success: function (data){
            $("#tblcontent").html(data);
        }
    })
})

$(document).on('click', '#btnactive', function (){
    let id = $(this).val();
    let type = "update";
    let codigo      = $("#codigosearch").val();
    let categoria   = $("#categoriasearch").val();
    let marca       = $("#marcasearch").val();
    let producto    = $("#productosearch").val();
    let estado      = $("#estado").val();
    // let page = $(this).attr('href').split('page=')[1];
    $("#estado").val(estado == 1 ? 0 : 1)
    $.ajax({
        url: '/buscarProductosIngreso',
        data: {
            codigosearch: codigo,
            categoriasearch: categoria,
            marcasearch: marca,
            productosearch: producto,
            estado: estado,
            type: type,
            id: id
        },
        type: 'GET',
        dataType: 'JSON',
        success: function (data){
            $("#tblcontent").html(data);
            AlertConfirmacin("El estado del producto ha sido cambiado");
        }
    })
});

$(document).on('click', '#btnaddproduct', function (){
    let tblsearch = $("#tbldataselected tbody tr");

    let productoid  = tblsearch.find('.proid');
    let code        = tblsearch.find('.code');
    let marca       = tblsearch.find('.marca');
    let categoria   = tblsearch.find('.categoria');
    let nproducto   = tblsearch.find('.nombreproducto');
    let rowTable    = $('#rowstable');

    $(this).closest('tr').remove(); // esto es para remover el tr seleccionado
    // si se repite mando un alerta que s repite el producto
    if (checkId(nproducto.val())) {
        AlertInformacion("El producto "+nproducto.val()+" ya esta en proceso de ingreso por favor actualice la cantidad manualmente!");
        return false;
    }
    let html = '<tr>';
    // aqui estaran los id del productos
    html += '<td>'+code.val()+'</td>';
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
});
