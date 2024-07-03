<?php

namespace App\Http\Livewire\Admin;

use App\Models\Invoices;
use Livewire\Component;
class InvoicesManagement extends Component
{
    public $invoices;

    public function mount()
    {
        $this->invoices = Invoices::all();
    }
    public function render()
    {
        return view('livewire.admin.invoices-management');
    }
}
