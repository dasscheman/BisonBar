<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserCalculations;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;


class InvoiceGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:generate';

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
       $users = UserCalculations::whereNull('blocked_at')->get();
       foreach ($users as $user) {
           $this->info('Check user ' . $user->name);
           if(!$user->checkForNewInvoice()) {
               continue;
           }

            if($user->generateNewInvoice()) {
                $this->info('Generated invoice for user ' . $user->name);
            }
       }
    }
}
