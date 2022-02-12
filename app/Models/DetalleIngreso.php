<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    use HasFactory;
    protected $table = 'detalle_price';
    protected $fillable = [
        'quantity',
        'cost_s_iva',
        'cost_c_iva',
        'earn_c_iva',
        'earn_porcent',
        'sale_price',
        'state',
        'detalle_stock_id'
    ];
    protected $dates = ['deleted_at'];
}
