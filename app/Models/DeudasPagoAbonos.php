<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeudasPagoAbonos extends Model
{
    use HasFactory;

    protected $table = 'deudas_pagosabonos';

    protected $fillable = [
        'deudas_id', 
        'total_pago', 
        'numero_recibo', 
        'documento_id', 
        'numero', 
        'condicionespago_id', 
        'numerocheque', 
        'fecha_abono',
        'formapago_id'
    ];
}
