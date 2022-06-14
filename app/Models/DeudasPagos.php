<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeudasPagos extends Model
{
    use HasFactory;

    protected $table = 'deudas_pagos';

    protected $fillable = [
        'deudas_id', 
        'total_pago', 
        'numero_recibo', 
        'documento_id', 
        'numero', 
        'condicionespago_id',
        'formapago_id'
    ];
}
