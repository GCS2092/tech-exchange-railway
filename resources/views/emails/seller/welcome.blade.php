@component('mail::message')
# Bienvenue, {{ $user->name }} !

Votre compte vendeur a été créé avec succès sur notre plateforme.

Vous pouvez dès maintenant accéder à votre espace vendeur, ajouter vos produits, suivre vos ventes et gérer vos commandes.

@component('mail::button', ['url' => url('/vendeur/dashboard')])
Accéder à mon dashboard vendeur
@endcomponent

N'hésitez pas à contacter l'équipe support pour toute question.

Merci et bonne vente !

L'équipe {{ config('app.name') }}
@endcomponent 