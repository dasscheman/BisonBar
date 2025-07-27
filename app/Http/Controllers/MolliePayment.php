<?php

namespace App\Http\Controllers;

use App\Mail\FirstRecuring;
use App\Mail\InvoiceSend;
use App\Mail\StartRecuring;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Status;
use App\Models\User;
use App\Models\Calculations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Mollie\Laravel\Facades\Mollie;

class MolliePayment extends Controller
{
    public $paymentAmountOptions = [
        '10.00' => '10 euro',
        '15.00' => '15 euro',
        '25.00' => '25 euro',
        '50.00' => '50 euro',
        '75.00' => '75 euro',
        '100.00' => '100 euro'
        ];

    public function paymentForm(Request $request, $payKey)
    {
        $user = User::findByPayKey($payKey);

        if($user->total() < 0 ) {
            $this->paymentAmountOptions[$user->total()] = $user->total() . 'euro';
        }
        $paymentAmountOptions = $this->paymentAmountOptions;

        return view('livewire.payments.payment', compact('user', 'paymentAmountOptions'));
    }

    public function autoPaymentForm(Request $request, $payKey)
    {
        $user = User::findByPayKey($payKey);
        $paymentAmountOptions = $this->paymentAmountOptions;

        return view('livewire.payments.autopayment', compact('user', 'paymentAmountOptions'));
    }

    public function editAutoPaymentForm(Request $request, $payKey)
    {
        $user = User::findByPayKey($payKey);
        if($user->mollie_customer_id == null){
            abort(404);
        }
        $paymentAmountOptions = $this->paymentAmountOptions;

        return view('livewire.payments.editautopayment', compact('user', 'paymentAmountOptions'));
    }

    public function cancelAutoPayment(Request $request) {
        $user = User::findByPayKey($request->get('payment_key'));
        $user->automatic_payment = false;
        $user->mollie_amount = null;
        $user->auto_payment_notice_at = null;
        $user->mollie_customer_id = null;
        $user->save();
        $message = 'automatisch ophogen is geannuleerd.';
        return view('livewire.payments.finished', compact('message'));
    }

    public function saveEditAutoPayment(Request $request) {
        $user = User::findByPayKey($request->get('payment_key'));
        $user->mollie_amount = $request->get('amount');
        $user->save();
        $message = 'automatisch ophogen is gewijzigd.';
        return view('livewire.payments.finished', compact('message'));
    }

    public function preparePayment(Request $request)
    {
        $user = User::findByPayKey($request->get('pay_key'));

        $mollie = new \App\Models\Mollie($user);
        $mollie->amount = $request->get('amount');
        $mollie->description = 'Ideal betaling';
        $mollie->name = 'Ideal betaling van: ' . $user->name;;
        $paymentModel = $mollie->startPayment();
        $payment = $mollie->payment($paymentModel);

        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function prepareAutoPayment(Request $request)
    {
        $user = User::findByPayKey($request->get('pay_key'));
        $customer = Mollie::api()->customers->create([
            'name'  => $user->name,
            'email' => $user->email,
        ]);

        $user->mollie_customer_id = $customer->id;
        $user->mollie_amount = $request->get('amount');
        $user->automatic_payment = true;
        $user->save();

        $mollie = new \App\Models\Mollie($user);
        $mollie->amount = $user->mollie_amount;
        $mollie->customerId = $user->mollie_customer_id;
        $mollie->sequenceType = 'first';
        $mollie->description = 'Eerste betaling om automatisch ophogen in te stellen.';
        $paymentModel = $mollie->startPayment();
        $payment = $mollie->payment($paymentModel);

        Mail::to($user->email)->send(new FirstRecuring($mollie));
        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }
}
