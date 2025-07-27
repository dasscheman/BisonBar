<?php

namespace App\Livewire\Components;

use App\Models\Invoices;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class InvoicesList extends Component
{
    public $invoices;
    public $user;

    public function mount($invoices)
    {
        $this->invoices = $invoices;
    }

    public function render()
    {
        return view('components.invoices-list');
    }

    public function download(Invoices $invoice)
    {
        if (! Storage::disk('local')->exists('/invoices/'.$invoice->file_name)) {
            session()->flash('message', 'Could not find file!');
            return;
        }
        $filePath = storage_path('/app/invoices/'.$invoice->file_name);

        return response()->download($filePath);
    }
}
