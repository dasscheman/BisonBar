<?php

namespace App\Livewire\Components;

use App\Models\Tally;
use Livewire\Component;

class TalliesList extends Component
{
    public $tallies;

    public function mount()
    {
        $this->tallies = Tally::orderBy('created_at', 'DESC')->take(7)->get();
    }

    public function render()
    {
        return view('components.tallies-list');
    }
}
