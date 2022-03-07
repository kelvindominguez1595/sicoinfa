<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function porcentaje(Request $request) {
        return view('reportes.porcentaje');
    }
    public function promedio(Request $request) {
        return view('reportes.promedio');
    }
    public function rendimiento(Request $request) {
        return view('reportes.rendimiento');
    }
}
