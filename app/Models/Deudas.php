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
        'proveedor_id', 'fecha_factura', 'numero_factura', 'tipodocumento_id', 'estado'
    ];

    protected $dates = ['deleted_at'];
}
