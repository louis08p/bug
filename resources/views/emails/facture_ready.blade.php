@component('mail::message')
# Bonjour {{ $facture->user->name }},

Votre commande n°{{ $commande->id }} est désormais **prête**.

Vous trouverez en pièce jointe votre facture au format PDF.

Merci pour votre commande !

@component('mail::button', ['url' => url('/')])
Voir le site
@endcomponent

Cordialement,<br>
{{ config('app.name') }}
@endcomponent
