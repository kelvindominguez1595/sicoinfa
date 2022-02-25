<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;
    protected $table = "clientefacturas";

    protected $fillable = [
        'nombres', 'apellidos', 'cliente', 'direccion',
        'nombre_comercial', 'razon_social', 'giro', 'nit', 'dui',
        'email', 'direccion_entrega', 'telefono',
        'condicion_pago', 'num_registro', 'municipio',
        'departamento', 'remision', 'tipo_cliente', 'state',
    ];
    /**
     * TIPOS DE CLIENTE
     * 3 = PROVEEDOR
     * 2 = CONTRIBUYENTE
     * 1 = CLIENTE NORMAL
    */
}
