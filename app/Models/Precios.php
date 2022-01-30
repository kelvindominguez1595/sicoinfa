<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Precios extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'detalle_price';
    protected $fillable = [
        'quantity', 'cost_s_iva', 'cost_c_iva', 'earn_c_iva', 'earn_porcent', 'sale_price', 'state', 'detalle_stock_id'
    ];

    protected $dates = ['deleted_at'];
}
