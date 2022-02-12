$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    // esto me sirve para cargar los listado de select2 con paginacion de 10
    $('#categoria').select2({
        theme: "bootstrap-5",
        placeholder: 'Seleccione...',
        allowClear: true,
        ajax: {
            url: '/list_categorias',
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

    $('#marca').select2({
        theme: "bootstrap-5",
        placeholder: 'Seleccione...',
        allowClear: true,
        ajax: {
            url: '/list_marcas',
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

    $('#medidas').select2({
        theme: "bootstrap-5",
        placeholder: 'Seleccione...',
        allowClear: true,
        ajax: {
            url: '/list_unidaddenedida',
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

    // El listener va asignado al input
    $("#imagen").change(function() {
        readURL(this);
    });

    // para guardar un nuevo producto
    $("#frmnuevo").submit(function (event){
        var form = new FormData($(this)[0]);
        $.ajax({
            url: '/productos',
            type: 'POST',
            dataType: 'JSON',
            data: form,
            contentType: false,
            processData: false,
            success: function (res) {
                AlertConfirmacin(res.message);
                $(location).attr('href','/actualizaringresos/'+res.productoid+'/'+ res.sucursal);
            },
            error: function (err) {
                if(err.responseJSON.errors.code == "The code has already been taken.") {
                    $("#codemessage").text("Este código ya existe por favor escribir uno diferente")
                    $("#code").addClass("is-invalid");
                }

                if(err.responseJSON.errors.code == "The code field is required.") {
                    $("#codemessage").text("El código es obligatorio")
                    $("#code").addClass("is-invalid");
                }
            }
        })
        event.preventDefault();
    });
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            // Asignamos el atributo src a la tag de imagen
            $('#imagenmuestra').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
