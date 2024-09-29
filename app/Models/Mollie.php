<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mollie extends Model
{
    use HasFactory;

    public string $description = 'Betaling';

    public float $amount = 0.00;

    public $customerId = null;

    public string|null $sequenceType = null;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function payment()
    {
        $payment = new Payment;
        $payment->type_id = PaymentType::TYPE_ideal;
        $payment->status_id = Status::STATUS_ingevoerd;
        $payment->user_id = $this->user->id;
        $payment->add_subtract = Payment::ADDSUBTRACT_ADD;
        $payment->price = number_format((float) $this->amount, 2);
        $payment->save();

        $parameters = [
            'amount' => [
                'currency' => 'EUR',
                'value' => $payment->price, // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            'description' => $this->description,
            'redirectUrl' => route('return.payment', ['payment_id' => $payment->id]),
            'webhookUrl' => route('webhook.mollie'),
            'metadata' => [
                'payment_id' => $payment->id,
            ],
        ];
        if ($this->customerId !== null) {
            $parameters['customerId'] = $this->customerId;
        }

        if ($this->sequenceType !== null) {
            $parameters['sequenceType'] = $this->sequenceType;
        }

        return \Mollie\Laravel\Facades\Mollie::api()->payments->create($parameters);
    }

    public function checkUserMandates()
    {
        $mandates = \Mollie\Laravel\Facades\Mollie::api()->mandates->listFor($this->user->mollie_user_id);

        foreach ($mandates as $key => $mandate) {
            if ($mandate->status === 'valid') {
                return true;
            }
        }
        return false;
    }
}
