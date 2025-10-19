<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schedule;

$serviceUser = User::where('email', config('mail.from.address'))->first();
$this->info('Login user ' . $serviceUser->id);
Auth::loginUsingId($serviceUser->id, true);

Schedule::command('backup:clean')->dailyAt('01:00');
Schedule::command('backup:run')->dailyAt('01:30');
Schedule::command('backup:monitor')->dailyAt('03:00');
Auth::logout();
