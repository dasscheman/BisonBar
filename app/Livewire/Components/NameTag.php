<?php

namespace App\Livewire\Components;

use App\Models\User;
use Livewire\Attributes\Isolate;
use Livewire\Component;

#[Isolate]
class NameTag extends Component
{
    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    public function render()
    {
        return view('components.name-tag');
    }
}
