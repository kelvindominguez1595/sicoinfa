<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Productos extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'stocks';
    protected $fillable = [
        'image',
        'code',
        'barcode',
        'name',
        'exempt_iva',
        'stock_min',
        'state',
        'category_det',
        'reference_det',
        'manufacturer_id',
        'category_id',
        'measures_id',
        'description',
    ];

    protected $dates = ['deleted_at'];
}
