<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deudas extends Model
{
    use HasFactory;

    protected $table = 'deudas';
    protected $fillable = [
        'proveedor_id', 'fecha_factura', 'numero_factura', 'tipo_factura', 'estado'
    ];
}
