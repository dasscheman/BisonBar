<?php

namespace App\Livewire\Users;
use App\Models\User;

use Livewire\Component;

class UserPayments extends Component
{
    public User $user;

    public function mount(User $user) {
        $this->user = $user;
    }

    public function render()
    {
        $payments = $this->user->payments()->orderBy('created_at', 'DESC')->simplePaginate(10);
        return view('livewire.users.user-payments', compact('payments'));
    }
}
