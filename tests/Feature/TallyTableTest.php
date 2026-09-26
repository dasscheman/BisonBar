<?php

use App\Livewire\Tallies\TallyTable;
use App\Models\User;
use Livewire\Livewire;

it('renders the tallies page and create form', function () {
    $user = User::create([
        'name' => 'Test Admin',
        'email' => 'admin@test.dev',
        'password' => bcrypt('secret'),
        'role_id' => User::ROLE_super_admin,
    ]);

    $this->actingAs($user);

    Livewire::test(TallyTable::class)
        ->assertSee('Create New Tally')
        ->assertViewHas('tallyLists');
});