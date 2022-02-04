$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#btnadd").click(function (){
        // obtemos los id para darle valor luego
        let rowTable = $('#rowstable');

        let html = '<tr>';
        html += '<td >';
        html += '</td>';
        html += '<td>';
        html += '</td>';
        html += '<td>';
        html += '</td>';
        html += '<td>';
        html += '</td>';
        html += '<td>';
        html += '</td>';
        html += '<td>';
        html += '</td>';
        html += '<td><button  type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button></td>'
        html += '</tr>';
        rowTable.append(html);
    })
});
