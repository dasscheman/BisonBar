<?php

namespace App\Http\Livewire\Admin;

use App\Models\Payment;
use Livewire\Component;

class PaymentManagement extends Component
{
    public $payments;

    public function mount()
    {
        $this->payments = Payment::all();
    }
    public function render()
    {
        return view('livewire.admin.payment-management');
    }
}
