<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    const TYPE_previous_debt = 1;
    const TYPE_previous_credit = 2;
    const TYPE_bank_add = 3;
    const TYPE_bank_subtract = 4;
    const TYPE_expenses = 5;
    const TYPE_card_payment = 7;
    const TYPE_ideal = 8;
    const TYPE_ideal_refund = 9;
    const TYPE_direct_payment= 17;

    /**
     * Retrieves a list of statussen
     * @return array an array of available statussen.
     */
//    public function getStatusOptions()
//    {
//
//        return [
//            self::TYPE_ingevoerd => 'Ingevoerd',
//            self::TYPE_gecontroleerd => 'Gecontroleerd',
//            self::TYPE_tercontrole => 'Tercontrole',
//            self::TYPE_factuur_gegenereerd => 'Factuur gegenereerd',
//            self::TYPE_factuur_verzonden => 'Factuur verzonden',
//            self::TYPE_herberekend => 'Herberekend',
//            self::TYPE_betaling_gestart => 'QR code gescand',
//            self::TYPE_wacht_op_betaling => 'Betaling gestart',
//            self::TYPE_teruggestord => 'Betaling teruggestord',
//            self::TYPE_geannuleerd => 'Geannuleerd',
//            self::TYPE_ongeldig => 'Ongeldige transactie',
//        ];
//    }

    /**
     * @return string the status text display
     */
    public function getTypeText()
    {
        $statusOptions = $this->statusOptions;
        if (isset($statusOptions[$this->status])) {
            return $statusOptions[$this->status];
        }
        return "Onbekende status ({$this->status})";
    }
}
