@component('mail::message')
# Bonjour {{ $facture->user->name }},

Votre commande n°{{ $commande->id }} est désormais **prête**.

---

## 🧾 Détail de la commande

@foreach ($paniers as $panier)
- **Burger :** {{ $panier->burger->nom }}
- **Quantité :** {{ $panier->quantite }}
- **Prix Unitaire :** {{ number_format($panier->burger->prix, 2, ',', ' ') }} FCFA
- **Sous-total :** {{ number_format($panier->burger->prix * $panier->quantite, 2, ',', ' ') }} FCFA  
---
@endforeach

**Total TTC :** {{ number_format($facture->montant_total, 2, ',', ' ') }} FCFA

---

Vous trouverez en pièce jointe votre facture au format PDF.

@component('mail::button', ['url' => url('/commandes/' . $commande->id)])
Voir le site
@endcomponent

Merci pour votre commande !

Cordialement,  
{{ config('app.name') }}
@endcomponent
