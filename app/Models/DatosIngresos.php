<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosIngresos extends Model
{
    use HasFactory;
    protected $table = 'datosingresos';

    protected $fillable = [
        'proveedor_id', 'numerofiscal', 'fechafactura', 'fechaingreso'
    ];
}
