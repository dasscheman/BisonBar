<?php

namespace App\Console\Commands;

use App\Mail\PaymentAnnounce;
use App\Models\Calculations;
use App\Models\Mollie;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckRecuring extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-recuring';

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
        $users = User::whereNull('blocked_at')
            ->where('automatic_payment', TRUE)
            ->whereNotNull('mollie_customer_id')
            ->get();

        $count = 0;
        echo 'volgende automatisch ophogen controleren:';
        foreach ($users as $user) {
            $mollie = new Mollie($user);
            $calculations = new Calculations($user);

            if ($user->total() > $user->rise_limit ) {
                ## "Balans is okey";
                continue;
            }
            if(!$mollie->checkUserMandates()) {
                ## "--Geen mandaat";
                continue;
            }
            // Wanneer een user een pending transactie heeft, dan gaan we niet
            // een nieuwe transactie opstarten.
            if($calculations->pendingPaymentsExists()) {
                ## "--Er loopt al een nog niet afgeronde incasso."
                continue;
            }

            // Wanneer een user een pending transactie heeft, dan gaan we niet
            // een nieuwe transactie opstarten.
            if($user->auto_payment_notice_at != NULL) {
                ## "-Notice is al verstuurd"
                continue;
            }

            Mail::to($user->email)->send(new PaymentAnnounce($user));
            $user->auto_payment_notice_at = now();
            $user->save();
            $count++;

        }
        return $count;
    }
}
