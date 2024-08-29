<?php

namespace App\Livewire\Components;

use App\Models\Assortment;
use App\Models\Expenses;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Tally;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class YearTotals extends Component
{
    public $years;

    public function mount()
    {
        $years = Tally::select(
            DB::raw("(COUNT(*)) as count"),
            DB::raw("YEAR(created_at) as year")
        )
            ->orderBy('created_at', 'DESC')
            ->groupBy('year')
            ->pluck('year');

        $this->years['total']['tally-total'] = Tally::sum('price');

        $this->years['total']['payment-total'] = Payment::whereIn('type_id', [PaymentType::TYPE_bank_add, PaymentType::TYPE_ideal, PaymentType::TYPE_direct_payment])
            ->sum('price');

        $this->years['total']['expenses-total'] = Expenses::sum('price');
        $this->years['total']['nett'] = $this->years['total']['tally-total'] - $this->years['total']['payment-total'];

        foreach($years as $year) {
            $this->years[$year]['tally-total'] = Tally::whereYear('created_at', $year)->sum('price');

            $this->years[$year]['payment-total'] = Payment::whereYear('created_at', $year)
                ->whereIn('type_id', [PaymentType::TYPE_bank_add, PaymentType::TYPE_ideal, PaymentType::TYPE_direct_payment])
                ->sum('price');

            $this->years[$year]['expenses-total'] = Expenses::whereYear('created_at', $year)->sum('price');
            $this->years[$year]['nett'] = $this->years[$year]['tally-total'] - $this->years[$year]['payment-total'] - $this->years[$year]['expenses-total'];
        }
    }

    public function render()
    {
        return view('components.year-totals');
    }
}
