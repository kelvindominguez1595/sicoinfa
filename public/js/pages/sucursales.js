$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#btnnuevo").click(function () {
        removeClassInvalidate();
        $("#exampleModal").modal('show');
        $("#titlemodal").text("Nueva Sucursal");
        $("#btnnamebutton").text('Guardar');
    });

    // guardamos los empleados
    $("#fmrdata").submit(function (e) {
        let frm = $(this).serialize() ;
        let id = $("#id").val();
        let route, typ;
        let btnname = $("#btnnamebutton").text();
        if(btnname == "Actualizar") {
            route = '/sucursales/'+id;
            typ = "PUT";
        } else {
            route = '/sucursales';
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
        let url = "/sucursales";
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
        url: '/sucursales',
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
    $.get('/sucursales/'+ id + '/edit', function (res){
        $("#exampleModal").modal('show');
        $("#titlemodal").text("Editar Sucursal");
        $('#id').val(res.id);
        $('#name').val(res.name);
        $('#phone').val(res.phone);
        $('#address').val(res.address);

        let state = $('#state');
        if(res.state == 2 || res.state == "" || res.state == null ){
            state.prop('checked', false);
        }else{
            state.prop('checked', true);
        }
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
                url: "sucursales/" + id,
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

$(document).on('click', '#btnclose', function (){
    inputClear();
    $("#exampleModal").modal("hide");
});

function listdata(){
    $.get("/listsubcursal", function (res){
        $("#tblclientes").html(res);
    })
}

function inputClear(){
    $('#name').val('');
    $('#phone').val('');
    $('#address').val('');
}

function removeClassInvalidate(){
    $("#nombres").removeClass("is-invalid");
    $("#apellidos").removeClass("is-invalid");
}
