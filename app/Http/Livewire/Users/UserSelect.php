<?php

namespace App\Http\Livewire\Users;
use App\Models\Assortment;
use App\Models\User;

use Livewire\Component;

class UserSelect extends Component
{
    public User $user;
    public Assortment  $assortments;

    public $showSuccesNotification  = false;

    public function mount($user) {
        $this->user = $user;
        $this->assortments = Assortment::all();
    }


    public function render()
    {
        return view('livewire.users.user-select');
    }
}
