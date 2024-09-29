<?php

namespace App\Models;

use App\Mail\PaymentError;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Status extends Model
{
    const STATUS_ingevoerd = 1;

    const STATUS_gecontroleerd = 2;

    const STATUS_tercontrole = 3;

    const STATUS_factuur_gegenereerd = 4;

    const STATUS_factuur_verzonden = 5;

    const STATUS_herberekend = 6;

    const STATUS_betaling_gestart = 7;

    const STATUS_wacht_op_betaling = 8;

    const STATUS_teruggestord = 97;

    const STATUS_geannuleerd = 98;

    const STATUS_ongeldig = 99;

    /**
     * Retrieves a list of statussen
     *
     * @return array an array of available statussen.
     */
    public static function getStatusOptions()
    {
        return [
            self::STATUS_ingevoerd => 'Ingevoerd',
            self::STATUS_gecontroleerd => 'Gecontroleerd',
            self::STATUS_tercontrole => 'Tercontrole',
            self::STATUS_factuur_gegenereerd => 'Factuur gegenereerd',
            self::STATUS_factuur_verzonden => 'Factuur verzonden',
            self::STATUS_herberekend => 'Herberekend',
            self::STATUS_betaling_gestart => 'QR code gescand',
            self::STATUS_wacht_op_betaling => 'Betaling gestart',
            self::STATUS_teruggestord => 'Betaling teruggestord',
            self::STATUS_geannuleerd => 'Geannuleerd',
            self::STATUS_ongeldig => 'Ongeldige transactie',
        ];
    }

    /**
     * @return string the status text display
     */
    public function getStatusText()
    {
        $statusOptions = $this->statusOptions;
        if (isset($statusOptions[$this->status])) {
            return $statusOptions[$this->status];
        }

        return "Onbekende status ({$this->status})";
    }

    public static function saveStatussen(&$model, $paymentStatus)
    {
        $model->invoice_id = null;
        $model->deleted_at = null;
        switch ($paymentStatus) {
            case 'open':
                $model->mollie_status = PaymentType::MOLLIE_STATUS_open;
                $model->status = Status::STATUS_ingevoerd;
                break;
            case 'canceled':
                $model->mollie_status = PaymentType::MOLLIE_STATUS_cancelled;
                $model->status = Status::STATUS_geannuleerd;
                break;
            case 'expired':
                $model->mollie_status = PaymentType::MOLLIE_STATUS_expired;
                $model->status = Status::STATUS_ongeldig;
                break;
            case 'failed':
                $model->mollie_status = PaymentType::MOLLIE_STATUS_failed;
                $model->status = Status::STATUS_ongeldig;
                break;
            case 'pending':
                $model->mollie_status = PaymentType::MOLLIE_STATUS_pending;
                $model->status = Status::STATUS_ingevoerd;
                break;
            case 'paid':
                $model->mollie_status = PaymentType::MOLLIE_STATUS_paid;
                $model->status = Status::STATUS_gecontroleerd;
                break;
            case 'refunded':
                $model->mollie_status = PaymentType::MOLLIE_STATUS_refunded;
                $model->status = Status::STATUS_teruggestord;
                break;
        }
        if (! $model->save()) {
            Mail::to(config('mail.admin_email'))->send(new PaymentError($model));
        }
    }
}
