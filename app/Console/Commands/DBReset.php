<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;


class DBReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('wipe database');
        Artisan::call('db:wipe');

        $this->info('import old data');
        Artisan::call('db:import');

        $this->info('migrate data');
        Artisan::call('migrate --seed');

    }
}
