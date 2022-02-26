$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#duisearch').inputmask("99999999-9");
    $('#nitsearch').inputmask("9999-999999-999-9");
    $("#searchnit").addClass("d-none");
    $("#btnnuevocliente").click(function () {
        inputMaskDuiNIT();
        removeClassInvalidate();
        $("#exampleModal").modal('show');
        $("#titlemodal").text("Nuevo Cliente");
        $("#tipocliente").val(1); // cliente normal
        $("#connit").addClass("d-none");
    });

    $("#btnnuevocontribuyente").click(function () {
        inputMaskDuiNIT();
        removeClassInvalidate();
        $("#exampleModal").modal('show');
        $("#titlemodal").text("Nuevo Contribuyente");
        $("#tipocliente").val(2); // contribuyente
        $("#connit").removeClass("d-none");
    });
    // guardamos los clientes
    $("#fmrdata").submit(function (e) {
        let frm = $(this).serialize() ;
        let btnname = $("#titlemodal").text();
        let tipocliente = $("#tipocliente").val();
        let route, typ;
        if(btnname == "Actualizar Cliente") {
            route = '/clientes/'+id;
            typ = "PUT";
        } else {
            route = '/clientes';
            typ = "POST";
        }
        $.ajax({
            url: route,
            type: typ,
            dataType: "JSON",
            data: frm,
            success: function (res){
                AlertConfirmacin(res.message);
                inputClear();
                $("#exampleModal").modal("hide");
                tipocliente == 1 ? listclientes() : listcontribuyem()
            },
            error: function (err) {
                if (err.responseJSON.errors.nombres) {
                    $("#nombres").addClass("is-invalid");
                    AlertError("El campo nombre es obligatorio");
                }
                if (err.responseJSON.errors.apellidos) {
                    $("#apellidos").addClass("is-invalid");
                    AlertError("El campo apellido es obligatorio");

                }
            }
        });
        e.preventDefault();
    })
    // para buscar
    $("#frmsearch").submit(function (e){
        e.preventDefault();
        let frm = $(this).serialize();
        let typefrm = $("#frmsearchtype").val()
        let url;
        if(typefrm == 1){
            url = '/clientesList';
        }else{
            url = '/contribuyentesList';
        }
        $.ajax({
            url: url,
            data: frm,
            type: 'GET',
            dataType: 'JSON',
            success: function (data){
                if(typefrm == 1){
                    $("#tblclientes").html(data);
                }else{
                    $("#tblcontribuyente").html(data);
                }

            }
        })
    })
    listclientes(); // obtener los datos de tabla cliente
    listcontribuyem(); // obtener los datos de tabla contribuyentes
    // para saber en que tab estoy
    $('ul li a[data-bs-toggle="tab"]').on('click', function (e) {
        currentTab = e.target;
        if(currentTab.id == "profile-tab"){
            $("#searchnit").removeClass("d-none");
            $("#frmsearchtype").val(2);
        } else {
            $("#searchnit").addClass("d-none");
            $("#frmsearchtype").val(1);
        }

    })
});
// pagination cliente
$(document).on('click', '#cliente .pagination a', function (e){
    e.preventDefault()
    let page = $(this).attr('href').split('page=')[1];
    $.ajax({
        url: '/clientesList',
        data: {page: page},
        type: 'GET',
        dataType: 'JSON',
        success: function (data){
            $("#tblclientes").html(data);
        }
    })
})
// pagination contribuyente
$(document).on('click', '#contribuyente .pagination a', function (e){
    e.preventDefault()
    let page = $(this).attr('href').split('page=')[1];
    $.ajax({
        url: '/contribuyentesList',
        data: {page: page},
        type: 'GET',
        dataType: 'JSON',
        success: function (data){
            $("#tblcontribuyente").html(data);
        }
    })
})

function listclientes(){
    $.get("/clientesList", function (res){
        $("#tblclientes").html(res);
    })
}

function listcontribuyem(){
    $.get("/contribuyentesList", function (res){
        $("#tblcontribuyente").html(res);
    })
}

function inputClear(){
    $('#nombres').val('');
    $('#apellidos').val('');
    $('#dui').val('');
    $('#nit').val('');
    $('#telefono').val('');
    $('#direccion').val('');
}

function removeClassInvalidate(){
    $("#nombres").removeClass("is-invalid");
    $("#apellidos").removeClass("is-invalid");
}

function inputMaskDuiNIT(){
    $('#dui').inputmask("99999999-9");
    $('#nit').inputmask("9999-999999-999-9");
}
