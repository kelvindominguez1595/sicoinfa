$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#proveedor_id').select2({
        theme: "bootstrap-5",
        placeholder: 'Seleccione...',
        allowClear: true,
        ajax: {
            url: '/list_proveedores',
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


    $('input[type=radio][name=reportetype]').change(function() {
        if ($(this).val() == 'general') {
            $('#contentproveedor').addClass('d-none');
        } else {
            $('#contentproveedor').removeClass('d-none');
        }
    });
});
