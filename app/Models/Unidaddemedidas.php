<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unidaddemedidas extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'measures';
    protected $fillable = [
        'name', 'state'
    ];

    protected $dates = ['deleted_at'];
}
