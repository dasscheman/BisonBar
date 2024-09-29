<?php

namespace App\Livewire\Components;

use App\Models\Expenses;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Tally;
use Livewire\Component;

class HeaderTotals extends Component
{
    public $totals;

    public function mount()
    {
        $this->totals['tally-total'] = Tally::sum('price');

        $this->totals['payment-total'] = Payment::whereIn('type_id', [PaymentType::TYPE_bank_add, PaymentType::TYPE_ideal, PaymentType::TYPE_direct_payment])
            ->sum('price');

        $this->totals['expenses-total'] = Expenses::sum('price');
        $this->totals['nett'] = $this->totals['tally-total'] - $this->totals['payment-total'] - $this->totals['expenses-total'];
    }

    public function render()
    {
        return view('components.header-totals');
    }
}
