@props(['token' => config('bisonbar.google_site_verification')])

@if($token)
    <meta name="google-site-verification" content="{{ $token }}">
@endif
