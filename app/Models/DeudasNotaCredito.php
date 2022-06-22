<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeudasNotaCredito extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'deudas_notacredito';
    protected $fillable = [
        'deudas_id', 'numero', 'total_pago', 'fecha_notacredito'
    ];
    protected $dates = ['deleted_at'];
}
