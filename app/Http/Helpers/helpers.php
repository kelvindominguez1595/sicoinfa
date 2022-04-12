<?php

use App\Models\Notificaciones;

function verifiedCountState(){
    return Notificaciones::where('estado', 'activo')->count();
}

function listNotification(){
    return Notificaciones::all();
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

        "descripcionpro" => "Histórico de compra de productos",
        "descripciondet" => "Reporte anual DET",
        "descripcionpor" => "Reporte de producto",
        "descripcionren" => "Reporte de rendimiento de ventas",
    ];
    return $data;
}

