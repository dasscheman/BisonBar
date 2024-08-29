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
        $invoices = $this->user->invoices()->orderBy('created_at', 'DESC')->simplePaginate(10);

        return view('livewire.users.user-invoices', compact('invoices'));
    }
}
