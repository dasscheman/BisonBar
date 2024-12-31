<?php

namespace App\Livewire\Components;

use App\Models\Calculations;
use App\Models\Expenses;
use App\Models\Payment;
use App\Models\PaymentType;
use App\Models\Status;
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
        $yearsTallies = Tally::select(
            DB::raw('COUNT("id") as count'),
            DB::raw('YEAR(created_at) as year')
        )
            ->groupBy('year')
            ->orderBy('created_at', 'DESC');

        $yearsPayments = Payment::select(
            DB::raw('COUNT("id") as count'),
            DB::raw('YEAR(created_at) as year')
        )
            ->groupBy('year')
            ->orderBy('created_at', 'DESC');

        if($this->user !== null) {
            $yearsTallies = $yearsTallies->where('user_id', $this->user->id);
            $yearsPayments = $yearsPayments->where('user_id', $this->user->id);
        }
        $this->years = $yearsTallies->pluck('year')->merge($yearsPayments->pluck('year'))->unique();
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

        $total['tally-total'] = - $calculations->tallies()->sum('price');
        $total['payment-ideal'] = $calculations->payments(Payment::ADDSUBTRACT_ADD, [
            PaymentType::TYPE_ideal],
            [Status::STATUS_factuur_verzonden])->sum('price');
        $total['payment-bank'] = $calculations->payments(Payment::ADDSUBTRACT_ADD, [
            PaymentType::TYPE_bank_add],
            [Status::STATUS_factuur_verzonden])->sum('price');
        $total['payment-total'] = $calculations->payments(Payment::ADDSUBTRACT_ADD, [
                PaymentType::TYPE_bank_add,
                PaymentType::TYPE_ideal,
                PaymentType::TYPE_direct_payment],
                [Status::STATUS_factuur_verzonden])->sum('price')
            - $calculations->payments(Payment::ADDSUBTRACT_SUBTRACT, [
                PaymentType::TYPE_previous_debt])->sum('price')
            + $calculations->payments(Payment::ADDSUBTRACT_ADD, [
                PaymentType::TYPE_previous_credit])->sum('price');

        $total['expenses-total'] = $calculations->expenses()->sum('price');
        $total['nett'] = $total['tally-total'] + $total['payment-total'];
        $years = [];

        foreach ($this->years as $year) {
            $years[$year]['tally-total'] = - $calculations->tallies()->whereYear('created_at', $year)->sum('price');
            $years[$year]['payment-ideal'] = $calculations->payments(Payment::ADDSUBTRACT_ADD, [
                PaymentType::TYPE_ideal])->whereYear('created_at', $year)->sum('price');
            $years[$year]['payment-bank'] = $calculations->payments(Payment::ADDSUBTRACT_ADD, [
                PaymentType::TYPE_bank_add])->whereYear('created_at', $year)->sum('price');
            $years[$year]['payment-total'] = $calculations->payments(Payment::ADDSUBTRACT_ADD, [
                    PaymentType::TYPE_bank_add,
                    PaymentType::TYPE_ideal,
                    PaymentType::TYPE_direct_payment])->whereYear('created_at', $year)->sum('price')
                - $calculations->payments(Payment::ADDSUBTRACT_SUBTRACT, [
                    PaymentType::TYPE_previous_debt])->whereYear('created_at', $year)->sum('price')
                + $calculations->payments(Payment::ADDSUBTRACT_ADD, [
                    PaymentType::TYPE_previous_credit])->whereYear('created_at', $year)->sum('price');

            $years[$year]['expenses-total'] = $calculations->expenses()->whereYear('created_at', $year)->sum('price');
            $years[$year]['nett'] = $years[$year]['tally-total'] + $years[$year]['payment-total'] - $years[$year]['expenses-total'];
        }
        $this->years = $years;
        $this->years['total'] = $total;
    }
}
