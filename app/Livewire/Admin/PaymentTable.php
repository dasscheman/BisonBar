<?php

namespace App\Livewire\Admin;

use App\Models\Payment;
use App\Models\User;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentTable extends Component
{
    use AuthorizesRequests, WithPagination;

    public $title = 'Payment';
    //DataTable props
    public ?string $query = null;

    public ?string $resultCount;

    public string $orderBy = 'created_at';

    public string $orderAsc = 'desc';

    public int $perPage = 15;

    //Create, Edit, Delete, View User props
    public ?string $name = null;

    public ?int $user_id = null;

    public ?int $receipt_id = null;
    public ?int $invoice_id = null;
    public ?string $description = null;
    public ?float $price = null;
    public ?bool $add_subtract = null;
    public ?int $type_id = null;
    public ?int $status_id = null;
    public ?string $mollie_status = null;
    public ?string $mollie_id = null;
    public ?string $transaction_key = null;
    public ?float $transaction_cost = null;

    public ?DateTime $created_at = null;

    public ?DateTime $updated_at = null;


    public ?int $payment_id = null;

    public ?Payment $payment = null;




    //Update & Store Rules
    protected array $rules =
        [
            'name' => 'string',
            'user_id' => 'int',
            'receipt_id' => 'int',
            'invoice_id' => 'int',
            'description' => 'string',
            'price' => 'decimal',
            'add_subtract' => 'boolean',
            'type_id' => 'int' ,
            'status_id' => 'int' ,
            'mollie_status' => 'int',
            'mollie_id' => 'string',
            'transaction_key' => 'string',
            'transaction_cost' => 'decimal',
        ];

    protected array $messages = [
        //
    ];

    protected string $paginationTheme = 'bootstrap';

    public function render()
    {
        $paginatedPayment = $this->search($this->query)->orderBy($this->orderBy, $this->orderAsc)->paginate($this->perPage);
        //results count available with search only
        $this->resultCount = empty($this->query) ? null :
            $paginatedPayment->count().' '.Str::plural('Payment', $paginatedPayment->count()).' found';

        return view('livewire.admin.payments.table', compact('paginatedPayment'));
    }

    public function store()
    {
        $validatedData = $this->validate();
        DB::transaction(function () use ($validatedData) {
            Payment::create($validatedData);
        });
        $this->refresh('Payment successfully created!');
    }

    //Get & assign selected post props
    public function initData(Payment $payment)
    {
        // assign values to public props
        $this->payment = $payment;
        $this->payment_id = $payment->id;
        $this->name = $payment->name;
        $this->user_id = $payment->user_id;
        $this->receipt_id = $payment->receipt_id;
        $this->invoice_id = $payment->invoice_id;
        $this->description = $payment->description;
        $this->price = $payment->price;
        $this->add_subtract = $payment->add_subtract;
        $this->type_id = $payment->type_id;
        $this->status_id = $payment->status_id;
        $this->mollie_status = $payment->mollie_status;
        $this->mollie_id = $payment->mollie_id;
        $this->transaction_key = $payment->transaction_key;
        $this->transaction_cost = $payment->transaction_cost;
    }

    public function update()
    {
        $validatedData = $this->validate();
        $this->payment->update($validatedData);
        $this->refresh('Payment successfully updated!');
    }

    public function delete()
    {
        if (! empty($this->payment)) {
            DB::transaction(function () {
                $this->payment->delete();
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

    }

    public function hydrate()
    {
        $this->resetErrorBag();
    }

    public function clearFields()
    {
        $this->reset([
            'id',
            'user_id',
            'receipt_id',
            'invoice_id',
            'name',
            'description',
            'price',
            'add_subtract',
            'type_id' ,
            'status_id' ,
            'mollie_status',
            'mollie_id',
            'transaction_key',
            'transaction_cost',
            'created_at',
            'updated_at'
        ]);
    }

    /**
     * This method make more sense the model file.
     **/
    public function search($query)
    {
        $payment = new Payment();

        return empty($query) ? $payment :
            $payment->where(function ($q) use ($query) {
                $q->where('name', 'like', '%'.$query.'%');
            });
    }

    public function redirectToDetail(string $name, $id)
    {
        return redirect()->route($name, $id);
    }
}
