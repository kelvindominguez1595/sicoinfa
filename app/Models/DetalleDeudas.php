<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleDeudas extends Model
{
    use HasFactory;
    protected $table = 'detalle_deudas';
    protected $fillable = [
        'deudas_id',
        'total_compra',
        'formapago_id',
        'fecha_abonopago',
        'num_documento',
        'num_recibo',
        'abono',
        'saldo',
        'nota_credito',
        'valor_nota',
        'estado',
        'pagototal',
    ];
}
