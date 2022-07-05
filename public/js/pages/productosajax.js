$( document ).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loaddata();
    loadlastdata();

    // order title
    $('#codetitle').on('click', function(e){
        e.preventDefault();
        let dataorder = $(this).attr("data-order")
        let router = $(this).attr("data-router")
        let nameorder = $(this).attr("data-nameorder")
        // delete all icons
        $('#barcodeicocontent').html('');
        $('#categoriaicocontent').html('');
        $('#marcaicocontent').html('');
        $('#nombreicocontent').html('');
        // OBTENER VALORES
        let codigo      = $('#codigo').val()
        let codbarra    = $('#codbarra').val()
        let categoria   = $('#categoria').val()
        let marca       = $('#marca').val()
        let nombre      = $('#nombre').val()
        let almacen     = $('#almacen').val()
        let pages       = $('#pages').val()
        let estado      = $('#estado').val()

        let orderby = "";
        $('#orderglobapagination').val(dataorder)
        $('#nameorderglobal').val(nameorder)
        if(dataorder == 'ASC'){
            // debe ordenar de Z hasta la A
            $(this).attr("data-order", "DESC")
            $("#codeicocontent").html('<i class="fas fa-caret-up"></i>')
            orderby = 'DESC'
        } else {
            $(this).attr("data-order", "ASC")
            $("#codeicocontent").html('<i class="fas fa-caret-down"></i>')
            orderby = 'ASC'
        }
        filterdataproduct(orderby, router, nameorder, codigo, codbarra, categoria, marca, nombre, almacen, pages, estado)
    })

    $('#barcodetitle').on('click', function(e){
        e.preventDefault();
        let dataorder = $(this).attr("data-order")
        let router = $(this).attr("data-router")
        let nameorder = $(this).attr("data-nameorder")
        // delete all icons
        $('#codeicocontent').html('');
        $('#categoriaicocontent').html('');
        $('#marcaicocontent').html('');
        $('#nombreicocontent').html('');
        // OBTENER VALORES
        let codigo      = $('#codigo').val()
        let codbarra    = $('#codbarra').val()
        let categoria   = $('#categoria').val()
        let marca       = $('#marca').val()
        let nombre      = $('#nombre').val()
        let almacen     = $('#almacen').val()
        let pages       = $('#pages').val()
        let estado      = $('#estado').val()

        let orderby = "";
        $('#orderglobapagination').val(dataorder)
        $('#nameorderglobal').val(nameorder)
        if(dataorder == 'ASC'){
            // debe ordenar de Z hasta la A
            $(this).attr("data-order", "DESC")
            $("#barcodeicocontent").html('<i class="fas fa-caret-up"></i>')
            orderby = 'DESC'
        } else {
            $(this).attr("data-order", "ASC")
            $("#barcodeicocontent").html('<i class="fas fa-caret-down"></i>')
            orderby = 'ASC'
        }
        filterdataproduct(orderby, router, nameorder, codigo, codbarra, categoria, marca, nombre, almacen, pages, estado)
    })

    $('#categoriatitle').on('click', function(e){
        e.preventDefault();
        let dataorder = $(this).attr("data-order")
        let router = $(this).attr("data-router")
        let nameorder = $(this).attr("data-nameorder")
        // delete all icons
        $('#codeicocontent').html('');
        $('#barcodeicocontent').html('');
        $('#marcaicocontent').html('');
        $('#nombreicocontent').html('');
        // OBTENER VALORES
        let codigo      = $('#codigo').val()
        let codbarra    = $('#codbarra').val()
        let categoria   = $('#categoria').val()
        let marca       = $('#marca').val()
        let nombre      = $('#nombre').val()
        let almacen     = $('#almacen').val()
        let pages       = $('#pages').val()
        let estado      = $('#estado').val()

        let orderby = "";
        $('#orderglobapagination').val(dataorder)
        $('#nameorderglobal').val(nameorder)
        if(dataorder == 'ASC'){
            // debe ordenar de Z hasta la A
            $(this).attr("data-order", "DESC")
            $("#categoriaicocontent").html('<i class="fas fa-caret-up"></i>')
            orderby = 'DESC'
        } else {
            $(this).attr("data-order", "ASC")
            $("#categoriaicocontent").html('<i class="fas fa-caret-down"></i>')
            orderby = 'ASC'
        }
        filterdataproduct(orderby, router, nameorder, codigo, codbarra, categoria, marca, nombre, almacen, pages, estado)

    })

    $('#marcatitle').on('click', function(e){
        e.preventDefault();
        let dataorder = $(this).attr("data-order")
        let router = $(this).attr("data-router")
        let nameorder = $(this).attr("data-nameorder")
        // delete all icons
        $('#codeicocontent').html('');
        $('#barcodeicocontent').html('');
        $('#categoriaicocontent').html('');
        $('#nombreicocontent').html('');
        // OBTENER VALORES
        let codigo      = $('#codigo').val()
        let codbarra    = $('#codbarra').val()
        let categoria   = $('#categoria').val()
        let marca       = $('#marca').val()
        let nombre      = $('#nombre').val()
        let almacen     = $('#almacen').val()
        let pages       = $('#pages').val()
        let estado      = $('#estado').val()

        let orderby = "";
        $('#orderglobapagination').val(dataorder)
        $('#nameorderglobal').val(nameorder)
        if(dataorder == 'ASC'){
            // debe ordenar de Z hasta la A
            $(this).attr("data-order", "DESC")
            $("#marcaicocontent").html('<i class="fas fa-caret-up"></i>')
            orderby = 'DESC'
        } else {
            $(this).attr("data-order", "ASC")
            $("#marcaicocontent").html('<i class="fas fa-caret-down"></i>')
            orderby = 'ASC'
        }
        filterdataproduct(orderby, router, nameorder, codigo, codbarra, categoria, marca, nombre, almacen, pages, estado)
    })

    $('#nombretitle').on('click', function(e){
        e.preventDefault();
        let dataorder = $(this).attr("data-order")
        let router = $(this).attr("data-router")
        let nameorder = $(this).attr("data-nameorder")

        // delete all icons
        $('#codeicocontent').html('');
        $('#barcodeicocontent').html('');
        $('#categoriaicocontent').html('');
        $('#marcaicocontent').html('');
        // OBTENER VALORES
        let codigo      = $('#codigo').val()
        let codbarra    = $('#codbarra').val()
        let categoria   = $('#categoria').val()
        let marca       = $('#marca').val()
        let nombre      = $('#nombre').val()
        let almacen     = $('#almacen').val()
        let pages       = $('#pages').val()
        let estado      = $('#estado').val()

        let orderby = "";
        $('#orderglobapagination').val(dataorder)
        $('#nameorderglobal').val(nameorder)
        if(dataorder == 'ASC'){
            // debe ordenar de Z hasta la A
            $(this).attr("data-order", "DESC")
            $("#nombreicocontent").html('<i class="fas fa-caret-up"></i>')
            orderby = 'DESC'
        } else {
            $(this).attr("data-order", "ASC")
            $("#nombreicocontent").html('<i class="fas fa-caret-down"></i>')
            orderby = 'ASC'
        }
        filterdataproduct(orderby, router, nameorder, codigo, codbarra, categoria, marca, nombre, almacen, pages, estado)
    })

    $("#frmbusquedaproduct").submit(function(event){
        event.preventDefault();
        let frm = $(this).serialize();
        let path = $("#routepath").val();
        $.ajax({
            url: path,
            type: "GET",
            dataType: "JSON",
            data: frm,
            success: function (res){
                $("#tblproductscontent").html(res.data)
                $("#contenpagination").html(res.pagination)
                var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
                var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                    return new bootstrap.Popover(popoverTriggerEl)
                })

                $('.imgzoom').popover({
                    html: true,
                    trigger: 'hover',
                    content: function () {
                        return '<img src="'+$(this).attr('src') + '" width="250" height="250" class="img-fluid" />';
                    }
                });
                loadlastdata();
                metodoArreglarProducto()
            },
            error: function (err) {
                console.log(err)
            }
        });
    })

    $("#btnresetall").on('click', function(){
        $('#codigo').val('')
        $('#codbarra').val('')
        $('#categoria').val('')
        $('#marca').val('')
        $('#nombre').val('')
        loaddata();
        loadlastdata();
        metodoArreglarProducto()
    })
});

function loaddata() {
    let path = $("#routepath").val();
    $.get(path, function(res){
        $("#tblproductscontent").html(res.data)
        $("#contenpagination").html(res.pagination)
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        })

        $('.imgzoom').popover({
            html: true,
            trigger: 'hover',
            content: function () {
                return '<img src="'+$(this).attr('src') + '" width="250" height="250" class="img-fluid" />';
            }
        });
            // para que cambie la imagen y ver la vista previa
            metodoArreglarProducto()
    })

}

function loadlastdata() {
    let routerlast = $("#routerlast").val();
    if(routerlast !== "no"){
        $.get("/loadlastproduct", function(res){
            $("#bodylast").html(res)
        })
    }
}

function filterdataproduct(orderby, router, nameorder, codigo, codbarra, categoria, marca, nombre, almacen, pages, estado){
    $.ajax({
        url: router,
        type: "GET",
        dataType: "JSON",
        data: {
            orderby:    orderby,
            nameorder:  nameorder,
            codigo:     codigo,
            codbarra:   codbarra,
            categoria:  categoria,
            marca:      marca,
            nombre:     nombre,
            almacen:    almacen,
            pages:      pages,
            estado:     estado
        },
        success: function (res){
            $("#tblproductscontent").html(res.data)
            $("#contenpagination").html(res.pagination)
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl)
            })

            $('.imgzoom').popover({
                html: true,
                trigger: 'hover',
                content: function () {
                    return '<img src="'+$(this).attr('src') + '" width="250" height="250" class="img-fluid" />';
                }
            });
            loadlastdata();
            metodoArreglarProducto()
        },
        error: function (err) {
            console.log(err)
        }
    });
}


  // pagination
  $(document).on('click', '#pagination .pagination a', function (e){
    e.preventDefault()
    let page = $(this).attr('href').split('page=')[1];

    let orderby = $('#orderglobapagination').val();
    let nameorder = $('#nameorderglobal').val();

    let codigo      = $('#codigo').val()
    let codbarra    = $('#codbarra').val()
    let categoria   = $('#categoria').val()
    let marca       = $('#marca').val()
    let nombre      = $('#nombre').val()
    let almacen     = $('#almacen').val()
    let pages       = $('#pages').val()
    let estado      = $('#estado').val()
    let path = $("#routepath").val();
    $.ajax({
        url: path,
        data: {
            page:       page,
            nameorder: nameorder,
            orderby:    orderby,
            codigo:     codigo,
            codbarra:   codbarra,
            categoria:  categoria,
            marca:      marca,
            nombre:     nombre,
            almacen:    almacen,
            pages:      pages,
            estado:     estado
        },
        type: 'GET',
        dataType: 'JSON',
        success: function (res){
            $("#tblproductscontent").html(res.data)
            $("#contenpagination").html(res.pagination)
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl)
            })

            $('.imgzoom').popover({
                html: true,
                trigger: 'hover',
                content: function () {
                    return '<img src="'+$(this).attr('src') + '" width="250" height="250" class="img-fluid" />';
                }
            });
            loadlastdata();
            metodoArreglarProducto()
        }
    })
});


$(document).on('click', '#imgzoom', function () {
    var imgsrc = $(this).data('pathimage');
    $('#my_image').attr('src',imgsrc);
    $("#showimagen").modal("show");
});


function metodoArreglarProducto(){
        /// para modificar las cantidades en existencias
        $(document).on('keyup', '.cantidad', function (event) {
            if (event.keyCode === 13) {
                $("#Updated_canti").click();
            }
        });



        $("#Updated_canti").on('click', function () {
            let newFrm = [];
            var idProducto = $("input[name='idProducto[]']");
            for (var i = 0; i < idProducto.length; i++) {
                newFrm.push({ name: 'idProducto[]', value: $(idProducto[i]).val() });
            }
            var update_quantity = $("input[name='update_quantity[]']");
            for (var i = 0; i < update_quantity.length; i++) {
                newFrm.push({ name: 'update_quantity[]', value: $(update_quantity[i]).val() });
            }
            //console.log($.param(newFrm + '<br>'));
            $.ajax({
                data: $.param(newFrm),
                url: "/ajusteproducto",
                type: "POST",
                dataType: 'JSON',
                success: function (data) {
                    if (data.detalle_producto) {
                        AlertConfirmacin('Cantidad actualizado correctamente');
                        location.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '¡Error algo salio mal!'
                        });
                    }

                }
            });
        });

}
