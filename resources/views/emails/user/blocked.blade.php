@component('mail::message')
# Compte bloqué

Bonjour {{ $user->name }},

Votre compte a été bloqué par un administrateur pour des raisons de sécurité ou de conformité.

Si vous pensez qu'il s'agit d'une erreur, vous pouvez contacter l'administrateur en cliquant sur le bouton ci-dessous :

@component('mail::button', ['url' => url('/contact-admin?user=' . $user->id)])
Contacter l'administrateur
@endcomponent

Merci de votre compréhension.

@endcomponent
