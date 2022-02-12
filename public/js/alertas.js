function AlerSuccess(){
    setTimeout(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 3000
        };
        toastr.success("Registro creado correctamente");

    }, 10);
}

function AlerUpdate(){
    setTimeout(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 3000
        };
        toastr.success("Registro Actualizado correctamente");
    }, 10);
}

function AlerBorrar(){
    setTimeout(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 3000
        };
        toastr.success("Registro borrado correctamente");

    }, 10);
}

function AlertConfirmacin(datos){
    setTimeout(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 3000
        };
        toastr.success(datos);

    }, 10);
}


function AlertInformacion(datos){
    setTimeout(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 3000
        };
        toastr.info(datos);

    }, 10);
}

function AlertAbvertencia(datos){
    setTimeout(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 3000
        };
        toastr.warning(datos);

    }, 10);
}

function AlertError(datos){
    setTimeout(function() {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: 3000
        };
        toastr.error(datos);

    }, 10);
}

// toast para eliminar
function preloadEliminar(){
    Swal.fire(
        'Borrado!',
        'El registro ha sido borrado',
        'success'
      )
}
function alertaprint(title, data){
    Swal.fire({
        title: title,
        text: data,
        type: "success",
        showCancelButton: false,
        confirmButtonColor: "#00c0ef",
        confirmButtonText: "Aceptar",
        closeOnConfirm: false
    });
}

function erroSwal(data){
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: data,
        //footer: '<a href>Why do I have this issue?</a>'
      })
}
function infoSwal(data){
    Swal.fire({
        icon: 'info',
        title: 'Oops...',
        text: data,
        //footer: '<a href>Why do I have this issue?</a>'
      })
}
function succesSwal(data){
    Swal.fire({
        icon: 'success',
        title: 'Anulación',
        text: data,
        //footer: '<a href>Why do I have this issue?</a>'
      })
}
