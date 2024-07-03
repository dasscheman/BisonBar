<?php

namespace App\Http\Livewire\Users;
use App\Models\User;

use Livewire\Component;

class UserEdit extends Component
{
    public User $user;
    public $name;
    public $email;
//
    protected $rules = [
        'user.name' => 'max:40|min:3',
        'user.email' => 'email:rfc,dns',
    ];


    public function mount(User $user): void
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
    }
//    public function mount(User $user) {
//        $this->user = $user;
//    }

    public function save() {
        $this->validate();
        $this->user->save();
        $this->showSuccesNotification = true;
    }


    public function render()
    {
        return view('livewire.users.user-edit');
    }
}
