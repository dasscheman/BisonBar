# Release Notes

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
