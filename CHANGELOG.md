# Release Notes

## [v1.0.8] - 2026-10-18
- E-mail versturen omgezet naar Gmail SMTP met het Google App-wachtwoord van `bar@debison.nl`, gelijk aan OV-Montessori.
- Alle login- en Google OAuth/token-logica verwijderd: `custom-gmail` transport, `GoogleAuth`-routes, `AdminTokenStorageAdapter`, `google:gmail-token-refresh`, `config/google-api.php` en de `tomshaw/google-api` dependency.
- Service-user impersonatie (`Auth::loginUsingId`) uit de console-commands en de Mollie-webhook verwijderd; mail versturen werkt nu zonder ingelogde gebruiker of Google-token.
- Achterhaalde Gmail OAuth-toestemming uit de publieke `/info`- en `/privacy`-pagina's en `config/bisonbar.php` verwijderd.

## [v1.0.7] - 2026-09-16
- Set correct transport mailer for backup.

## [v1.0.6] - 2026-09-16
- Issue with test mail.

## [v1.0.5] - 2026-09-16
- Issue with gmail. notification date was not set at null due to email issues.

## [v1.0.3] - 2026-08-30
- Bug, breaking changes issue mollie package.

## [v1.0.1] - 2026-08-30
- update composer en npm

## [v1.0.0] - 2026-08-30

- Backend dependencies bijgewerkt (Laravel Tinker 3.x, Livewire 4.x, Mollie 4.x, Spatie Backup 10.x).
- Frontend tooling geupdatet naar `laravel-vite-plugin` 3.x, Tailwind CSS 3.4 en Vite 8.
- Nieuwe Docker backend-image en entrypoint script voor lokale ontwikkeling, inclusief automatische Composer-installatie, migraties en correcte bestandsrechten.
- Globale Livewire "loading overlay" component toegevoegd en geintegreerd in de hoofd- en gastlayouts; verbeterde laadervaring op het dashboard.
- Oude user-gebaseerde tally create/edit-modals vervangen door correcte tally-formulieren (tallylijst, assortiment, gebruiker, aantal, prijs, type, status) en gekoppeld aan de admin-tallies tabel met create/edit-acties en betere lege-staat teksten.
- Tallies Livewire-tabel uitgebreid met zoeken op gebruikersnaam of tallylijst-serienummer, optioneel tonen van soft-deleted tallies en per-gebruiker filtering voor niet-admins.
- Nieuw `TallyList` model met datum-casting en een admin `TallyListTable` Livewire-component met zoeken, paginatie en CRUD op serienummer en begin/einddatum.
- Tallylijst-admin views bijgewerkt met tally-specifieke teksten, verbeterde labels en ID-gebaseerde `initData` aansturing voor de Livewire-component.
- Nieuwe `google:gmail-token-refresh` console-command toegevoegd op basis van de Google API client en elke 30 minuten ingepland.
- Extra terugkerende console-commands ingepland voor terugkerende controles, het starten van processen en het genereren/versturen van facturen in de nacht.
- Een basis feature test voor de tallies-pagina toegevoegd die de aanwezigheid van het aanmaakformulier en tallylijst-data controleert.
