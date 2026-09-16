<?php

namespace App\Http\Controllers;

use App\Mail\EmailTest;
use App\Mail\PaymentAnnounce;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use TomShaw\GoogleApi\GoogleApi;
use TomShaw\GoogleApi\GoogleClient;
use Illuminate\Http\Request;

class GoogleAuth extends Controller
{
    public function index(GoogleClient $client)
    {
        return $client->createAuthUrl();
    }

    public function callback(Request $request, GoogleClient $client)
    {
        $authCode = $request->get('code');
        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
        if ($accessToken) {
            $client->setAccessToken($accessToken);
        }

        return redirect()->route('dashboard');
    }

    public function testMail()
    {
        $serviceUser = User::where('email', config('mail.from.address'))->first();
        if (!$serviceUser) {
            Log::warning('molliewebhook: No service user found ');
            throw ValidationException::withMessages(['Geen geldig service user gevonden.']);
        }
        Auth::loginUsingId($serviceUser->id, true);
            Mail::to(config('mail.admin_email'))->send(new EmailTest());

        Auth::logout();
    }
}
