$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#updateyear").change(function (){
        let dcont = $("#contentyear");
        if($(this).is(':checked')){
            dcont.removeClass('d-none');
        }else {
            dcont.addClass('d-none');
        }
    })
});
