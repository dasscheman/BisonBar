<?php

namespace App\Livewire;

use App\Models\Tally;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public $users;

    public $showAll = false;

    public $title = '';

    public $showNumber = 15;

    public $showSuccesNotification = false;

    public function mount()
    {

    }

    public function render()
    {
        $this->users = User::query()
            ->orderByDesc(
                Tally::select('created_at')
                    ->whereColumn('user_id', 'la_users.id')
                    ->orderByDesc('created_at')
                    ->limit(1)
            )
            ->whereNot('role_id', User::ROLE_bar_user)
            ->take($this->showNumber)
            ->get();
        $this->users = $this->users->sortBy('name');
        if ($this->showAll) {
            $this->users = User::orderBy('name', 'ASC')
                ->whereNot('role_id', User::ROLE_bar_user)
                ->get();
        }

        return view('livewire.dashboard');
    }

    public function toggleShowAll()
    {
        $this->showAll = ! $this->showAll;
    }
}
