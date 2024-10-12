<?php

namespace App\Livewire\Components;

use App\Models\Calculations;
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
    public $user;

    public function mount()
    {
        $years = Tally::select(
            DB::raw('(COUNT(*)) as count'),
            DB::raw('YEAR(created_at) as year')
        );

        if($this->user !== null) {
            $years = $years->where('user_id', $this->user->id);
        }
        $this->years = $years->orderBy('created_at', 'DESC')
            ->groupBy('year')
            ->pluck('year');

        $this->setYearsData($this->user);
    }

    public function render()
    {
        return view('components.year-totals');
    }

    private function setYearsData(User $user = null)
    {
        $calculations = new Calculations();
        if ($user !== null) {
            $calculations = new Calculations($user);
        }

        $total['tally-total'] = $calculations->tallies()->sum('price');
        $total['payment-ideal'] = $calculations->paymentsAddWhereIn([
            PaymentType::TYPE_ideal])->sum('price');
        $total['payment-bank'] = $calculations->paymentsAddWhereIn([
            PaymentType::TYPE_bank_add])->sum('price');
        $total['payment-total'] = $calculations->paymentsAddWhereIn([
            PaymentType::TYPE_bank_add,
            PaymentType::TYPE_ideal,
            PaymentType::TYPE_direct_payment])->sum('price');

        $total['expenses-total'] = $calculations->expenses()->sum('price');
        $total['nett'] = $total['tally-total'] - $total['payment-total'];
        $years = [];

        foreach ($this->years as $year) {
            $years[$year]['tally-total'] = $calculations->tallies()->whereYear('created_at', $year)->sum('price');
            $years[$year]['payment-ideal'] = $calculations->paymentsAddWhereIn([
                PaymentType::TYPE_ideal])->whereYear('created_at', $year)->sum('price');
            $years[$year]['payment-bank'] = $calculations->paymentsAddWhereIn([
                PaymentType::TYPE_bank_add])->whereYear('created_at', $year)->sum('price');
            $years[$year]['payment-total'] = $calculations->paymentsAddWhereIn([
                PaymentType::TYPE_bank_add,
                PaymentType::TYPE_ideal,
                PaymentType::TYPE_direct_payment])->whereYear('created_at', $year)->sum('price');

            $years[$year]['expenses-total'] = $calculations->expenses()->whereYear('created_at', $year)->sum('price');
            $years[$year]['nett'] = $years[$year]['tally-total'] - $years[$year]['payment-total'] - $years[$year]['expenses-total'];
        }
        $this->years = $years;
        $this->years['total'] = $total;
    }
}
