<x-mail::message>
# Hallo {{$payment->user->name}}

We hebben een betaling ontvangen en deze is correct verwerkt.
    Gegevens betaling:
    ID: {{$payment->id}}
    Omschrijving: {{$payment->description}}
    Bedrag:  @curency($payment->price)


Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
