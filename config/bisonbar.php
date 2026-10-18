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
    | organisation.
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

];
