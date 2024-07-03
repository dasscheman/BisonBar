<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Expenses;

class ExpensesManagement extends Component
{
    public $exspenses;

    public function mount()
    {
        $this->exspenses = Expenses::all();
    }
    public function render()
    {
        return view('livewire.admin.expenses-management');
    }
}
