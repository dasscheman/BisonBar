<?php

namespace App\Livewire\Components;

use App\Models\Tally;
use Livewire\Component;

class TalliesList extends Component
{
    public $tallies;
    public $user;

    public function mount($tallies)
    {
        $this->tallies = $tallies;
    }

    public function render()
    {
        return view('components.tallies-list');
    }
}
