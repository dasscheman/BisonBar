<?php

namespace App\Models;

class Calculations
{
    private $user;
    private $date;

    public function __construct(User $user = null) {
        $this->user = $user;
    }

    public function setDate($date)
    {
        $this->date = $date;
    }


    public function expenses()
    {
        $expenses = new Expenses();

        if($this->date) {
            $expenses = $expenses->where('created_at', '<=', $this->date);
        }

        if($this->user !== null) {
            $expenses = $expenses->where('user_id', $this->user->id);
        }
        return $expenses;
    }

    public function expensesNotInvoiced()
    {
        return $this->expenses()->whereNull('invoice_id');
    }

    public function tallies()
    {
        $tallies = new Tally();
        if($this->date) {
            $tallies = $tallies->where('created_at', '<=', $this->date);
        }

        if($this->user !== null) {
            $tallies = $tallies->where('user_id', $this->user->id);
        }
        return $tallies;
    }

    public function talliesNotInvoiced()
    {
        return $this->tallies()
            ->whereNull('invoice_id');
    }

    /**
     * Retrieve payments based on add/subtract type,*/
    public function payments($addSubstract = Payment::ADDSUBTRACT_ADD,
                             Array $types = [PaymentType::TYPE_ideal, PaymentType::TYPE_bank_add, PaymentType::TYPE_direct_payment],
                             Array $status =[Status::STATUS_gecontroleerd, Status::STATUS_factuur_verzonden, Status::STATUS_factuur_gegenereerd])
    {
        $payments = Payment::where('add_subtract', $addSubstract)
                ->whereIn('type_id', $types)
                ->whereIn('status_id', $status);

        if($this->date) {
            $payments = $payments->where('created_at', '<=', $this->date);
        }
        if($this->user !== null) {
            $payments = $payments->where('user_id', $this->user->id);
        }
        return $payments;
    }

    public function paymentsNotInvoiced($addSubstract = Payment::ADDSUBTRACT_ADD,
                                        Array $types = [PaymentType::TYPE_ideal, PaymentType::TYPE_bank_add, PaymentType::TYPE_direct_payment],
                                        Array $status =[Status::STATUS_herberekend, Status::STATUS_ingevoerd, Status::STATUS_gecontroleerd])
    {
        return $this->payments($addSubstract, $types, $status)->whereNull('invoice_id');
    }

    public function paymentsInvalid()
    {
        $status = [
            Status::STATUS_tercontrole,
            Status::STATUS_teruggestord,
            Status::STATUS_geannuleerd,
            Status::STATUS_ongeldig
        ];
        $payments = Payment::whereIn('status_id', $status);


        if($this->date) {
            $payments = $payments->where('created_at', '<=', $this->date);
        }

        if($this->user !== null) {
            $payments = $payments->where('user_id', $this->user->id);
        }
        return $payments;
    }

    public function pendingPaymentsExists()
    {
        if ($this->user === null) {
            return abort(403);
        }

        return Payment::where('mollie_status', PaymentType::MOLLIE_STATUS_pending)
            ->where('user_id', $this->user->id)
            ->exists();
    }

    public function total()
    {
         $total = $this->expenses()->sum('price')
            + $this->payments(
                Payment::ADDSUBTRACT_ADD,
                [
                    PaymentType::TYPE_previous_credit,
                    PaymentType::TYPE_ideal,
                    PaymentType::TYPE_bank_add,
                    PaymentType::TYPE_direct_payment,
                    PaymentType::TYPE_izettle_pin])->sum('price')
            - $this->payments(Payment::ADDSUBTRACT_SUBTRACT, [
                PaymentType::TYPE_previous_debt,
                PaymentType::TYPE_bank_subtract])->sum('price')
            - $this->tallies()->sum('price');

        return $total;
    }

    public function totalNotInvoiced()
    {
        return $this->expensesNotInvoiced()->sum('price')
            + $this->paymentsNotInvoiced(
                Payment::ADDSUBTRACT_ADD,
                [
                    PaymentType::TYPE_previous_credit,
                    PaymentType::TYPE_ideal,
                    PaymentType::TYPE_bank_add,
                    PaymentType::TYPE_direct_payment,
                    PaymentType::TYPE_izettle_pin])->sum('price')
            - $this->paymentsNotInvoiced(Payment::ADDSUBTRACT_SUBTRACT, [
                PaymentType::TYPE_previous_debt,
                PaymentType::TYPE_bank_subtract])->sum('price')
            - $this->talliesNotInvoiced()->sum('price');
    }

    public function invoices()
    {
        $invoices = new Invoices();

        if($this->date) {
            $invoices = $invoices->where('created_at', '<=', $this->date);
        }

        if($this->user !== null) {
            $invoices = $invoices->where('user_id', $this->user->id);
        }
        return $invoices;
    }

    public function checkNewTalliesForNewInvoice()
    {
        return $this->talliesNotInvoiced()
            ->whereDate('created_at', '<=', now()->subWeeks(4))
            ->exists();
    }

    public function checkNewPaymentsForNewInvoice()
    {
        $addExists = $this->paymentsNotInvoiced(Payment::ADDSUBTRACT_ADD, array_keys(PaymentType::getTypeOptions()))
            ->whereDate('created_at', '<=', now()->subWeeks(4))
            ->exists();
         if($addExists) {
            return true;
         }
         return $this->paymentsNotInvoiced(Payment::ADDSUBTRACT_SUBTRACT, array_keys(PaymentType::getTypeOptions()))
            ->whereDate('created_at', '<=', now()->subWeeks(4))
            ->exists();
    }

    public function checkNewExpensesForNewInvoice()
    {
        return $this->expensesNotInvoiced()
            ->whereDate('date', '<=', now()->subWeeks(4))
            ->exists();
    }

    public function checkForNewInvoice()
    {
        if ($this->checkNewTalliesForNewInvoice()) {
            return true;
        }

        if ($this->checkNewPaymentsForNewInvoice()) {
            return true;
        }

        if ($this->checkNewExpensesForNewInvoice()) {
            return true;
        }

        return false;
    }
}
