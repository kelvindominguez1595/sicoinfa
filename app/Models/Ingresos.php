<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingresos extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'detalle_stock';

    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'register_date',
        'quantity',
        'unit_price',
        'state',
        'state_price',
        'stocks_id',
        'clientefacturas_id',
        'datosingresos_id'
    ];

    protected $dates = ['deleted_at'];
}
