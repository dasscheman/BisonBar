<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schedule;

$serviceUser = User::where('email', config('mail.from.address'))->first();
if($serviceUser) {
    Auth::loginUsingId($serviceUser->id, true);
    Schedule::command('backup:clean')->dailyAt('01:00');
    Schedule::command('backup:run')->dailyAt('01:30');
    Schedule::command('backup:monitor')->dailyAt('03:00');
    Auth::logout();
}

Schedule::command('google:gmail-token-refresh')->everyThirtyMinutes()->withoutOverlapping();

Schedule::command('app:check-recuring')->dailyAt('04:00')->withoutOverlapping();
Schedule::command('app:start-recuring')->dailyAt('04:15')->withoutOverlapping();
Schedule::command('invoice:generate')->dailyAt('04:30')->withoutOverlapping();
Schedule::command('invoice:send')->dailyAt('04:45')->withoutOverlapping();
