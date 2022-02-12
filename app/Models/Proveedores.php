<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    use HasFactory;

    protected $table = 'clientefacturas';

    protected $fillable = [
        'cliente',
        'direccion',
        'nombre_comercial',
        'razon_social',
        'giro',
        'nit',
        'dui',
        'email',
        'direccion_entrega',
        'telefono',
        'condicion_pago',
        'num_registro',
        'municipio',
        'departamento',
        'remision',
        'tipo_cliente',
        'state',
    ];

}
