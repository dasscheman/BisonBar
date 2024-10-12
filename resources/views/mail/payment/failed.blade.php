<x-mail::message>
# Hallo {{$payment->user->name}}
# Foutieve betaling ontvangen

Ik heb een betaling ontvangen die niet is afgerond.
Dat kan zijn omdat je de betaling niet hebt afgerond, als je denkt dat er iets niet goed is gegaan,
neem dan even contact op.

Gegevens betaling:
ID: {{$payment->id}}
Omschrijving: {{$payment->description}}
Status: {{$payment->status()}}
Bedrag:  @curency($payment->price)

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
