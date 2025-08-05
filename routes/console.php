<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('backup:clean')->dailyAt('01:00');
Schedule::command('backup:run')->dailyAt('01:30');
Schedule::command('backup:monitor')->dailyAt('03:00');
