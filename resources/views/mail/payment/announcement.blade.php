<x-mail::message>
# Hallo {{$user->name}}

Hierbij ontvang een aankondiging dat de bison bar binnen enkele dagen een automatische betaling start.

Deze automatische betaling heb je zelf ingesteld, als je tegoed onder de {{currency($user->rise_limit)}} komt, dan wordt je
tegoed automatisch opgehoogd met {{currency($user->mollie_amount)}}.

Als je dit wilt wijzigen of stoppen, klik dan op onderstaande knop.

Als je deze incasso wilt laten uitvoeren, dan hoef je verder niets te doen.
<x-mail::button :url="$urlEditAutoPayment" color="success">
Automatisch incasso aanpassen.
</x-mail::button>


Thanks,

{{ config('app.name') }}
</x-mail::message>
