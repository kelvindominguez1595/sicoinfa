<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeudasAbonos extends Model
{
    use HasFactory;
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
}
