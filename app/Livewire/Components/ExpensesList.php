<?php

namespace App\Livewire\Components;

use App\Models\Expenses;
use Livewire\Component;

class ExpensesList extends Component
{
    public $expenses;

    public function mount()
    {
        $this->expenses = Expenses::orderBy('created_at', 'DESC')->take(7)->get();
    }

    public function render()
    {
        return view('components.expenses-list');
    }
}
