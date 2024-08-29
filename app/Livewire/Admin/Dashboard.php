<?php

namespace App\Livewire\Admin;

use App\Models\Expenses;
use App\Models\Payment;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public $users;
    public $showAll = false;
    public $title = "Dashboard";

    public $showNumber = 15;

    public $showSuccesNotification  = false;

    public function mount()
    {
    }

    public function render()
    {
        $expenses = Expenses::orderBy('created_at', 'DESC')->simplePaginate(6, pageName: 'expenses-list');
        $payments = Payment::orderBy('created_at', 'DESC')->simplePaginate(3, pageName: 'payments-list');

        return view('livewire.admin.dashboard', compact('expenses', 'payments'));
    }

    public function toggleShowAll()
    {
        $this->showAll = !$this->showAll;
    }
}
