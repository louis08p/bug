<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    public function panier()
{
    return $this->hasMany(Panier::class);
}
// Dans Commande.php
public function user()
{
    return $this->belongsTo(User::class);
}
public function facture() {
    return $this->hasOne(Facture::class);
}


}
