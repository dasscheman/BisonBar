<?php

namespace App\Http\Controllers;

use App\Mail\PaymentFailed;
use App\Mail\PaymentReceived;
use App\Models\Payment;
use App\Models\Status;
use app\models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Mollie\Api\Exceptions\ApiException;
use Mollie\Laravel\Facades\Mollie;

class MollieWebhook extends Controller
{
    public function returnPayment(Request $request)
    {
        sleep(3);
        $payment = Payment::find($request->get('payment_id'));
        if (isset($payment->mollie_status)) {
            session()->flash('message', $payment);
        } else {
            session()->flash('message', 'Ongeldige transactie, neem contact op met de beheerder.');
        }

        return view('livewire.payments.return');
    }

    /**
     * @throws ValidationException
     */
    public function webhook(Request $request)
    {
        $mollie = new Mollie;
        if ($request->post('id') === null) {
            throw ValidationException::withMessages(['Geen geldig betaal token gevonden.']);
        }

        /*
         * Retrieve the payment's current state.
         */
        $payment = $mollie->payments->get($request->post('id'));
        $payment_id = $payment->metadata->payment_id;

        $model = Payment::find($payment_id);
        if ($payment->id !== $model->mollie_id) {
            throw ValidationException::withMessages(['The requested id does not correspond the database.']);
        }
        try {
            /*
             * Update the payments in the database.
             */
            Status::saveStatussen($model, $payment->status);
            if ($payment->isPaid() === true) {
                $user = User::find($model->user_id);
                Mail::to($user->email)->send(new PaymentReceived($model));
            } elseif ($payment->isOpen() === false) {
                $user = User::find($model->user_id);
                Mail::to($user->email)->send(new PaymentFailed($model));
            }
        } catch (ApiException $e) {
            throw ValidationException::withMessages([$e->getMessage()]);
        }
    }
}
