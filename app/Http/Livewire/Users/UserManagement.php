<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use withPagination;

    public $user;


    public function mount()
    {

    }

    public function initdata(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('livewire.users.user-management', ['users' => User::paginate(10)] );
    }
}
