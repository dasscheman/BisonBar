<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use App\Models\Assortment;

class AssortmentManagement extends Component
{
    public $assortments;

    public function mount()
    {
        $this->assortments = Assortment::all();
    }
    public function render()
    {
        return view('livewire.admin.assortment-management');
    }
}
