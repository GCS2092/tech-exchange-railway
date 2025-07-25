@component('mail::message')
# Compte débloqué

Bonjour {{ $user->name }},

Votre compte a été débloqué par un administrateur. Vous pouvez à nouveau accéder à votre espace personnel.

Merci de votre patience.

@endcomponent
