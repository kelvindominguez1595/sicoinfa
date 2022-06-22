<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeudasPagos extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'deudas_pagos';

    protected $fillable = [
        'deudas_id', 'presentafactura', 'numero_recibo',  'formapago_id', 'numero',  'condicionespago_id', 'total_pago'
    ];
    protected $dates = ['deleted_at'];
}
