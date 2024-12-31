<?php

namespace App\Models;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
            $expenses = $expenses->whereDate('created_at', '<', $this->date);
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
            $tallies = $tallies->whereDate('created_at', '<', $this->date);
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

    public function payments($addSubstract = Payment::ADDSUBTRACT_ADD,
                             Array $types = [PaymentType::TYPE_ideal, PaymentType::TYPE_bank_add, PaymentType::TYPE_direct_payment],
                             Array $status =[Status::STATUS_factuur_verzonden, Status::STATUS_factuur_gegenereerd])
    {
        $payments = Payment::whereIn('type_id', $types)
                ->where('add_subtract', $addSubstract)
                ->whereIn('status_id', $status);

        if($this->date) {
            $payments = $payments->whereDate('created_at', '<', $this->date);
        }
        if($this->user !== null) {
            $payments = $payments->where('user_id', $this->user->id);
        }
        return $payments;
    }

    public function paymentsNotInvoiced($addSubstract = Payment::ADDSUBTRACT_ADD,
                                        Array $types = [PaymentType::TYPE_ideal, PaymentType::TYPE_bank_add, PaymentType::TYPE_direct_payment])
    {
        return $this->payments($addSubstract, $types)->whereNull('invoice_id');
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
            $payments = $payments->whereDate('created_at', '<', $this->date);
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
        return $this->expenses()->sum('price')
            + $this->payments(
                Payment::ADDSUBTRACT_ADD,
                [
                    PaymentType::TYPE_previous_credit,
                    PaymentType::TYPE_ideal,
                    PaymentType::TYPE_bank_add,
                    PaymentType::TYPE_direct_payment])->sum('price')
            - $this->payments(Payment::ADDSUBTRACT_SUBTRACT, [
                PaymentType::TYPE_previous_debt])->sum('price')
            + $this->payments(Payment::ADDSUBTRACT_ADD, [
                PaymentType::TYPE_previous_credit])->sum('price')
            - $this->tallies()->sum('price');
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
                    PaymentType::TYPE_direct_payment])->sum('price')
            - $this->paymentsNotInvoiced(Payment::ADDSUBTRACT_SUBTRACT, [
                PaymentType::TYPE_previous_debt])->sum('price')
            - $this->talliesNotInvoiced()->sum('price');
    }

    public function invoices()
    {
        $invoices = new Invoices();

        if($this->date) {
            $invoices = $invoices->whereDate('created_at', '<', $this->date);
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

    public function checkNewPaymentsForNewInvoice(Array $types = [PaymentType::TYPE_ideal, PaymentType::TYPE_bank_add, PaymentType::TYPE_direct_payment])
    {
         return $this->paymentsNotInvoiced($types)
            ->whereDate('created_at', '<=', now()->subWeeks(4))
            ->exists();
    }

    public function checkNewExpensesForNewInvoice()
    {
        return $this->expensesNotInvoiced()
            ->whereDate('created_at', '<=', now()->subWeeks(4))
            ->exists();
    }

    public function checkForNewInvoice()
    {
        if ($this->checkNewTalliesForNewInvoice()) {
            return true;
        }

        if ($this->checkNewPaymentsForNewInvoice([PaymentType::TYPE_ideal])) {
            return true;
        }

        if ($this->checkNewPaymentsForNewInvoice([PaymentType::TYPE_bank_add])) {
            return true;
        }

        if ($this->checkNewPaymentsForNewInvoice([PaymentType::TYPE_direct_payment])) {
            return true;
        }

        if ($this->checkNewExpensesForNewInvoice()) {
            return true;
        }

        return false;
    }
}
