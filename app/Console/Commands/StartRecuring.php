<?php

namespace App\Console\Commands;

use App\Models\Calculations;
use App\Models\Mollie;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        $serviceUser = User::where('email', config('mail.from.address'))->first();
        $this->info('Login user ' . $serviceUser->id);
        Auth::loginUsingId($serviceUser->id, true);

        $users = User::whereNull('blocked_at')
            ->where('automatic_payment', TRUE)
            ->whereNotNull('mollie_customer_id')
            ->whereDate('auto_payment_notice_at', '<', now()->subDays(5))
            ->get();

        $count = 0;

        echo 'volgende automatisch ophogen controleren:';
        foreach ($users as $user) {
            echo $user->name . ' controleren';
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

            echo 'Start payment';
            $mollie = new \App\Models\Mollie($user);
            $mollie->amount = $user->mollie_amount;
            $mollie->customerId = $user->mollie_customer_id;
            $mollie->sequenceType = 'recurring';
            $mollie->description = 'Ideal';
            $mollie->name = 'Automatisch ophogen BisonBar.';
            $paymentModel = $mollie->startPayment();

            if (!$paymentModel) {
                Log::error('Recurring payment could not be created for user ' . $user->id, [
                    'user' => $user->email,
                ]);
                $this->error('-Geen lokale betaling aan te maken');
                continue;
            }

            try {
                $payment = $mollie->payment($paymentModel);
                $paymentModel->mollie_id = $payment->id;
                $paymentModel->save();
                $user->auto_payment_notice_at = NULL;
                $user->save();

                Mail::to($user->email)->queue(new \App\Mail\StartRecuring($paymentModel, $user));
                $count++;
            } catch (\Throwable $e) {
                Log::error('Recurring payment failed for user ' . $user->id, [
                    'user' => $user->email,
                    'payment_id' => $paymentModel->id,
                    'exception' => $e->getMessage(),
                ]);
                $this->error('-Mollie betaling mislukt: ' . $e->getMessage());
            }
        }
        Auth::logout();
        return $count;
    }
}
