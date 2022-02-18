let timeShow = 3000;
function timeShowchange(time){
    timeShow = time;
}
function AlerSuccess(){
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: timeShow
        };
        toastr.success("Registro creado correctamente");
}

function AlerUpdate(){
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: timeShow
        };
        toastr.success("Registro Actualizado correctamente");
}

function AlerBorrar(){
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: timeShow
        };
        toastr.success("Registro borrado correctamente");
}

function AlertConfirmacin(datos){
        toastr.options = {
            closeButton: true,
            progressBar: true,
            showMethod: 'slideDown',
            timeOut: timeShow
        };
        toastr.success(datos);
}


function AlertInformacion(datos){
    toastr.options = {
        closeButton: true,
        progressBar: true,
        showMethod: 'slideDown',
        timeOut: timeShow
    };
    toastr.info(datos);
}

function AlertAbvertencia(datos){
    toastr.options = {
        closeButton: true,
        progressBar: true,
        showMethod: 'slideDown',
        timeOut: timeShow
    };
    toastr.warning(datos);
}

function AlertError(datos){
    toastr.options = {
        closeButton: true,
        progressBar: true,
        showMethod: 'slideDown',
        timeOut: timeShow
    };
    toastr.error(datos);
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
