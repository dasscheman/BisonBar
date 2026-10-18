<?php

namespace App\Console\Commands;

use App\Mail\EmailTest;
use Illuminate\Console\Command;
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
        $this->info('Send test mail');
        $mailable = new EmailTest();
        Mail::to('test@biologenkantoor.nl')->send($mailable);
    }
}
