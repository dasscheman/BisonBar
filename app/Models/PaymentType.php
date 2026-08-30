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

    const TYPE_izettle_pin = 10;

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
            self::MOLLIE_STATUS_open => __('Open'),
            self::MOLLIE_STATUS_cancelled => __( 'Canceled'),
            self::MOLLIE_STATUS_expired => __( 'Verlopen'),
            self::MOLLIE_STATUS_failed => __( 'Mislukt'),
            self::MOLLIE_STATUS_paid => __( 'Betaling ontvangen'),
            self::MOLLIE_STATUS_refunded => __( 'Refund'),
            self::MOLLIE_STATUS_pending => __( 'In process'),
            self::MOLLIE_STATUS_paidout => __( 'Uitbetaald'),
        ];
    }

    public static function getTypeOptions()
    {
        return [
            self::TYPE_previous_debt => __('previous_debt'),
            self::TYPE_previous_credit => __('previous_credit'),
            self::TYPE_bank_add => __('bank_add'),
            self::TYPE_bank_subtract => __('bank_subtract'),
            self::TYPE_expenses => __('expenses'),
            self::TYPE_card_payment => __('card_payment'),
            self::TYPE_ideal => __('ideal'),
            self::TYPE_ideal_refund => __('ideal_refund'),
            self::TYPE_direct_payment => __('direct_payment'),
        ];
    }
}
