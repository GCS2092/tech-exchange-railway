@component('mail::message')
# Code de réinitialisation

Bonjour,

Voici votre code de réinitialisation de mot de passe :

@component('mail::panel')
# {{ $code }}
@endcomponent

Ce code est valable 5 minutes.

Si vous n'êtes pas à l'origine de cette demande, ignorez cet email.

Merci,<br>L'équipe {{ config('app.name') }}
@endcomponent
