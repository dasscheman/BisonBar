<?php

namespace App\Livewire\Users;
use App\Models\User;

use Livewire\Component;

class UserTab extends Component
{
    public User $user;

    public $title = 'Profile';
    public $tab = 'profile'; //profile, tally, payments, invoices
    public $showSuccesNotification  = false;

    public function mount($user = null)
    {
        if($user != null) {
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
        return view('livewire.users.user-tab');
    }
}
