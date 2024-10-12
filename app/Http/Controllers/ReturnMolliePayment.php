<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class ReturnMolliePayment extends Controller
{
    public function returnBetaling(Request $request)
    {
        // 3 seond sleep om zeker te weten dat de webhook eerst is aangeroepen
        // en de status gezet is.
        sleep(3);
        $payments = Payment::where('payment_key', $request->get('payment_key'))->first();
        if (isset($transactie->mollie_status)) {
            $this->setFlashMessage($transactie->mollie_status);
        } else {
            Yii::$app->session->setFlash('warning', 'Ongeldige transactie, neem contact op met de beheerder.');
        }
        if (! isset(Yii::$app->user->id)) {
            Yii::$app->session->setFlash('primary', 'Log in om je overzicht te bekijken.');
        }

        return view('livewire.return-mollie-payment');
    }
}
