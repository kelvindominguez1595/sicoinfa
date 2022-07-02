<?php

use App\Models\Notificaciones;
use Illuminate\Support\Facades\Auth;
use App\Models\Notificacion_estados;

function verifiedCountState($notificacion_id){
    $res =  Notificacion_estados::where('notificacion_id', $notificacion_id)
        ->where('usuario_id', Auth::user()->id)
        ->first();

    if(!empty($res)){
        $respuesta = $res->estado;
    } else {
        $respuesta = "NO VISTO";
    }
    return $respuesta;
}

function listNotification(){
    return Notificaciones::orderBy('created_at', 'DESC')->take(10)->get();
}

function timeAgo($date) {
    $timestamp = strtotime($date);

    $strTime = array("segundo", "minuto", "hora", "dia", "mes", "año");
    $length = array("60","60","24","30","12","10");

    $currentTime = time();
    if($currentTime >= $timestamp) {
        $diff     = time()- $timestamp;
        for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
            $diff = $diff / $length[$i];
        }
        $diff = round($diff);
        return "Hace " . $diff . " " . $strTime[$i] . "(s)";
    }
}

function generarCodigo($longitud) {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $longitud_caracteres = strlen($caracteres);
    $cadena_aleatoria = '';
    for ($c = 0; $c < $longitud; $c++) {
        $cadena_aleatoria .= $caracteres[random_int(0, $longitud_caracteres - 1)];
    }
    return $cadena_aleatoria;
}

function dataTitlesExcel(){
    $data = [
        "creador" => "Fábrica y Ferretería Arcoiris",
        "titlereportepro" => "Histórico de compras de productos",
        "titlereportedet" => "Reporte Anual DET",
        "titlereportepor" => "Reporte de Producto",
        "titlereporteren" => "Rendimiento",
        "titlerepordeudasP" => "Reporte de Deuda Por Proveedor",
        "titlerepordeudasG" => "Reporte de Deuda General",
        "descripcionpro" => "Histórico de compra de productos",
        "descripciondet" => "Reporte anual DET",
        "descripcionpor" => "Reporte de producto",
        "descripcionren" => "Reporte de rendimiento de ventas",
        "descripciondedudaP" => "Reporte de deudas filtrado por proveedor",
        "descripciondedudaG" => "Reporte de deudas general",
    ];
    return $data;
}

function showFields($name, $arrayData){
    $field = false;
    foreach($arrayData as $item) {
        if($name === $item){
            $field = true;
        }
    }
    return $field;
}

function showPositionTotal($name, $arrayData) {
    $keysRes = 0;
    foreach($arrayData as $key => $val) {
        if($name === $val){
            $keysRes = $key;
        }
    }
    return $keysRes;
}

