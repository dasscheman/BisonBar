<?php

namespace App\Livewire\Components;

use App\Models\Expenses;
use Livewire\Component;

class PaymentsList extends Component
{
    public $payments;
    public $user;

    public function mount($payments)
    {
        $this->payments = $payments;
    }

    public function render()
    {
        $payments = $this->payments;

        return view('components.payments-list', compact('payments'));
    }
}
