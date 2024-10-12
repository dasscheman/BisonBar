<?php

namespace App\Console\Commands;

use App\Mail\InvoiceSend;
use app\models\BetalingType;
use App\Models\Invoices;
use app\models\Mollie;
use app\models\User;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class StartRecuring extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:start-recuring';

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
        $users = User::find()
            ->whereIsNull('blocked_at')
            ->where('automatic_payment', TRUE)
            ->whereNotNull('mollie_customer_id')
            ->whereDate('created_at', '<', now()->subDays(5))
            ->get();

        $count = 0;

        echo 'volgende automatisch ophogen controleren:';
        foreach ($users as $user) {
            $mollie = new Mollie($user);

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
            if($user->pendingPaymentsExists()) {
                ## "--Er loopt al een nog niet afgeronde incasso."
                continue;
            }


            $mollie = new \App\Models\Mollie($user);
            $mollie->amount = $user->mollie_amount;
            $mollie->customerId = $user->mollie_customer_id;
            $mollie->sequenceType = 'recurring';
            $mollie->description = 'Automatisch ophogen BisonBar.';
            $payment = $mollie->startPayment();
            if($payment) {
                Mail::send(new \App\Mail\StartRecuring($payment, $user));
                $user->auto_payment_notice_at = NULL;
                $user->save();
                $count++;
            }

        }
        return $count;
    }
}
