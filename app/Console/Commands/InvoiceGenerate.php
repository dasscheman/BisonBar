<?php

namespace App\Console\Commands;

use App\Models\Calculations;
use App\Models\User;
use Illuminate\Console\Command;

class InvoiceGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:generate';

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
        $users = User::whereNull('blocked_at')->get();
        $calculations = new Calculations();

        foreach ($users as $user) {

            // Wanneer een user een autopayment heeft lopen even wachten tot deze is afgerond.
            if($user->auto_payment_notice_at != NULL) {
                ## "-Notice is al verstuurd"
                continue;
            }

            // Wanneer een user een pending transactie heeft,  even wachten tot deze is afgerond.
            if($user->pendingPaymentsExists()) {
                ## "--Er loopt al een nog niet afgeronde incasso."
                continue;
            }

            $calculations->user_id = $user->id;
            $this->info('Check user '.$user->name);
            if (! $calculations->checkForNewInvoice()) {
                continue;
            }

            if ($user->generateNewInvoice()) {
                $this->info('Generated invoice for user '.$user->name);
            }
        }
    }
}
