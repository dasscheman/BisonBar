<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class PublicPagesController extends Controller
{
    /**
     * The publicly reachable home page that Google verifies.
     */
    public function info(): View
    {
        return view('info', [
            'organisation' => config('bisonbar.organisation'),
            'contactEmail' => config('bisonbar.contact_email'),
            'scopes' => config('bisonbar.oauth.scopes'),
        ]);
    }

    /**
     * The publicly reachable privacy policy.
     */
    public function privacy(): View
    {
        return view('privacy', [
            'organisation' => config('bisonbar.organisation'),
            'contactEmail' => config('bisonbar.contact_email'),
            'scopes' => config('bisonbar.oauth.scopes'),
            'lastUpdated' => now()->format('d F Y'),
        ]);
    }
}
