<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Librodet extends Model
{
    use HasFactory;
    protected $table = 'librodet';

    protected $fillable = [
        'name'
    ];
}
