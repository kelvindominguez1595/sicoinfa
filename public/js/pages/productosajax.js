$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    loaddata();

});

function loaddata() {
    $.get("/loadproducts", function(res){
        $("#tblproductscontent").html(res)
    })
}
