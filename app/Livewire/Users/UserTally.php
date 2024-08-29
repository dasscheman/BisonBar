<?php

namespace App\Livewire\Users;
use App\Models\Tally;
use App\Models\User;

use Livewire\Component;
use Livewire\WithPagination;

class UserTally extends Component
{
    use WithPagination;
    public User $user;

    public function mount(User $user) {
        $this->user = $user;
    }

    public function render()
    {
        $tallies = $this->user->tallies()->orderBy('created_at', 'DESC')->simplePaginate(10);

        return view('livewire.users.user-tally', compact('tallies'));
    }
}
