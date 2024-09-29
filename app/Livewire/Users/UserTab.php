<?php

namespace App\Livewire\Users;

use App\Models\Expenses;
use App\Models\Invoices;
use App\Models\Payment;
use App\Models\Tally;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UserTab extends Component
{
    public User $user;

    public $title = 'Profile';

    public $tab = 'overzicht'; //profile, overzicht

    public $years = null;

    public $showSuccesNotification = false;

    public function mount($user = null)
    {
        if ($user != null) {
            $this->user = $user;
            return;
        }
        $this->user = auth()->user();
    }

    public function setTab($tab)
    {
        $this->tab = $tab;
    }

    public function render()
    {

        $expenses = $this->user->expenses()->orderBy('created_at', 'DESC')->simplePaginate(6, pageName: 'expenses-list');
        $payments = $this->user->payments   ()->orderBy('created_at', 'DESC')->simplePaginate(4, pageName: 'payments-list');
        $tallies = $this->user->tallies()->orderBy('created_at', 'DESC')->simplePaginate(7, pageName: 'tallies-list');
        $invoices = $this->user->invoices()->orderBy('created_at', 'DESC')->simplePaginate(6, pageName: 'invoices-list');

        return view('livewire.users.user-tab', compact('expenses', 'payments', 'tallies', 'invoices'));
    }
}
