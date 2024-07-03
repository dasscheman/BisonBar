<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class TallyManagement extends Component
{
    public $tallies;

    public function mount()
    {
        $tallies = TallyManagement::all();
    }
    public function render()
    {
        return view('livewire.admin.tally-management');
    }
}
