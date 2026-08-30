<?php

namespace App\Livewire\Components;

use App\Models\Assortment;
use App\Models\User;
use Livewire\Component;

class AssortmentSelected extends Component
{
    public $user;

    public $assortment;

    public $assortmentSelected = false;

    public function mount(User $user, Assortment $assortment)
    {
        $this->user = $user;
        $this->assortment = $assortment;

    }

    public function render()
    {
        return view('components.assortment-selected');
    }
}
