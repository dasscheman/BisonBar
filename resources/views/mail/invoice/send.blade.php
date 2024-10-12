<x-mail::message>
# Hallo {{$invoice->user->name}}

Hierbij ontvangt je de factuur voor de Bison bar. In de bijlage zie je een gedetaileerd overzicht.


## Betalen
Je kunt op verschillende manieren betalen. Als je me een plezier wilt doen, dan kun je betalen met de link hieronder.
Daarmee kun je een eenmalige IDEAL betaling doen, of een automatisch incasso aanmaken.
Deze betalingen worden direct verwerkt in het systeem en je tegoed wordt direct opgehoogd als de
betaling succesvol is afgerond.

Je kunt ook nog steeds betalen door geld over te maken naar de Barrekening.
Dit heeft echter niet de voorkeur, want hier zit een flinke vertragen in omdat ik die betalingen niet vaker
dan 1 keer per jaar (met de hand) bijwerk.
Bovendien is dit extra werk voor mij :(

**Rood staan**

Je kunt niet meer dan 20 euro rood te staan. Sta je meer dan {{$invoice->user->limit_hard}} euro rood,
dan wordt je account automatisch bevroren, je kunt dan niets meer turven.
Je kunt je account pas weer gebruiken wanneer je betaald hebt.

<x-mail::button :url="$urlPayment" color="success">
    Direct betalen met ideal
</x-mail::button>

<x-mail::button :url="$urlAutoPayment">
    Automatisch ophogen instellen
</x-mail::button>

Als je vragen hebt kun je mailen naar bar@debison.nl

    Thanks,<br>
    {{ config('app.name') }}

    De factuur wordt elke 4 weken automatisch aangemaakt en verzonden.

    @if ($invoice->user->automatic_payment)
        Je maakt gebruik van automatisch ophogen, je tegoed wordt automatisch opgehoogd met @currency($user->mollie_amount)
        <br>
        Hier kun je automatisch ophogen stop zetten of de hoogte van het bedrag wijzigen:
        <x-mail::button :url="$urlEditAutoPayment">
            Automatisch ophogen instellen
        </x-mail::button>
    @else
        Je maakt geen gebruik van automatisch ophogen.
    @endif
</x-mail::message>
