<?php

namespace App\Livewire\Components;

use App\Models\Expenses;
use Livewire\Component;

class PaymentsList extends Component
{
    public $payments;

    public function mount($payments)
    {
        $this->payments = $payments;
//        $this->expenses = Expenses::orderBy('created_at', 'DESC')->take(7)->get();
    }

    public function render()
    {
        $payments = $this->payments;
        return view('components.payments-list', compact('payments'));
    }
}
