<x-mail::message>
# Hallo {{$user->name}}

Er is een automatische betaling opgestart omdat je bar tegoed laag is.

Gegevens mollie betaling:

ID: {{$payment->id}}

Omschrijving: {{$payment->name}}

Bedrag:  {{currency($payment->price)}}

Als dit niet klopt, wil je dan contact met me opnemen? Dan zetten we het recht.

Thanks,

{{ config('app.name') }}
</x-mail::message>
