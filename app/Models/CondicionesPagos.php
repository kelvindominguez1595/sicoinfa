<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CondicionesPagos extends Model
{
    use HasFactory;

    protected $table = 'condicionespago';
    protected $fillable = [
        'name'
    ];
}
