<?php

namespace App\Livewire\Users;
use App\Models\User;

use Livewire\Component;

class UserInvoices extends Component
{
    public User $user;

    public function mount(User $user) {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.users.user-invoices');
    }
}
