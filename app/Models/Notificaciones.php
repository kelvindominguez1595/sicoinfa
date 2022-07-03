<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notificaciones extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'notificaciones';
    protected $fillable = [
        'tipo', 'registro_id', 'comentario', 'estado'
    ];
    protected $dates = ['deleted_at'];
}
