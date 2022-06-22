<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeudasAbonos extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'deudas_abonos';

    protected $fillable = [
        'deudas_id', 
        'total_pago', 
        'numero_recibo', 
        'documento_id', 
        'numero', 
        'condicionespago_id', 
        'fecha_abono',
        'formapago_id'
    ];
    protected $dates = ['deleted_at'];
}
