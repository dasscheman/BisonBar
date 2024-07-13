<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public $users;
    public $showAll = false;
    public $title = "Dashboard";
    public $showNumber = 15;

    public $showSuccesNotification  = false;

    public function mount()
    {
        $this->users = User::orderBy('updated_at', 'DESC')->take($this->showNumber)->get();
    }

    public function render()
    {
        $showNumber = $this->showNumber;
        if ($this->showAll) {
            $showNumber = null;
        }

        $this->users = User::orderBy('updated_at', 'DESC')->take($showNumber)->get();
        return view('livewire.dashboard');
    }

    public function toggleShowAll()
    {
        $this->showAll = !$this->showAll;
    }
}
