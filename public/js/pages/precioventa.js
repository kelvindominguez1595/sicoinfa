$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#btnshowinfor").click(function () {
        let exist = $('#content').hasClass('d-none');
        let dcontent = $('#content');
        if(exist){
            dcontent.removeClass('d-none');
        }else{
            dcontent.addClass('d-none');
        }
    });

    $("#frmventa").submit(function (e){
        e.preventDefault();

        let frm = $(this).serialize();
        $.ajax({
            url: '/modprecioventa',
            type: 'POST',
            dataType: 'JSON',
            data: frm,
            success: function (res) {
                AlertConfirmacin(res.message);
                setTimeout(function (){
                    //  location.reload();
                    location.href = "/ingresos";
                }, 3000);
            },
            error: function (err) {

            }
        })
    });

});

$(document).on("keyup", ".ganancia", function () {
    let porcenaje   = $(this).parents("tr").find('.porcentaje');
    let preciofinal = $(this).parents("tr").find('.precioventa');
    let costoconiva = $(this).parents("tr").find('.costoconiva');
    let costosiniva = $(this).parents("tr").find('.costosiniva');

    let precioConCosto = 0;
    if(costoconiva.val() == 0 && costosiniva.val() != 0){
        precioConCosto = Number(costosiniva.val()) + (Number(costosiniva.val()) * 0.13);
        costoconiva.val(precioConCosto.toFixed(4));
    } else {
        precioConCosto = costoconiva.val();
    }
    let resultpreciofinal = Number($(this).val()) + Number(precioConCosto); // precio final
    let resulporcentaje = (((resultpreciofinal / precioConCosto) - 1)  * 100); //  porcentaje final
    porcenaje.val(resulporcentaje.toFixed(2));
    preciofinal.val(resultpreciofinal.toFixed(4))

})
$(document).on("keyup", ".porcentaje", function () {
    let preciofinal = $(this).parents("tr").find('.precioventa');
    let costoconiva = $(this).parents("tr").find('.costoconiva');
    let costosiniva = $(this).parents("tr").find('.costosiniva');
    let ganancia    = $(this).parents("tr").find('.ganancia');

    let precioConCosto = 0;
    if(costoconiva.val() == 0 && costosiniva.val() != 0){
        precioConCosto = Number(costosiniva.val()) + (Number(costosiniva.val()) * 0.13);
        costoconiva.val(precioConCosto.toFixed(4));
    } else {
        precioConCosto = costoconiva.val();
    }
    // mostramos el porcentaje de ganancia que tendra
    let resultadoporcentaje = Number(precioConCosto * ($(this).val() / 100))
    ganancia.val(resultadoporcentaje.toFixed(4));
    // sumamos costo con iva mas la ganancia para mostrar la venta final del consumidor3.25
    let precioventa =Number(resultadoporcentaje) + Number(precioConCosto);
    preciofinal.val(precioventa.toFixed(4));
})
$(document).on("keyup", ".precioventa", function () {
    let preciofinal = $(this).parents("tr").find(this);
    let costoconiva = $(this).parents("tr").find('.costoconiva');
    let costosiniva = $(this).parents("tr").find('.costosiniva');
    let porcenaje   = $(this).parents("tr").find('.porcentaje');
    let ganancia    = $(this).parents("tr").find('.ganancia');


    let precioConCosto = 0;
    if(costoconiva.val() == 0 && costosiniva.val() != 0){
        precioConCosto = Number(costosiniva.val()) + (Number(costosiniva.val()) * 0.13);
        costoconiva.val(precioConCosto.toFixed(4));
    } else {
        precioConCosto = costoconiva.val();
    }
    // mostramos el porcentaje de ganancia que tendra
    let resultadoporcentaje = (((preciofinal.val() / precioConCosto) - 1)  * 100)
    let resulporce = precioConCosto == 0 ? 0 : resultadoporcentaje;

    porcenaje.val(resulporce.toFixed(2))
    let resultadoganancia = Number(preciofinal.val() - precioConCosto) ;
    let resulGan = precioConCosto == 0 ? 0 : resultadoganancia;
    ganancia.val(resulGan.toFixed(4));
})
