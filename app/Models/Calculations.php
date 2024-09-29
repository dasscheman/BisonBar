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

    public function total()
    {
        return $this->expenses()->sum('price')
            + $this->paymentsAdd(PaymentType::TYPE_previous_credit)->sum('price')
            + $this->paymentsAdd(PaymentType::TYPE_ideal)->sum('price')
            + $this->paymentsAdd(PaymentType::TYPE_bank_add)->sum('price')
            + $this->paymentsSubtract(PaymentType::TYPE_direct_payment)->sum('price')
            - $this->paymentsSubtract(PaymentType::TYPE_previous_debt)->sum('price')
            - $this->tallies()->sum('price');
    }

    public function totalNotInvoiced()
    {
        return $this->expensesNotInvoiced()->sum('price')
            + $this->paymentsAddNotInvoiced(PaymentType::TYPE_ideal)->sum('price')
            + $this->paymentsAddNotInvoiced(PaymentType::TYPE_bank_add)->sum('price')
            + $this->paymentsAddNotInvoiced(PaymentType::TYPE_direct_payment)->sum('price')
            - $this->talliesNotInvoiced()->sum('price');
    }

    public function expenses()
    {
        $expenses = new Expenses();

        if($this->date) {
            $expenses = $expenses->whereDate('created_at', '<=', $this->date);
        }

        if($this->user !== null) {
            $expenses = $expenses->where('user_id', $this->user->id);
        }
        return $expenses;
    }

    public function expensesNotInvoiced()
    {
        return $this->expenses()
            ->whereNull('invoice_id');
    }

    public function paymentsAddNotInvoiced($type)
    {
        return $this->paymentsAdd($type)
            ->whereNull('invoice_id');
    }

    public function paymentsAdd($type)
    {
        $payments = Payment::where('type_id', $type)
            ->where('add_subtract', Payment::ADDSUBTRACT_ADD);

        if($this->date) {
            $payments = $payments->whereDate('created_at', '<=', $this->date);
        }

        if($this->user !== null) {
            $payments = $payments->where('user_id', $this->user->id);
        }
        return $payments;
    }

    public function paymentsAddWhereIn($types)
    {
        $payments = Payment::whereIn('type_id', $types)
            ->where('add_subtract', Payment::ADDSUBTRACT_ADD);

        if($this->date) {
            $payments = $payments->whereDate('created_at', '<=', $this->date);
        }

        if($this->user !== null) {
            $payments = $payments->where('user_id', $this->user->id);
        }
        return $payments;
    }

    public function paymentsSubtractNotInvoiced($type)
    {
        return $this->paymentsSubtract($type)
            ->whereNull('invoice_id');
    }

    public function paymentsSubtract($type)
    {
        $payments = Payment::where('type_id', $type)
            ->where('add_subtract', Payment::ADDSUBTRACT_SUBTRACT);

        if($this->date) {
            $payments = $payments->whereDate('created_at', '<=', $this->date);
        }

        if($this->user !== null) {
            $payments = $payments->where('user_id', $this->user->id);
        }
        return $payments;
    }

    public function talliesNotInvoiced(): HasMany
    {
        $tallies = $this->tallies()
            ->whereNull('invoice_id');

        if($this->date) {
            $tallies = $tallies->whereDate('created_at', '<=', $this->date);
        }

        if($this->user !== null) {
            $tallies = $tallies->where('user_id', $this->user->id);
        }
        return $tallies;
    }

    public function tallies()
    {
        $tallies = new Tally();
        if($this->date) {
            $tallies = $tallies->whereDate('created_at', '<=', $this->date);
        }

        if($this->user !== null) {
            $tallies = $tallies->where('user_id', $this->user->id);
        }
        return $tallies;
    }

    public function payments()
    {
        $payments = new Payment();

        if($this->date) {
            $payments = $payments->whereDate('created_at', '<=', $this->date);
        }

        if($this->user !== null) {
            $payments = $payments->where('user_id', $this->user->id);
        }
        return $payments;
    }


    public function pendingPaymentsExists()
    {
        $payments = Payment::where('mollie_status', PaymentType::MOLLIE_STATUS_pending)
            ->whereIsNull('deleted_at')
            ->exists();

        if($this->user !== null) {
            $payments = $payments->where('user_id', $this->user->id);
        }
        return $payments;
    }

    public function invoices()
    {
        $invoices = new Invoices();

        if($this->date) {
            $invoices = $invoices->whereDate('created_at', '<=', $this->date);
        }

        if($this->user !== null) {
            $invoices = $invoices->where('user_id', $this->user->id);
        }
        return $invoices;
    }

    public function checkNewTalliesForNewInvoice()
    {
        return $this->getNewTalliesForNewInvoice()
            ->whereDate('created_at', '<=', now()->subWeeks(4))
            ->exists();
    }

    public function getNewTalliesForNewInvoice()
    {
        $tally = $this->tallies()
            ->where('status_id', Status::STATUS_ingevoerd);

        return $tally;
    }

    public function checkNewPaymentsForNewInvoice($type)
    {
        return $this->getNewPaymentsForNewInvoice($type)
            ->whereDate('created_at', '<=', now()->subWeeks(4))
            ->exists();
    }

    public function getNewPaymentsForNewInvoice($type)
    {
        $tally = $this->paymentsAdd($type)
            ->whereIn('status_id', [Status::STATUS_ingevoerd, Status::STATUS_herberekend]);

        return $tally;
    }

    public function checkNewInvalidPaymentsForNewInvoice($type)
    {
        return $this->getNewInvalidPaymentsForNewInvoice($type)
            ->whereDate('created_at', '<=', now()->subWeeks(4))
            ->exists();
    }

    public function getNewInvalidPaymentsForNewInvoice($type)
    {
        $tally = $this->paymentsAdd($type)
            ->whereIn('status_id', [Status::STATUS_ongeldig, Status::STATUS_tercontrole]);

        return $tally;
    }

    public function checkNewExpensesForNewInvoice()
    {
        return $this->getNewExpensesForNewInvoice()
            ->whereDate('created_at', '<=', now()->subWeeks(4))
            ->exists();
    }

    public function getNewExpensesForNewInvoice()
    {
        $tally = $this->expenses()
            ->where('status_id', Status::STATUS_ingevoerd);

        return $tally;
    }

    public function checkForNewInvoice()
    {
        if ($this->checkNewTalliesForNewInvoice()) {
            return true;
        }

        if ($this->checkNewPaymentsForNewInvoice(PaymentType::TYPE_ideal)) {
            return true;
        }

        if ($this->checkNewPaymentsForNewInvoice(PaymentType::TYPE_bank_add)) {
            return true;
        }

        if ($this->checkNewPaymentsForNewInvoice(PaymentType::TYPE_direct_payment)) {
            return true;
        }

        if ($this->checkNewExpensesForNewInvoice()) {
            return true;
        }

        return false;
    }
}
