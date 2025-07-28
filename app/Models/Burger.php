<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Burger extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'prix',
        'description',
        'stock',
        'image',
        'archive', // si tu as ce champ aussi
    ];

    
}
