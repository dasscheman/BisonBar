<?php

namespace App\Livewire\Admin;

use App\Models\Expenses;
use App\Models\Invoices;
use App\Models\Payment;
use App\Models\Tally;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class Dashboard extends Component
{
    public User $user;

    public $users;

    public $showAll = false;

    public $title = 'Dashboard';

    public $showNumber = 15;

    public $showSuccesNotification = false;

    protected $listeners = [
        'dashboardRefresh' => '$refresh',
    ];
    public function mount() {}

    public function render()
    {
        $expenses = Expenses::orderBy('created_at', 'DESC')->simplePaginate(6, pageName: 'expenses-list');
        $payments = Payment::orderBy('created_at', 'DESC')->take(4)->get();
        $tallies = Tally::orderBy('created_at', 'DESC')->take(7)->get();
        $invoices = Invoices::orderBy('created_at', 'DESC')->take(7)->get();
        $years = Tally::select(
            DB::raw('(COUNT(*)) as count'),
            DB::raw('YEAR(created_at) as year')
        )
            ->orderBy('created_at', 'DESC')
            ->groupBy('year')
            ->pluck('year');

        return view('livewire.admin.dashboard', compact('expenses', 'payments', 'tallies', 'invoices', 'years'));
    }

    public function toggleShowAll()
    {
        $this->showAll = ! $this->showAll;
    }

    public function download(Invoices $invoice)
    {
        if (! Storage::disk('local')->exists('/invoices/'.$invoice->file_name)) {
            session()->flash('message', 'Could not find file!');
            return redirect()->to('/admin-dashboard');
        }
        $filePath = storage_path('/app/invoices/'.$invoice->file_name);

        return response()->download($filePath);
    }
}
