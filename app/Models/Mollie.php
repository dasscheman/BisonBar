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

    public function startPayment()
    {
        $payment = new Payment;
        $payment->type_id = PaymentType::TYPE_ideal;
        $payment->status_id = Status::STATUS_ingevoerd;
        $payment->mollie_status = PaymentType::MOLLIE_STATUS_open;
        $payment->user_id = $this->user->id;
        $payment->add_subtract = Payment::ADDSUBTRACT_ADD;
        $payment->price = number_format((float)$this->amount, 2);
        $payment->description = $this->description;
        $payment->name = $this->name;


        $UniqueQrCode = 99;
        while ($UniqueQrCode == 99) {
            $newqrcode = $this::randomString(22);
            if(!Payment::where('transaction_key', $newqrcode)->exists()){
                $UniqueQrCode = $newqrcode;
            }
        }
        $payment->transaction_key = $UniqueQrCode;
        if($payment->save() ){
            return $payment;
        }
        return false;
    }

    public function payment(Payment $payment)
    {
        $parameters = [
            'amount' => [
                'currency' => 'EUR',
                'value' => $payment->price, // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            'description' => $this->description,
            'redirectUrl' => route('return.payment', ['transaction_key' => $payment->transaction_key]),
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
        $customer = \Mollie\Laravel\Facades\Mollie::api()->customers->get($this->user->mollie_customer_id);
        $mandates = \Mollie\Laravel\Facades\Mollie::api()->mandates->listFor($customer);

        foreach ($mandates as $key => $mandate) {
            if ($mandate->status === 'valid') {
                return true;
            }
        }
        return false;
    }

    public static function randomString($length)
    {
        $chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars), 0, $length);
    }
}
