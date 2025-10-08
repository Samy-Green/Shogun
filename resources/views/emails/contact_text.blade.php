NOUVEAU MESSAGE DE CONTACT
==========================

Vous avez reçu un nouveau message de contact via le formulaire de votre site.

Nom: {{ $name }}
Email: {{ $email }}
Sujet: {{ $subject }}

Message:
--------
{{ $messageContent }}

---
Information:
Ce message a été envoyé depuis le formulaire de contact de votre site web.
Vous pouvez répondre directement à cet email pour contacter {{ $name }}.

© {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.