<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Google Site Verification
    |--------------------------------------------------------------------------
    |
    | The token from Google Search Console ("Ownership verification" -> HTML
    | tag). It is rendered as a <meta name="google-site-verification"> tag on
    | every page, which proves to Google that bar.debison.nl is owned by the
    | project that requests OAuth verification.
    |
    */

    'google_site_verification' => env('GOOGLE_SITE_VERIFICATION'),

    /*
    |--------------------------------------------------------------------------
    | Public Page Content
    |--------------------------------------------------------------------------
    |
    | Details that are shown on the public /info and /privacy pages. Keeping
    | them here means the legal text can be corrected without touching a
    | Blade template.
    |
    */

    'organisation' => env('LEGAL_ORGANISATION', 'Scoutinggroep De Bison'),

    'contact_email' => env('LEGAL_CONTACT_EMAIL', 'bar@debison.nl'),

    /*
    |--------------------------------------------------------------------------
    | Google OAuth Consent Screen
    |--------------------------------------------------------------------------
    |
    | The application requests a single, narrowly scoped Gmail permission so
    | it can send invoices and payment notifications through the organisation's
    | own Google account. These values are mirrored on the /info and /privacy
    | pages; keep them in sync with the OAuth consent screen in the Google
    | Cloud Console (project: bisonbar-171612).
    |
    */

    'oauth' => [
        'scopes' => [
            'https://www.googleapis.com/auth/gmail.send',
        ],
        'purpose' => 'E-mailen van facturen en betalingsmeldingen via Gmail',
    ],

];
