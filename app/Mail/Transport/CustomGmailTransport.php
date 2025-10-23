<?php

namespace App\Mail\Transport;

use App\Mail\EmailTest;
use Exception;
use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Mime\MessageConverter;
use InvalidArgumentException;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use TomShaw\GoogleApi\GoogleApi;
use TomShaw\GoogleApi\Models\GoogleToken;

class CustomGmailTransport extends AbstractTransport
{
    /**
     * Create a new Mailchimp transport instance.
     */
    public function __construct()
    {
        parent::__construct();
        if(Auth::guest()) {
            throw new InvalidArgumentException('User is not authenticated');
        }

        $token = GoogleToken::where('user_id', Auth::id())->first();
        if(!$token) {
            throw new InvalidArgumentException('User has not google token');
        }
    }
    public function __toString()
    {
        return 'custom-gmail';
    }

    protected function doSend(SentMessage $message): void
    {
        $gmail = GoogleApi::gmail();
        $gmail->from($message->getOriginalMessage()->getfrom()[0]->getAddress(),$message->getOriginalMessage()->getfrom()[0]->getName());
        foreach($message->getOriginalMessage()->getTo() as $key => $email) {
            if($key === 0) {
                $gmail->to($email->getAddress(), $email->getName()?$email->getName():$email->getAddress());
                continue;
            }
            $message->getOriginalMessage()->addCc($email);
        }

        $gmail->subject($message->getOriginalMessage()->getSubject());
        $gmail->message($message->getOriginalMessage()->getHtmlBody() );
        foreach($message->getOriginalMessage()->getCC() as $cc) {
            $gmail->cc($cc->getAddress());
        }
        foreach($message->getOriginalMessage()->getBcc() as $bcc) {
            $gmail->bcc($bcc->getAddress());
        }

        foreach($message->getOriginalMessage()->getAttachments() as $attachment) {
            $gmail->attachment($attachment->getName());
        }

        $result = $gmail->send();
        if($result->current() !== 'SENT' ) {
            throw new InvalidArgumentException('Error sending email');
        }
    }


}
