<x-mail::message>
#Hi,

    Er is een automatische betaling opgestart voor {{$user->name}}
    Gegevens mollie betaling:
    ID: {{$payment->id}}
    Omschrijving: {{$payment->description}}
    Bedrag:  @curency($payment->price)

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
