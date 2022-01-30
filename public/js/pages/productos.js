$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // cargamos los select2 
    $('#categoria').select2({
        theme: "bootstrap-5",
        placeholder: 'Seleccione...',
        allowClear: true,
        ajax: {
            url: '/listarcategorias',
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
            url: '/listarmarcas',
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

    $('#medida').select2({
        theme: "bootstrap-5",
        placeholder: 'Seleccione...',
        allowClear: true,
        ajax: {
            url: '/listarmedidas',
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

    $('#categoriadet').select2({
        theme: "bootstrap-5",
        placeholder: 'Seleccione...',
        allowClear: true,
        ajax: {
            url: '/listarcatedet',
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

    $('#librodet').select2({
        theme: "bootstrap-5",
        placeholder: 'Seleccione...',
        allowClear: true,
        ajax: {
            url: '/listarlibrodet',
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

    // para que cambie la imagen y ver la vista previa
    $("#imagen").change(function() {
        readURL(this);
    });  
    
    let catedet = document.querySelector('#categoriadet').dataset.catedet;
    let librodet = document.querySelector('#librodet').dataset.librodet;
    if(catedet !== ''){
        $.get('../../buscaridcatedet/'+catedet, function (res) {            
            $('#categoriadet').append('<option value="'+res.CodigoBienDet+'" selected="selected">'+res.Descripcion+'</option>');
        });
    }
    
    if(librodet !== ''){
        $.get('../../buscaridlibrodet/'+librodet, function (res) {            
            $('#librodet').append('<option value="'+res.CodigoLibroDet+'" selected="selected">'+res.Descripcion+'</option>');
        });
    }
});

// esto sirve para el editor y para visualizar la imagen
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