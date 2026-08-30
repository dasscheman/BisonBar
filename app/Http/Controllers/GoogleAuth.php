<?php

namespace App\Http\Controllers;

use App\Mail\EmailTest;
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
        /**
        $attachments = [
            storage_path('app/public/discount.jpg'),
            storage_path('app/public/invoice.pdf'),
        ];
        **/
        $mailable = new EmailTest();
        $gmail = GoogleApi::gmail();
        $gmail->from($mailable->envelope()->from->address, $mailable->envelope()->from->name);
        $gmail->to(config('mail.admin_email'), config('mail.admin_email'));
        //$gmail->cc('sales@example.com');
        //$gmail->bcc('manager@example.com');
        $gmail->subject($mailable->envelope()->subject);
        //$gmail->attachments($attachments);
        $gmail->mailable(new EmailTest());
        $gmail->send();
    }
}
