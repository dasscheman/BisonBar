<?php

namespace App\Livewire\Users;

use App\Models\Expenses;
use App\Models\Invoices;
use App\Models\Payment;
use App\Models\Tally;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class UserTab extends Component
{
    public User $user;

    public $title = '';

    public $tab = 'overzicht'; //profile, overzicht

    public $years = null;

    public $showSuccesNotification = false;


    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
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
        $payments = $this->user->payments   ()->orderBy('created_at', 'DESC')->take(4)->get();
        $tallies = $this->user->tallies()->orderBy('created_at', 'DESC')->take(7)->get();
        $invoices = $this->user->invoices()->orderBy('created_at', 'DESC')->take(7)->get();

        return view('livewire.users.user-tab', compact('expenses', 'payments', 'tallies', 'invoices'));
    }
}
