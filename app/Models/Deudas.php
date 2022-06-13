<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deudas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'deudas';
    
    protected $fillable = [
        'proveedor_id', 'numero_factura', 'documento_id', 'condicionespago_id', 'fecha_factura', 'fecha_pago', 'total_compra'
    ];

    protected $dates = ['deleted_at'];
}
