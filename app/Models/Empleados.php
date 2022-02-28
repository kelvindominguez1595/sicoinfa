<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleados extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'employees';

    protected $fillable = [
        'codigo',
        'first_name',
        'last_name',
        'email',
        'dui',
        'nit',
        'nup',
        'isss',
        'phone',
        'address',
        'state'
    ];
}
