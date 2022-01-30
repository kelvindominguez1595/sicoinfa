<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Almacenes extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'detalle_products';
    protected $fillable = [
        'stock_min',
        'quantity',
        'branch_offices_id',
        'stocks_id',
    ];

    protected $dates = ['deleted_at'];
}
