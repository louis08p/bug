<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    use HasFactory;

     protected $fillable = [
        'user_id',
        'burger_id',
        'quantite',
        'prix_unitaire', // ajoute si nécessaire
        'commande_id',    // si tu veux aussi manipuler les commandes directement
    ];

    public function burger()
{
    return $this->belongsTo(Burger::class);
}

}
