<?php

namespace App\Http\Livewire\Users;
use App\Models\User;

use Livewire\Component;

class UserProfile extends Component
{
    public User $user;

    public $tab = 'profile'; //profile, tally, invoices
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
        return view('livewire.users.user-profile');
    }
}
