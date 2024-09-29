<?php

namespace App\Console\Commands;

use App\Mail\InvoiceCheck;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class InvoiceCheckCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:check';

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
        $users = User::all();

        foreach ($users as $user) {
            $invoice = $user->invoices()->orderBy('send_at', 'DESC')->first();
            Mail::to($user->email)->send(new InvoiceCheck($invoice));
        }
    }
}
