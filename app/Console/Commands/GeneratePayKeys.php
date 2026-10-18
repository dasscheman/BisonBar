<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GeneratePayKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:generate-pay-keys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genereert een pay_key voor gebruikers die er nog geen hebben.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where(function ($query) {
            $query->whereNull('pay_key')->orWhere('pay_key', '');
        })->get();

        if ($users->isEmpty()) {
            $this->info('Alle gebruikers hebben al een pay_key.');
            return self::SUCCESS;
        }

        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        foreach ($users as $user) {
            $user->pay_key = User::generatePayKey();
            $user->save();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info($users->count().' pay_key(s) aangemaakt.');

        return self::SUCCESS;
    }
}
