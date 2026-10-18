<x-public-layout
    :title="__('Privacybeleid')"
    :description="__('Privacybeleid van '.config('app.name').': welke persoonsgegevens wij verwerken, waarom, hoe lang wij ze bewaren en welke rechten je hebt.')"
>
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="card card-body shadow-blur mb-4">
            <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-3">
                {{ __('Privacybeleid') }} {{ config('app.name') }}
            </h1>

            <p class="text-gray-700 dark:text-gray-300">
                {{ $organisation }} {{ __('is de vereniging die') }} {{ config('app.name') }} {{ __('beheert. ') }}
                {{ config('app.name') }} {{ __('is een interne webapplicatie voor het afrekenen van barverplichtingen en verwerkt persoonsgegevens van leden. Dit privacybeleid legt uit welke gegevens dat zijn, waarom ze worden verwerkt, hoe lang ze worden bewaard en welke rechten je hebt.') }}
            </p>

            <p class="text-sm text-gray-600 dark:text-gray-400 mb-0">
                {{ __('Laatst bijgewerkt:') }} {{ $lastUpdated }}
            </p>
        </div>

        <div class="card card-body shadow-blur mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">1. {{ __('Wie verwerkt je gegevens?') }}</h2>

            <p class="text-gray-700 dark:text-gray-300 mb-0">
                {{ __('Verwerkingsverantwoordelijke: ') }}
                <strong>{{ $organisation }}</strong>,
                {{ __('bereikbaar via ') }}
                <a href="mailto:{{ $contactEmail }}" class="text-primary hover:underline">{{ $contactEmail }}</a>.
                {{ __('Dit privacybeleid geldt voor de applicatie') }} {{ config('app.name') }},
                {{ __('die op ') }}
                <a href="{{ route('info') }}" class="text-primary hover:underline">{{ route('info') }}</a>
                {{ __('wordt gebruikt, en voor het daadwerkelijk inloggen op dat adres.') }}
            </p>        </div>

        <div class="card card-body shadow-blur mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">2. {{ __('Waarom verwerken wij gegevens?') }}</h2>

            <p class="text-gray-700 dark:text-gray-300">
                {{ __('De bar draait op vrijwilligers. Leden moeten hun consumptie op de bar doorberekenen, en zonder registratie van wat iemand heeft verbruikt kan de vereniging niet factureren. ') }}
                {{ config('app.name') }} {{ __('is speciaal gebouwd om die administratie te voeren.') }}
            </p>

            <p class="text-gray-700 dark:text-gray-300">{{ __('Wij verwerken persoonsgegevens uitsluitend voor de volgende doelen:') }}</p>

            <ul class="text-gray-700 dark:text-gray-300">
                <li>{{ __('het toevoegen van verbruikte producten aan je persoonlijke barrekening;') }}</li>
                <li>{{ __('het berekenen en tonen van je openstaand saldo, inclusief een harde limiet en een stijgrens;') }}</li>
                <li>{{ __('het ontvangen en verwerken van betalingen, zodat een openstaand bedrag kan worden voldaan;') }}</li>
                <li>{{ __('het opstellen, versturen en bewaren van facturen;') }}</li>
                <li>{{ __('het beheren van het assortiment, van uitgaven en van de baradministratie door beheerders;') }}</li>
                <li>{{ __('het beveiligen van de toegang tot de applicatie en het voorkomen van misbruik.') }}</li>
            </ul>
        </div>

        <div class="card card-body shadow-blur mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">3. {{ __('Op welke grondslag?') }}</h2>

            <p class="text-gray-700 dark:text-gray-300">{{ __('Wij baseren de verwerking op de volgende grondslagen uit de Algemene verordening gegevensbescherming (AVG):') }}</p>

            <ul class="text-gray-700 dark:text-gray-300">
                <li>
                    <strong>{{ __('Uitvoering van een overeenkomst') }}</strong> &mdash;
                    {{ __('artikel 6, lid 1, onder b AVG. De registratie van je consumptie, je saldo en je facturen is nodig om je barverplichting administratief af te handelen.') }}
                </li>
                <li>
                    <strong>{{ __('Wettelijke verplichting') }}</strong> &mdash;
                    {{ __('artikel 6, lid 1, onder c AVG. Facturen en boekhouding moeten een aantal jaren worden bewaard op basis van de fiscale bewaarplicht.') }}
                </li>
                <li>
                    <strong>{{ __('Gerechtigd belang') }}</strong> &mdash;
                    {{ __('artikel 6, lid 1, onder f AVG. Voor het beveiligen van de applicatie, het voorkomen van fraude en het waarborgen dat de vereniging haar eigen rekeningen kan betalen.') }}
                </li>
            </ul>
        </div>

        <div class="card card-body shadow-blur mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">4. {{ __('Welke gegevens verwerken wij?') }}</h2>

            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ __('Accountgegevens') }}</h3>
            <p class="text-gray-700 dark:text-gray-300">
                {{ __('Naam, e-mailadres, een wachtwoord (in versleutelde vorm), of je e-mailadres is bevestigd, wanneer je voor het laatst hebt ingelogd, je rol binnen de vereniging, of je account is geblokkeerd en het moment waarop je een melding voor automatische betaling ontvangt.') }}
            </p>

            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ __('Barverbruik en saldo') }}</h3>
            <p class="text-gray-700 dark:text-gray-300">
                {{ __('Per verbruik registreren wij welk product je hebt afgenomen, hoeveel stuks, tegen welke prijs en op welke datum. Daaruit wordt je openstaand bedrag berekend. Ook je harde limiet en stijgrens worden bewaard.') }}
            </p>

            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ __('Betalingsgegevens') }}</h3>
            <p class="text-gray-700 dark:text-gray-300">
                {{ __('Wanneer je een bedrag voldaan, slaan wij de status, het bedrag, de datum, een unieke referentie van de betalingsdienst en het bijbehorende kenmerk op. Als je een automatische betaling instelt, slaan wij daarnaast een kenmerk op waarmee wij die betaling kunnen herkennen. Wij slaan nooit volledige betaalkaart- of creditcardnummers op.') }}
            </p>

            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ __('Facturen') }}</h3>
            <p class="text-gray-700 dark:text-gray-300">
                {{ __('Bij het opstellen van een factuur slaan wij je naam, het factuurnummer, de factuurdatum, de bedragen, de factuurregels en de adresgegevens van de vereniging op. Het opgestelde document wordt als PDF opgeslagen en naar je e-mailadres verzonden.') }}
            </p>

            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ __('Technische gegevens') }}</h3>
            <p class="text-gray-700 dark:text-gray-300">
                {{ __('Bij het inloggen en tijdens het gebruik van de applicatie verwerken wij technische gegevens zoals je IP-adres, het type apparaat en de browser die je gebruikt, de tijd van je laatste activiteit en een sessiekenmerk. Dit gebruiken wij uitsluitend om de beveiliging van de applicatie te bewaken.') }}
            </p>

            <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200 mb-2">{{ __('Gegevens die wij niet verwerken') }}</h3>
            <p class="text-gray-700 dark:text-gray-300 mb-0">
                {{ __('Wij verzamelen geen bijzondere categorieën van persoonsgegevens, zoals gezondheidsgegevens, politieke opvattingen, vakbondslidmaatschap of religieuze overtuigingen.') }}
            </p>
        </div>

        <div class="card card-body shadow-blur mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">5. {{ __('Google- en Gmail-toestemming') }}</h2>

            <p class="text-gray-700 dark:text-gray-300">
                {{ __('Bij sommige rollen binnen de vereniging is het nodig om namens') }} {{ $organisation }}
                {{ __('e-mail te kunnen versturen, bijvoorbeeld om facturen te verzenden. Daarom kan') }} {{ config('app.name') }}
                {{ __('via Google OAuth toestemming vragen voor één beperkte bevoegdheid:') }}
            </p>

            <ul class="text-gray-700 dark:text-gray-300">
                @foreach($scopes as $scope)
                    <li><code class="text-sm">{{ $scope }}</code></li>
                @endforeach
            </ul>

            <p class="text-gray-700 dark:text-gray-300">
                {{ __('Met deze toestemming mag') }} {{ config('app.name') }}
                {{ __('uitsluitend e-mail versturen. De applicatie kan geen e-mail lezen, doorzoeken, wijzigen of verwijderen. Van deze bevoegdheid wordt alleen gebruikgemaakt voor het verzenden van facturen en betalingsmeldingen.') }}
            </p>

            <p class="text-gray-700 dark:text-gray-300 mb-0">
                {{ __('Het toestemmingskenmerk en de geldigheidsduur worden opgeslagen in het account van de betreffende gebruiker. Je kunt de toestemming op ieder moment intrekken in je Google-account. Daarna kan de applicatie geen e-mail meer versturen totdat opnieuw toestemming wordt gegeven.') }}
            </p>
        </div>

        <div class="card card-body shadow-blur mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">6. {{ __('Met wie delen wij gegevens?') }}</h2>

            <p class="text-gray-700 dark:text-gray-300">
                {{ config('app.name') }} {{ __('verwerkt persoonsgegevens zelf en geeft ze uitsluitend door aan de volgende partijen, uitsluitend voor de hierboven genoemde doelen:') }}
            </p>

            <div class="table-responsive mt-3">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('Partij') }}</th>
                            <th scope="col">{{ __('Gegevens') }}</th>
                            <th scope="col">{{ __('Doel') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Mollie B.V.</td>
                            <td>{{ __('naam, e-mailadres, betaalbedrag en een unieke betaalreferentie') }}</td>
                            <td>{{ __('het verwerken van betalingen') }}</td>
                        </tr>
                        <tr>
                            <td>Google Ireland Limited</td>
                            <td>{{ __('e-mailadres, factuurgegevens en het toestemmingskenmerk') }}</td>
                            <td>{{ __('het versturen van facturen en betalingsmeldingen via Gmail') }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Hosting- en back-upprovider') }}</td>
                            <td>{{ __('de volledige inhoud van de applicatie, inclusief back-ups') }}</td>
                            <td>{{ __('het hosten en veilig back-uppen van de applicatie') }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Barvrijwilligers en beheerders van de vereniging') }}</td>
                            <td>{{ __('naam, verbruik, saldo en facturen') }}</td>
                            <td>{{ __('de baradministratie voeren') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <p class="text-gray-700 dark:text-gray-300 mt-3 mb-0">
                {{ __('Wij verkopen geen persoonsgegevens en verstrekken ze niet aan partijen die er commercieel gebruik van willen maken. Ook maken wij geen gebruik van profilering of geautomatiseerde besluitvorming die rechtsgevolgen voor je heeft.') }}
            </p>
        </div>

        <div class="card card-body shadow-blur mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">7. {{ __('Bewaartermijnen') }}</h2>

            <ul class="text-gray-700 dark:text-gray-300">
                <li>
                    <strong>{{ __('Accountgegevens') }}</strong> &mdash;
                    {{ __('zolang je lid bent van') }} {{ config('app.name') }} {{ __('en tot twee jaar na het opheffen van je account, zodat een foutieve afschrijving nog kan worden hersteld.') }}
                </li>
                <li>
                    <strong>{{ __('Barverbruik en saldo') }}</strong> &mdash;
                    {{ __('zolang je account actief is, daarna maximaal zeven jaar, omdat deze gegevens onderdeel zijn van de boekhouding van de vereniging.') }}
                </li>
                <li>
                    <strong>{{ __('Facturen') }}</strong> &mdash;
                    {{ __('minimaal zeven jaar, conform de fiscale bewaarplicht. Ook als je account later wordt verwijderd, blijft de factuur dus bestaan.') }}
                </li>
                <li>
                    <strong>{{ __('Betalingsgegevens') }}</strong> &mdash;
                    {{ __('zeven jaar voor de administratieve en fiscale verplichtingen van de vereniging.') }}
                </li>
                <li>
                    <strong>{{ __('Sessie- en technische gegevens') }}</strong> &mdash;
                    {{ __('maximaal enkele maanden na je laatste bezoek; de sessie zelf verloopt automatisch.') }}
                </li>
                <li>
                    <strong>{{ __('Back-ups') }}</strong> &mdash;
                    {{ __('een korte, roterende bewaartermijn, zodat herstel mogelijk is zonder dat oude gegevens onbeperkt blijven staan.') }}
                </li>
            </ul>
        </div>

        <div class="card card-body shadow-blur mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">8. {{ __('Cookies en vergelijkbare technieken') }}</h2>

            <p class="text-gray-700 dark:text-gray-300">
                {{ config('app.name') }} {{ __('plaatst zelf geen tracking- of advertentiecookies. Er worden uitsluitend technisch noodzakelijke cookies geplaatst:') }}
            </p>

            <ul class="text-gray-700 dark:text-gray-300">
                <li>
                    <strong>{{ __('Sessiecookie') }}</strong> &mdash;
                    {{ __('bewaart je inlogstatus en voorkomt dat je bij elke pagina opnieuw moet inloggen.') }}
                </li>
                <li>
                    <strong>{{ __('Beveiligingscookie') }}</strong> &mdash;
                    {{ __('beschermt formulieren tegen vervalsing en cross-site aanvallen.') }}
                </li>
                <li>
                    <strong>{{ __('Herinneringscookie') }}</strong> &mdash;
                    {{ __('alleen gebruikt als je bij het inloggen aangeeft ingelogd te blijven.') }}
                </li>
            </ul>

            <p class="text-gray-700 dark:text-gray-300 mb-0">
                {{ __('Wij gebruiken geen analytische diensten, pixels of social media-plug-ins. Je kunt cookies in je browser verwijderen of blokkeren; de applicatie blijft werken, maar je moet dan bij elk bezoek opnieuw inloggen.') }}
            </p>
        </div>

        <div class="card card-body shadow-blur mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">9. {{ __('Beveiliging') }}</h2>

            <p class="text-gray-700 dark:text-gray-300 mb-0">
                {{ config('app.name') }} {{ __('is alleen bereikbaar via een beveiligde verbinding. Wachtwoorden worden met een moderne eenwaardige hash versleuteld opgeslagen en zijn dus niet terug te lezen. Toegang tot de applicatie is beperkt tot toegevoegde leden; er is geen open registratie. Nieuwe accounts kunnen een e-mailadres moeten bevestigen. Daarnaast gelden voor beheerders extra rechten, en worden handelingen van beheerders vastgelegd zodat wij kunnen terugvinden wie wat heeft gedaan.') }}
            </p>
        </div>

        <div class="card card-body shadow-blur mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">10. {{ __('Jouw rechten') }}</h2>

            <p class="text-gray-700 dark:text-gray-300">{{ __('Je hebt het recht om:') }}</p>

            <ul class="text-gray-700 dark:text-gray-300">
                <li>{{ __('je gegevens in te zien (recht van inzage);') }}</li>
                <li>{{ __('je onjuiste gegevens te laten corrigeren (recht van rectificatie);') }}</li>
                <li>{{ __('je gegevens te laten verwijderen (recht op vergetelheid);') }}</li>
                <li>{{ __('de verwerking te beperken (recht van beperking);') }}</li>
                <li>{{ __('je gegevens te ontvangen in een overdraagbaar formaat (recht op dataportabiliteit);') }}</li>
                <li>{{ __('bezwaar te maken tegen de verwerking op grond van gerechtigd belang;') }}</li>
                <li>{{ __('je toestemming in te trekken, bijvoorbeeld die voor Google.') }}</li>
            </ul>

            <p class="text-gray-700 dark:text-gray-300">
                {{ __('Een verzoek hiertoe stuur je naar') }}
                <a href="mailto:{{ $contactEmail }}" class="text-primary hover:underline">{{ $contactEmail }}</a>.
                {{ __('Wij reageren binnen vier weken. Let op: facturen en betaalgegevens moeten wij op basis van de fiscale bewaarplicht bewaren. Die gegevens verwijderen wij dus niet op verzoek, maar zetten ze op een plek waar ze niet meer dagelijks worden gebruikt.') }}
            </p>

            <p class="text-gray-700 dark:text-gray-300 mb-0">
                {{ __('Ben je het niet eens met hoe wij met je gegevens omgaan, laat het ons dan eerst weten. Je hebt daarnaast altijd het recht een klacht in te dienen bij de Autoriteit Persoonsgegevens.') }}
            </p>
        </div>

        <div class="card card-body shadow-blur mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">11. {{ __('Wijzigingen in dit beleid') }}</h2>

            <p class="text-gray-700 dark:text-gray-300 mb-0">
                {{ __('Wij passen dit privacybeleid aan wanneer de applicatie of de wetgeving daar aanleiding toe geeft. De datum bovenaan deze pagina wordt dan aangepast.') }}
            </p>
        </div>

        <div class="card card-body shadow-blur mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">12. {{ __('Contact') }}</h2>

            <p class="text-gray-700 dark:text-gray-300 mb-0">
                {{ $organisation }}<br>
                {{ __('E-mail: ') }}<a href="mailto:{{ $contactEmail }}" class="text-primary hover:underline">{{ $contactEmail }}</a><br>
                {{ __('Website: ') }}<a href="{{ route('info') }}" class="text-primary hover:underline">{{ route('info') }}</a>
            </p>
        </div>
    </div>
</x-public-layout>
