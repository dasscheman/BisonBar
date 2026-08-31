<?php

namespace App\Livewire\Admin;

use App\Models\Expenses;
use App\Models\User;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class YearsTable extends Component
{
    use AuthorizesRequests, WithPagination;

    public $title = 'Expense';

    //DataTable props
    public ?string $query = null;

    public ?string $resultCount;

    public string $orderBy = 'created_at';

    public string $orderAsc = 'desc';

    public int $perPage = 15;

    //Create, Edit, Delete, View User props
    public ?string $description = null;

    public ?int $user_id = null;

    public ?int $receipt_id = null;

    public ?int $invoice_id = null;

    public ?int $status_id = null;

    public ?float $price = null;

    public ?DateTime $created_at = null;

    public ?DateTime $updated_at = null;

    public ?string $solis_id = null;

    public ?string $allowed_attributes = null;

    public ?int $expense_id = null;

    public ?Expenses $expense = null;


    protected array $messages = [
        //
    ];

    protected string $paginationTheme = 'bootstrap';

    public function mount()
    {
    }
    public function render()
    {
        $users = User::withTrashed()->get();
        $years = range(2017, (int)date('Y'));
        foreach ($years as $year) {
            $credit = 0;
            $debit = 0;
            foreach ($users as $user) {
                if ($user->totalAtDate($year . '-12-31') > 0) {
                    $credit = $credit + $user->totalAtDate($year . '-12-31');
                }
                if ($user->totalAtDate($year . '-12-31') < 0) {
                    $debit = $debit + $user->totalAtDate($year . '-12-31');

                }
            }
            $data[$year]['credit'] = $credit;
            $data[$year]['debit'] = $debit;
            $data[$year]['netto'] = $credit + $debit;;
        }

        return view('livewire.admin.year.table', compact('data'));
    }

}
