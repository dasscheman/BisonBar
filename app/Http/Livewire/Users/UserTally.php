<?php

namespace App\Http\Livewire\Users;
use App\Models\Tally;
use App\Models\User;

use Livewire\Component;
use Livewire\WithPagination;

class UserTally extends Component
{
    use WithPagination;
    public User $user;
//    public $tallies;

    public function mount(User $user) {
        $this->user = $user;
    }

    public function render()
    {
        $tallies = $this->user->tallies()->paginate(10);

        return view('livewire.users.user-tally', compact('tallies'));
    }
}
