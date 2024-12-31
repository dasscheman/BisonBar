<?php

namespace App\Models;

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

    const TYPE_direct_payment = 17;

    const MOLLIE_STATUS_open = 1;

    const MOLLIE_STATUS_cancelled = 2;

    const MOLLIE_STATUS_expired = 3;

    const MOLLIE_STATUS_failed = 4;

    const MOLLIE_STATUS_paid = 5;

    const MOLLIE_STATUS_refunded = 6;

    const MOLLIE_STATUS_pending = 7;

    const MOLLIE_STATUS_paidout = 8;

    /**
     * Retrieves a list of statussen
     *
     * @return array an array of available statussen.
     */
    public static function getMollieStatusOptions()
    {

        return [
            self::MOLLIE_STATUS_open => __('Ingevoerd'),
            self::MOLLIE_STATUS_cancelled => __( 'Gecontroleerd'),
            self::MOLLIE_STATUS_expired => __( 'Tercontrole'),
            self::MOLLIE_STATUS_failed => __( 'Factuur gegenereerd'),
            self::MOLLIE_STATUS_paid => __( 'Factuur verzonden'),
            self::MOLLIE_STATUS_refunded => __( 'Herberekend'),
            self::MOLLIE_STATUS_pending => __( 'QR code gescand'),
            self::MOLLIE_STATUS_paidout => __( 'Betaling gestart'),
        ];
    }

    public static function getTypeOptions()
    {
        return [
            self::TYPE_previous_debt => __('previous_debt'),
            self::TYPE_previous_credit => __('TYPE_previous_credit'),
            self::TYPE_bank_add => __('TYPE_bank_add'),
            self::TYPE_bank_subtract => __('TYPE_bank_subtract'),
            self::TYPE_expenses => __('TYPE_expenses'),
            self::TYPE_card_payment => __('TYPE_card_payment'),
            self::TYPE_ideal => __('TYPE_ideal'),
            self::TYPE_ideal_refund => __('TYPE_ideal_refund'),
            self::TYPE_direct_payment => __('TYPE_direct_payment'),
        ];
    }
}
