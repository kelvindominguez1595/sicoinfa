<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Precios extends Model
{
    use HasFactory;

    protected $table = 'precios';
    protected $fillable = [
        'producto_id',
        'costosiniva',
        'costoconiva',
        'ganancia',
        'porcentaje',
        'precioventa',
        'cambio',
    ];


}
