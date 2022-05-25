<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormasPagos extends Model
{
    use HasFactory;
    
    protected $table = 'formaspagos';
    protected $fillable = [
        'name'
    ];
}
