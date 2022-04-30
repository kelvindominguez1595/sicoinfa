<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion_estados extends Model
{
    use HasFactory;

    protected $table = 'notificaciones_estados';
    
    protected $fillable = [
        'id', 'notificacion_id', 'usuario_id', 'estado',
    ];
}
