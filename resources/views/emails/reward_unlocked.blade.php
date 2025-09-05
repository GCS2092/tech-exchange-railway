@component('mail::message')
# Félicitations {{ $user->name }} !

🎉 Grâce à votre fidélité, vous avez effectué plusieurs commandes de 5000 FCFA ou plus.  
Votre prochaine commande vous donne droit à une surprise spéciale ! 🎁

@component('mail::button', ['url' => route('shop.index')])
Faire un achat
@endcomponent

Merci pour votre confiance,<br>
{{ config('app.name') }}
@endcomponent
