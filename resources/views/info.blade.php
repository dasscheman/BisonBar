<x-public-layout
    :title="config('app.name')"
    :description="config('app.name').' is het afreken- en verkoopsysteem van '.$organisation.'. Hier lees je wat de applicatie doet, welke gegevens zij verwerkt en hoe wij die beschermen.'"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="card card-body shadow-blur mb-4">
            <div class="d-flex flex-column align-items-center text-center">
                <x-application-logo class="w-auto h-20 mb-4" />

                <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200 mb-2">
                    {{ config('app.name') }}
                </h1>

                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-3xl mb-0">
                    {{ config('app.name') }} {{ __('is het afreken- en verkoopsysteem van') }} {{ $organisation }}.
                    {{ __('Het is een webapplicatie waarmee leden hun barverplichting voldoen: producten kiezen, een openstaand bedrag zien, online betalen en een factuur ontvangen.') }}
                </p>
            </div>
        </div>

        <div class="card card-body shadow-blur mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">
                {{ __('Waarvoor dient BisonBar?') }}
            </h2>

            <p class="text-gray-700 dark:text-gray-300">
                {{ __('De bar van') }} {{ $organisation }}
                {{ __('draait volledig op vrijwilligers. Om de bar open te houden moeten leden hun uitgaven op de bar doorberekenen. BisonBar is het interne systeem dat daarvoor is gebouwd. De applicatie doet vier dingen:') }}
            </p>

            <div class="row g-3 mt-1">
                <div class="col-md-6 col-xl-3">
                    <div class="card card-body h-100 shadow-blur">
                        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">
                            {{ __('1. Consumptie vastleggen') }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-0">
                            {{ __('Leden en barvrijwilligers registreren per barbeurt welke producten zijn verbruikt. De applicatie rekent dit automatisch om naar een persoonlijk openstaand bedrag.') }}
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card card-body h-100 shadow-blur">
                        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">
                            {{ __('2. Online betalen') }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-0">
                            {{ __('Openstaande bedragen worden voldaan via een beveiligde betaalpagina of automatisch door eenmalig mandaat. De betaling loopt via Mollie; wij ontvangen of bewaren geen volledige kaartgegevens.') }}
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card card-body h-100 shadow-blur">
                        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">
                            {{ __('3. Facturatie') }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-0">
                            {{ __('Na betaling of op verzoek wordt een factuur als PDF opgesteld en per e-mail toegezonden. Barvrijwilligers beheren daarnaast uitgaven, assortimenten en de jaaroverzichten.') }}
                        </p>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="card card-body h-100 shadow-blur">
                        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-200">
                            {{ __('4. E-mailverzending') }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-0">
                            {{ __('Facturen en betalingsmeldingen worden verstuurd via het Gmail-account van de organisatie. Daarvoor vragen wij eenmalig toestemming voor één beperkt Gmail-berichtenrecht.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-body shadow-blur mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">
                {{ __('Toegang tot BisonBar') }}
            </h2>

            <p class="text-gray-700 dark:text-gray-300">
                {{ __('Deze pagina is openbaar en leesbaar zonder account. De applicatie zelf is uitsluitend toegankelijk voor leden van') }} {{ $organisation }}
                {{ __('en barvrijwilligers die door het bestuur zijn toegevoegd. Er is geen open registratie.') }}
            </p>

            <p class="text-gray-700 dark:text-gray-300 mb-0">
                {{ __('Inloggen gebeurt met een e-mailadres en een wachtwoord dat je zelf hebt ingesteld. Wachtwoorden worden in versleutelde vorm opgeslagen en zijn door niemand in leesbare vorm in te zien.') }}
            </p>
        </div>

        <div class="card card-body shadow-blur mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">
                {{ __('Waarom vraagt BisonBar toestemming voor Google?') }}
            </h2>

            <p class="text-gray-700 dark:text-gray-300">
                {{ __('Sommige rollen binnen') }} {{ $organisation }}
                {{ __('moeten namens de organisatie e-mail kunnen versturen, bijvoorbeeld om facturen te verzenden. BisonBar vraagt daarvoor via Google OAuth toestemming voor precies één beperkte bevoegdheid:') }}
            </p>

            <ul class="text-gray-700 dark:text-gray-300">
                @foreach($scopes as $scope)
                    <li>
                        <code class="text-sm">{{ $scope }}</code>
                        &mdash; {{ config('bisonbar.oauth.purpose') }}
                    </li>
                @endforeach
            </ul>

            <p class="text-gray-700 dark:text-gray-300 mb-0">
                {{ __('Met deze toestemming kan de applicatie geen e-mail lezen of wijzigen, en alleen e-mail versturen als dat nodig is voor facturen en betalingsmeldingen. Je kunt de toestemming op elk moment intrekken via je Google-accountinstellingen.') }}
            </p>
        </div>

        <div class="card card-body shadow-blur mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">
                {{ __('Privacy en gegevens') }}
            </h2>

            <p class="text-gray-700 dark:text-gray-300">
                {{ config('app.name') }} {{ __('verwerkt persoonsgegevens van leden die de bar gebruiken, omdat dat noodzakelijk is om consumptie, saldi en facturen bij te houden. Welke gegevens dat precies zijn, hoe lang ze worden bewaard en welke partijen ermee te maken krijgen, staat volledig beschreven in ons privacybeleid.') }}
            </p>

            <p class="mb-0">
                <a href="{{ route('privacy') }}" class="btn bg-gradient-dark btn-md mb-0">
                    {{ __('Lees het privacybeleid') }}
                </a>
            </p>
        </div>

        <div class="card card-body shadow-blur mb-4">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-3">
                {{ __('Contact') }}
            </h2>

            <p class="text-gray-700 dark:text-gray-300 mb-0">
                {{ __('Vragen over') }} {{ config('app.name') }} {{ __('of over de verwerking van je gegevens? Neem contact op via') }}
                <a href="mailto:{{ $contactEmail }}" class="text-primary hover:underline">{{ $contactEmail }}</a>.
            </p>
        </div>
    </div>
</x-public-layout>
