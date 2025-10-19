<?php

namespace App\Console\Commands;

use App\Mail\EmailTest;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class TestMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $serviceUser = User::where('email', config('mail.from.address'))->first();
        $this->info('Login user ' . $serviceUser->id);
        Auth::loginUsingId($serviceUser->id, true);
        $this->info('Send test mail');
        $mailable = new EmailTest();
        Mail::to('test@biologenkantoor.nl')->send($mailable);
        $this->info('Logout user ' . $serviceUser->id);
        Auth::logout();
    }
}
