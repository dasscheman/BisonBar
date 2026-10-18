<?php

namespace App\Console\Commands;

use App\Mail\InvoiceSend;
use App\Models\Invoices;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InvoiceSendCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice:send';

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
        $invoices = Invoices::whereNull('send_at')->get();
        foreach ($invoices as $invoice) {

            if(!Mail::to($invoice->user->email)->send(new InvoiceSend($invoice))) {
                Log::error('Lukt niet om een invoice te verzenden voor: ' . $invoice->user->name);
                continue;
            }

            DB::transaction(function () use($invoice) {
                $invoice->send_at = now();
                if (!$invoice->save()) {
                    return false;
                }
                $invoice->sendInvoice();
                return true;
            });
        }
    }
}
