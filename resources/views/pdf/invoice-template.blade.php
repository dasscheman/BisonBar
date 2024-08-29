<html>
    <body>
        <htmlpageheader name="myheader">
             <table cellspacing="0" style="width: 100%; text-align: center; font-size: 14px">
                <tr>
                    <td style="width: 75%;">
                    </td>
                    <td style="width: 25%; color: #444444;">
                        <img style="width: 10%;" src="assets/img/bison-logo.jpg" alt="Logo"><br>
                        Bison bar
                    </td>
                </tr>
            </table>
        </htmlpageheader>

        <htmlpagefooter name="myfooter">
            <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
            Page {PAGENO} of {nb}
            </div>
        </htmlpagefooter>

        <sethtmlpageheader name="myheader" value="on" show-this-page="1" />
        <sethtmlpagefooter name="myfooter" value="on" />
        <table cellspacing="0" style="width: 100%; text-align: left; font-size: 11pt;">
            <tr>
                <td style="width:50%;"></td>
                <td align="right" style="width:14%; ">Email :</td>
                <td style="width:36%">bar@debison.nl</td>
            </tr>
            <tr>
                <td style="width:50%;"></td>
                <td align="right" style="width:14%; ">Rekeningnummer:</td>
                <td style="width:36%">
                  NL35INGB0000707005 <br>
                </td>
            </tr>
            <tr>
                <td style="width:50%;"></td>
                <td style="width:14%; "></td>
                <td style="width:36%">
                  t.n.v. Scoutinggroep De Bison<br>
                </td>
            </tr>
        </table>
        <br>
        <br>
        <i>
            <b>&laquo; Drankrekening &raquo;</b><br>
            Naam: {{$user->name}}><br>
            Email: {{$user->email}}<br>
            Zeist {{ date('d/m/Y')}}
        </i>
        <br>
        <br>
        Beste {{$user->name}},<br>
        <br>
        Bijdeze ontvang je een overzicht van je drankrekening van de afgelopen periode.<br>
        @if($user->total() > 0)
            Gezien je positieve saldo is het op dit moment niet nodig geld
            over te maken naar de drankrekening. Het is ook mogelijk om een
            bedrag op je rekening te zetten als voorschot.
        @endif
        Gelieve het openstaande bedrag overmaken op: <b>NL35INGB0000707005 t.n.v.
        Scoutinggroep De Bison</b>. Vermeld duidelijk je naam!
        <br>
        <br>

        <!-- ITEMS HERE -->
        <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
            <thead>
                <tr>
                    <td width="9%">ref.id</td>
                    <td width="9%">aantal</td>
                    <td width="9%">prijs per stuk</td>
                    <td width="12%">turflijst/ datum</td>
                    <td width="37%">omschrijving</td>
                    <td width="12%">bedrag</td>
                    <td width="12%">totalen</td>
                </tr>
            </thead>
            @if(!$user->talliesNotInvoiced)
                <tr style="border: 1px solid black">
                    <td colspan="7" align="left"><b><i>Geen nieuwe turven!</i></b></td>
                </tr>
            @else
                <tr style="border: 1px solid black">
                    <td colspan="7" align="left"><b><i>Nieuwe turven:</i></b></td>
                </tr>
                @foreach ($user->talliesNotInvoiced as $newTally)
                    <tr>
                        <td align="center">{{ $newTally->id }}</td>
                        <td align="center">{{ $newTally->count }}</td>
                        <td class="cost">-{{ number_format($newTally->assortment->price, 2, ',', ' ') }} &euro;</td>
                        <td align="center">{{ !empty($newTally->tally_list_id)? $newTally->tallyList->serial_number .': ' . $new_turf->datum:'' }}</td>
                        <td align="left">{{ $newTally->assortment->name . ($newTally->status_id === \App\Models\Status::STATUS_herberekend?' (herberkening)':'') }}</td>
                        <td class="cost">-{{number_format($newTally->totaal_prijs, 2, ',', ' ') }} &euro;</td>
                        <td class="cost"></td>
                    </tr>
                @endforeach
                <tr>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td class="blanktotal cost" align="right">Subtotaal turven:</td>
                    <td class="blanktotal cost"></td>
                    <td class="blanktotal cost">-{{ number_format($user->talliesNotInvoiced->sum('price'), 2, ',', ' ') }} &euro;</td>
                </tr>
            @endif
        </table>
        <br>
        <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
            <thead>
                <tr>
                    <td width="9%">ref. id</td>
                    <td width="10%">status</td>
                    <td width="9%">type</td>
                    <td width="12%">turflijst/ datum</td>
                    <td width="36%">omschrijving</td>
                    <td width="12%">bedrag</td>
                    <td width="12%">totalen</td>
                </tr>
            </thead>

{{--            @if (!$new_af_transacties && !$new_bij_transacties && !$new_invalid_transacties)
{{--                <tr style="border: 1px solid black">--}}
{{--                    <td colspan="7" align="left"><b><i>Geen nieuwe transacties!</i></b></td>--}}
{{--                </tr> <?php--}}
{{--            @endif--}}
            @if($user->checkNewExpensesForNewInvoice())
                <tr style="border: 1px solid black">
                    <td colspan="7" align="left"><b><i>Nieuwe declaraties:</i></b></td>
                </tr>
                @foreach ($user->getNewExpensesForNewInvoice as $expense)
                    <tr>
                        <td align="center"> {{ $expense->id}}</td>
                        <td align="center"> {{ $expense->statusText }}</td>
                        <td align="center"> {{ $expense->omschrijving }}</td>
                        <td align="center"> {{ date($expense->datum, 'php:d-M-Y') }}</td>
                        <td align="left"> {{ $expense->omschrijving }}</td>
                        <td class="cost">-{{ number_format($expense->price, 2, ',', ' ') }} &euro;</td>
                        <td class="cost"></td>
                    </tr>
                @endforeach
                <tr>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td class="blanktotal cost" align="right">Subtotaal declaraties:</td>
                    <td class="blanktotal cost"></td>
                    <td class="blanktotal cost">-{{number_format($user->getNewExpensesForNewInvoice->sum('price'), 2, ',', ' ') }} &euro;</td>
                </tr>
            @endif
            @if($user->checkNewPaymentsForNewInvoice(\App\Models\PaymentType::TYPE_ideal))
                <tr style="border: 1px solid black">
                    <td colspan="7" align="left"><b><i>Nieuwe IDEAL betalingen</i></b></td>
                </tr>
                    @foreach ($user->getNewPaymentsForNewInvoice(\App\Models\PaymentType::TYPE_ideal) as $newIdeal)
                        <tr>
                            <td align="center">{{ $newIdeal->id }}</td>
                            <td align="center">{{ $newIdeal->statusText }}</td>
                            <td align="center">{{ $newIdeal->getType()->one()->omschrijving }}</td>
                            <td align="center">{{ date($newIdeal->datum, 'php:d-M-Y') }}</td>
                            <td align="left">{{ $newIdeal->omschrijving }}</td>
                            <td class="cost">{{ number_format($newIdeal->bedrag, 2, ',', ' ') }} &euro;</td>
                            <td class="cost"></td>
                        </tr>
                    @endforeach
                <tr>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td align="center"></td>
                    <td class="blanktotal cost" align="right">Subtotaal transacties bij:</td>
                    <td class="blanktotal cost"></td>
                    <td class="blanktotal cost">{{ number_format($user->getNewPaymentsForNewInvoice(\App\Models\PaymentType::TYPE_ideal)->sum('price'), 2, ',', ' ') }} &euro;</td>
                </tr>
            @endif

{{--            if (!empty($new_invalid_transacties))--}}
{{--                <tr style="border: 1px solid black">--}}
{{--                    <td colspan="7" align="left"><b><i>Dit zijn transactie die (nog) niet mee berekend worden:</i></b></td>--}}
{{--                </tr>--}}
{{--                @foreach ($new_invalid_transacties as $new_invalid_transactie)
{{--                    <tr>--}}
{{--                        <td align="center">{{ $new_invalid_transactie->transacties_id }}</td>--}}
{{--                        <td align="center"><?php--}}
{{--                            echo $new_invalid_transactie->statusText;--}}
{{--                            if (isset($new_invalid_transactie->mollie_status)) {--}}
{{--                                echo ' (';--}}
{{--                                echo $new_invalid_transactie->getMollieStatusText();--}}
{{--                                echo ')';--}}
{{--                            @endif</td>--}}
{{--                        <td align="center">{{ $new_invalid_transactie->getType()->one()->omschrijving }}</td>--}}
{{--                        <td align="center">{{ Yii::$app->setupdatetime->displayFormat($new_invalid_transactie->datum, 'php:d-M-Y') }}</td>--}}
{{--                        <td align="left">{{ $new_invalid_transactie->omschrijving }}</td>--}}
{{--                        <td class="cost">{{ number_format($new_invalid_transactie->bedrag, 2, ',', ' ') }} &euro;</td>--}}
{{--<!--                        <td class="cost"></td>-->--}}
{{--                    </tr>--}}
{{--                    <?php--}}
{{--                }--}}
{{--            @endif--}}

            <!-- END ITEMS HERE -->
            <tr>
                <td class="blanktotal" colspan="4" rowspan="2"></td>
                <td class="totals">Saldo vorige nota:</td>
                <td class="totals"></td>
                <td class="totals cost">{{ number_format($user->total() - $user->totalNotInvoiced(), 2, ',', ' ') }} &euro;</td>
            </tr>

            <tr>
                <td class="totals"><b>Nieuw saldo:</b></td>
                <td class="totals"></td>
                <td class="totals cost"><b>{{ number_format($user->total(), 2, ',', ' ') }} &euro;</b></td>
            </tr>

        </table>
    </body>
</html>
