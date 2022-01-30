<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sucursales extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'branch_offices';
    protected $fillable = [
        'name', 'phone', 'address', 'state'
    ];
    protected $dates = ['deleted_at'];
}
