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
        $(".modal-title").text("Nueva Marca");
    })

    $("#frmdata").submit(function (event) {
        let frm = $(this).serialize();
        let id = $("#id").val();
        let btnname = $("#btnmodal").text();
        let route, typ;
        if(btnname == "Actualizar") {
            // metodo para actualizar
            route = '/marcas/'+id;
            typ = "PUT";
        } else {
            // guardar
            route = '/marcas';
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
        $.get('/marcas/'+ id +'/edit', function (res) {
            // mostrar el modal
            $("#modaldata").modal("show");
            $(".modal-title").text("Editar Marca");
            $("#btnmodal").text("Actualizar");
            $("#id").val(res.id);
            $("#name").val(res.name);
        })
    });

    // borra debe mostrar un modal y decir que productos afectaria
    $(document).on('click', '#btnborrar', function (){
        var id = $(this).val();
        $.get('/marcas/'+ id , function (res) {
            // mostrar el modal
            $(".modaltitleborrar").text("¿Borrar marca?");
            $("#borrarmodal").modal("show");
            if(res[0].marcacount > 0) {
                let plural;
                res[0].marcacount == 1 ? plural = "producto": plural = "productos";
                let html = '<div>';
                html += '<div class="text-center text-primary">';
                html += '<i class="fas fa-exclamation-circle fa-9x"></i>';
                html += '</div>';
                html += '<p>';
                html += '<div class="fw-normal">Existe <strong>'+ res[0].marcacount +'</strong> '+plural+' que serán afectados, así que tiene dos opciones:</div>';
                html += '<ol>';
                html += '<li>Actualizar la marca para que afecte a los registros.</li>';
                html += '<li>Cambiar los productos a otra marca</li>';
                html += '</ol>';
                html += '</p>';
                html += '</div>';
                $("#contenedor").html(html);
                $("#btnborramodal").addClass('d-none');
            } else{
                let html = '<div>';
                html += '<div class="text-center text-primary">';
                html += '<i class="fas fa-exclamation-circle fa-9x"></i>';
                html += '</div>';
                html += '<p>';
                html += '<div class="fw-normal text-center">¿Está seguro de borrar el registro? <br> Sí borra el registro no hay forma de volver a recuperarlo</div>';
                html += '</p>';
                html += '</div>';
                $("#btnborramodal").removeClass('d-none');
                $("#contenedor").html(html);
                $("#idite").val(res[0].id);
                $("#btnborramodal").text("Borrar");
            }


        })
    });
    // si el registro no afecta a otros puede borra el registro
    $("#frmborrardata").submit(function (event){
        let id = $("#idite").val();
        $.ajax({
            url: '/marcas/'+id,
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
});
