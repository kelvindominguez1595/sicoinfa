$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#duisearch').inputmask("99999999-9");
    $('#nitsearch').inputmask("9999-999999-999-9");
    $('#nupsearch').inputmask("999999999999");
    $('#issssearch').inputmask("999999999");


    $("#btnnuevo").click(function () {
        inputMaskDuiNIT();
        removeClassInvalidate();
        $("#exampleModal").modal('show');
        $("#titlemodal").text("Nuevo Empleado");
    });

    // guardamos los empleados
    $("#fmrdata").submit(function (e) {
        let frm = $(this).serialize() ;
        let id = $("#id").val();
        let route, typ;
        let btnname = $("#btnnamebutton").text();
        if(btnname == "Actualizar") {
            route = '/empleados/'+id;
            typ = "PUT";
        } else {
            route = '/empleados';
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
                listdata()
            },
            error: function (err) {
                if (err.responseJSON.errors.dui) {
                    $("#dui").addClass("is-invalid");
                    AlertError("El campo DUI es obligatorio");
                }
                if (err.responseJSON.errors.nit) {
                    $("#nit").addClass("is-invalid");
                    AlertError("El campo NIT es obligatorio");

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
        let url = "/empleados";
        $.ajax({
            url: url,
            data: frm,
            type: 'GET',
            dataType: 'JSON',
            success: function (data){
                $("#tblclientes").html(data);
            }
        })
    })
    listdata(); // obtener los datos de tabla cliente
});
// pagination cliente
$(document).on('click', '#cliente .pagination a', function (e){
    e.preventDefault()
    let page = $(this).attr('href').split('page=')[1];
    $.ajax({
        url: '/empleados',
        data: {page: page},
        type: 'GET',
        dataType: 'JSON',
        success: function (data){
            $("#tblclientes").html(data);
        }
    })
})

/**
 *  delete and update clientes
 **/
$(document).on('click', '#btnupdaclie', function (){
    let id = $(this).val();
    $("#btnnamebutton").text("Actualizar");
    $.get('/empleados/'+ id + '/edit', function (res){
        $("#exampleModal").modal('show');
        $("#titlemodal").text("Editar Empleado");
        inputMaskDuiNIT();

        $('#codigo').val(res.codigo);
        $('#first_name').val(res.first_name);
        $('#last_name').val(res.last_name);
        $('#email').val(res.email);
        $('#dui').val(res.dui);
        $('#nit').val(res.nit);
        $('#nup').val(res.nup);
        $('#isss').val(res.isss);
        $('#phone').val(res.phone);
        $('#address').val(res.address);
        let state = $('#state');
        if(res.state == 2 || res.state == "" || res.state == null ){
            state.prop('checked', false);
        }else{
            state.prop('checked', true);
        }
        $('#id').val(id);
    });
});

$(document).on('click', '#deleteclie', function (){
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
                url: "empleados/" + id,
                type: "DELETE",
                dataType: "JSON",
                success: function (res) {
                    AlertConfirmacin(res.message);
                    listdata();
                },
                error: function (err) {
                    erroSwal("¡Algo salió mal!");
                }
            });
        }
    });
});

function listdata(){
    $.get("/listdateemp", function (res){
        $("#tblclientes").html(res);
    })
}

function inputClear(){
    $('#first_name').val('');
    $('#last_name').val('');
    $('#email').val('');
    $('#dui').val('');
    $('#nit').val('');
    $('#nup').val('');
    $('#isss').val('');
    $('#telefono').val('');
    $('#codigo').val('');
    $('#address').val('');
}

function removeClassInvalidate(){
    $("#nombres").removeClass("is-invalid");
    $("#apellidos").removeClass("is-invalid");
}

function inputMaskDuiNIT(){
    $('#dui').inputmask("99999999-9");
    $('#nit').inputmask("9999-999999-999-9");
    $('#nup').inputmask("999999999999");
    $('#isss').inputmask("999999999");
}
