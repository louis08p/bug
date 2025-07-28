<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'commande_id',
        'montant_total',
        'date_facture',
    ];

    /**
     * Relation : une facture appartient à un utilisateur.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation : une facture est liée à une commande.
     */
    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
    
}
