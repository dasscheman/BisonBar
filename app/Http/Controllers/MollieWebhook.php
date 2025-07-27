<?php

namespace App\Http\Controllers;

use App\Mail\PaymentFailed;
use App\Mail\PaymentReceived;
use App\Models\Payment;
use App\Models\Status;
use app\models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Mollie\Api\Exceptions\ApiException;
use Mollie\Laravel\Facades\Mollie;

class MollieWebhook extends Controller
{
    public function returnPayment(Request $request)
    {
        sleep(3);
        $payment = Payment::where('transaction_key', $request->get('transaction_key'))->first();
        if (isset($payment->mollie_status)) {
            session()->flash('message', $payment->name . ' ' . $payment->description . ' is ' . $payment->mollieStatus());
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
        Log::info('recieved webhook: ' . $request->post('id'));
        Log::info( $request->all());
        if ($request->post('id') === null) {
            throw ValidationException::withMessages(['Geen geldig betaal token gevonden.']);
        }

        /*
         * Retrieve the payment's current state.
         */
        $payment = Mollie::api()->payments->get($request->post('id'));
        $payment_id = $payment->metadata->payment_id;

        Log::info( $payment->id);
        $model = Payment::where('mollie_id', $request->post('id'))->first();
        if ($payment->id !== $model->mollie_id && $payment_id !== $model->id) {
            Log::info('No payment found ' . $payment->id . ' ' . $model->mollie_id);
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
            Log::error('Could not save  ' . $e);
            throw ValidationException::withMessages([$e->getMessage()]);
        }
    }
}
