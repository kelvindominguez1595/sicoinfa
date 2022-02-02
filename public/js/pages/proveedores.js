$(document).ready(function (){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#btnnuevo").click(function (){
        // abrir modal
        $("#frmdata").trigger("reset");
        $("#modaldata").modal("show");
        $(".modal-title").text("Nuevo Proveedor");
    })

    $("#frmdata").submit(function (event) {
        let frm = $(this).serialize();
        let id = $("#id").val();
        let btnname = $("#btnmodal").text();
        let route, typ;
        if(btnname == "Actualizar") {
            // metodo para actualizar
            route = '/proveedores/'+id;
            typ = "PUT";
        } else {
            // guardar
            route = '/proveedores';
            typ = "POST";
        }
        $.ajax({
            url: route,
            type: typ,
            dataType: "JSON",
            data: frm,
            success: function (res){
                AlertConfirmacin(res.message);
                $("#frmdata").trigger("reset");
                $("#modaldata").modal("hide");
                setTimeout(function (){
                    location.reload();
                }, 3000);
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

    $(document).on('click', '#btneditar', function (){
        var id = $(this).val();
        $.get('/proveedores/'+ id +'/edit', function (res) {
            // mostrar el modal
            $("#modaldata").modal("show");
            $(".modal-title").text("Editar Proveedor");
            $("#btnmodal").text("Actualizar");
            $("#id").val(res.id);
            $("#cliente").val(res.cliente);
            $("#nombre_comercial").val(res.nombre_comercial);
            $("#razon_social").val(res.razon_social);
            $("#giro").val(res.giro);
            $("#num_registro").val(res.num_registro);
            $("#nit").val(res.nit);
            $("#telefono").val(res.telefono);
            $("#email").val(res.email);
            $("#direccion").val(res.direccion);
            let sta;
            res.state == 1 ? sta = true: sta = false;
            $("#estado").prop("checked", sta);
        })
    });

    // borra debe mostrar un modal y decir que productos afectaria
    $(document).on('click', '#btnborrar', function (){
        var id = $(this).val();
        $.get('/proveedores/'+ id + '/edit', function (res) {
            // mostrar el modal
            $(".modaltitleborrar").text("¿Borrar Proveedor?");
            $("#borrarmodal").modal("show");
            let html = '<div>';
            html += '<div class="text-center text-primary">';
            html += '<i class="fas fa-exclamation-circle fa-9x"></i>';
            html += '</div>';
            html += '<p>';
            html += '<div class="fw-normal text-center">¿Está seguro de borrar el registro? <br> Sí borra el registro no hay forma de volver a recuperarlo</div>';
            html += '</p>';
            html += '</div>';
            $("#contenedor").html(html);
            $("#idite").val(res.id);
            $("#btnborramodal").text("Borrar");
        })
    });
    // si el registro no afecta a otros puede borra el registro
    $("#frmborrardata").submit(function (event){
        let id = $("#idite").val();
        $.ajax({
                url: '/proveedores/'+id,
                type: "DELETE",
                dataType: "JSON",
                data: {
                    "_token": $("meta[name='csrf-token']").attr("content")
                },
                success: function (res) {
                    AlertConfirmacin(res.message);
                    $("#frmborrardata").trigger("reset");
                    $("#borrarmodal").modal("hide");
                    setTimeout(function (){
                        location.reload();
                    }, 3000);
                },
                error: function (err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: '¡Error algo salio mal!'
                    });
                }
            }
        )
        event.preventDefault();
    })
    // PARA DESACTIVAR EL PROVEEDOR
    $(document).on('click', '#btndesactiva', function (){
        var id = $(this).val();
        $.get('/desactivarproveedores/'+ id , function (res) {
            // mostrar el modal
            if(res.message){
                AlertConfirmacin("EL proveedor se ha desactivado");
                setTimeout(function (){
                    location.reload();
                }, 3000);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '¡Error algo salio mal!'
                });
            }
        })
    })
    // PARA LOS DETALLES DEL PROVEEDOR
    $(document).on('click', '#btnver', function (){
        var id = $(this).val();
        $.get('/proveedores/'+ id +'/edit', function (res) {
            // mostrar el modal
            $(".modaltitleborrar").text("Datos del proveedor");
            $("#borrarmodal").modal("show");
            $("#btnborramodal").addClass('d-none');
            let html = '<div>';
                html += '<p>';
                html += '<label class="fs-6 fw-bold">Nombre Comercial:</label><br>';
                html += '<span class="fs-6">'+ res.cliente +'</span>';
                html += '</p>';
                html += '<p>';
                html += '<label class="fs-6 fw-bold">Nombre Negocio:</label><br>';
                html += '<span class="fs-6">'+ res.nombre_comercial +'</span>';
                html += '</p>';
                html += '<p>';
                html += '<label class="fs-6 fw-bold">Giro:</label><br>';
                html += '<span class="fs-6">'+ res.giro +'</span>';
                html += '</p>';
                html += '<p>';
                html += '<label class="fs-6 fw-bold">Teléfono:</label><br>';
                html += '<span class="fs-6">'+ res.telefono +'</span>';
                html += '</p>';
                html += '<p>';
                html += '<label class="fs-6 fw-bold">Correo:</label><br>';
                html += '<span class="fs-6">'+ res.email +'</span>';
                html += '</p>';
                html += '<p>';
                html += '<label class="fs-6 fw-bold">Número de Registro:</label><br>';
                html += '<span class="fs-6">'+ res.num_registro +'</span>';
                html += '</p>';
                html += '<p>';
                html += '<label class="fs-6 fw-bold">NIT:</label><br>';
                html += '<span class="fs-6">'+ res.nit +'</span>';
                html += '</p>';
                html += '<p>';
                html += '<label class="fs-6 fw-bold">Dirección:</label><br>';
                html += '<span class="fs-6">'+ res.direccion +'</span>';
                html += '</p>';
                html += '</div>';
                $("#contenedor").html(html);

        })
    })
});
