$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    loaddata();

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
        $.ajax({
            url: "/loadproducts",
            type: "GET",
            dataType: "JSON",
            data: frm,
            success: function (res){
                $("#tblproductscontent").html(res.data)
                $("#contenpagination").html(res.pagination)
            },
            error: function (err) {
                console.log(err)
            }
        });
    })

});

function loaddata() {
    $.get("/loadproducts", function(res){
        $("#tblproductscontent").html(res.data)
        $("#contenpagination").html(res.pagination)
    })
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

    $.ajax({
        url: '/loadproducts',
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
        }
    })
});
