<x-mail::message>
# Nieuw bar systeem

Een nieuw barsysteem!!

    Nouja, je gaat er niets van merken,
    enige wat je even moet controleren of het onderstaande overzicht overeenkomt met de laatste
    rekening die je hebt gekregen (zie bijlage).


    Komt dat overeen, dan hoef je verder niets te doen. Zitten er er verschillen in aantallen turven,
    betallingen en/of openstaande bedragen, stuur dan dit mailtje even naar me door.

@if($invoice->tallies()->exists())
## Turven
<x-mail::table>
    | Id            | Naam          | Aantal        | Totaal        |
    | ------------- | :-----------: | ------------: | ------------: |
    @foreach($invoice->tallies as $tally)
    | {{$tally->id}}| {{$tally->assortment->name}} | {{$tally->count}} | {{$tally->price}}     |
    @endforeach
</x-mail::table>
@endif

@if($invoice->payments()->exists())
## Betalingen
<x-mail::table>
    | Id            | Naam          | Aantal        | Totaal        |
    | ------------- | :-----------: | ------------: | ------------: |
    @foreach($invoice->payments as $payment)
        | {{$payment->id}}| {{$payment->name}} | {{$payment->created_at}} | {{$payment->price}}     |
    @endforeach
</x-mail::table>
@endif

## Openstaand: @currency($invoice->user->total()) €

Met vriendelijke groet,<br>
{{ config('app.name') }}
</x-mail::message>
