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

class ExpenseTable extends Component
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

    //Update & Store Rules
    protected array $rules =
        [
            'user_id' => 'int',
            'receipt_id' => 'int',
            'invoice_id' => 'nullable|int',
            'description' => 'string',
            'status_id' => 'int',
            'price' => 'decimal:2',
        ];

    protected array $messages = [
        //
    ];

    protected string $paginationTheme = 'bootstrap';

    public function render()
    {
        $paginatedExpenses = $this->search($this->query)->orderBy($this->orderBy, $this->orderAsc)->paginate($this->perPage);
        //results count available with search only
        $this->resultCount = empty($this->query) ? null :
            $paginatedExpenses->count().' '.Str::plural('user', $paginatedExpenses->count()).' found';

        return view('livewire.admin.expenses.table', compact('paginatedExpenses'));
    }

    public function store()
    {
        $validatedData = $this->validate();

        DB::transaction(function () use ($validatedData) {

            Expenses::create($validatedData);
        });
        $this->refresh('Expenses successfully created!');
    }

    //Get & assign selected post props
    public function initData(Expenses $expense)
    {
        // assign values to public props
        $this->expense = $expense;
        $this->expense_id = $expense->expense_id;
        $this->user_id = $expense->user_id;
        $this->receipt_id = $expense->receipt_id;
        $this->invoice_id = $expense->invoice_id;
        $this->description = $expense->description;
        $this->price = $expense->price;
        $this->status_id = $expense->status_id;
    }

    public function update()
    {
        $validatedData = $this->validate();
        $this->expense->update($validatedData);
        $this->refresh('Expense successfully updated!');
    }

    public function delete()
    {
        if (! empty($this->expense)) {
            DB::transaction(function () {
                $this->expense->delete();
            });
        }
        $this->refresh('Successfully deleted!');
    }

    public function refresh($message)
    {
        session()->flash('message', $message);
        $this->clearFields();

        //Close the active modal
        $this->dispatch('hideModal');
    }

    public function mount()
    {
        $this->expense = new Expenses;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
    }

    public function clearFields()
    {
        $this->reset([
            'expense_id',
            'user_id',
            'receipt_id',
            'invoice_id',
            'description',
            'price',
            'status_id',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * This method make more sense the model file.
     **/
    public function search($query)
    {
        $expense = new Expenses;

        return empty($query) ? $expense :
            $expense->where(function ($q) use ($query) {
                $q->where('description', 'like', '%'.$query.'%');
            });
    }

    public function redirectToDetail(string $name, $id)
    {
        return redirect()->route($name, $id);
    }
}
