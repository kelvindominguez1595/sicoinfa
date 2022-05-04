$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    listCardNotificaciones();

    $(document).on('click', '.notification', function (){
       let notify = $(this).data('registro');

        $(".crd_content").parent('a').addClass("holup")
       console.log(notify)
       // $.get("verNotificacion/"+notify, function (res){
       //     $("#content_ver_notificaciones").html(res);
       // });
    });
});

function listCardNotificaciones() {
    $("#contentNote").LoadingOverlay("show");

    $.get("/listCardNotificaciones", function (res) {
        $("#content_notificaciones").html(res);
        $("#contentNote").LoadingOverlay("hide");
    })
}
