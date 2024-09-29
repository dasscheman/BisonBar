<?php

namespace App\Livewire\Admin;

use App\Models\Invoices;
use App\Models\User;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class InvoiceTable extends Component
{
    use AuthorizesRequests, WithPagination;

    public $title = 'Invoices';

    //DataTable props
    public ?string $query = null;

    public ?string $resultCount;

    public string $orderBy = 'created_at';

    public string $orderAsc = 'desc';

    public int $perPage = 15;

    //Create, Edit, Delete, View User props
    public ?string $name = null;

    public ?string $file_name = null;

    public ?int $user_id = null;

    public ?DateTime $send_at = null;

    public ?DateTime $created_at = null;

    public ?DateTime $updated_at = null;

    public ?int $invoice_id = null;

    public ?Invoices $invoice = null;

    //Update & Store Rules
    protected array $rules =
        [
            'name' => 'string',
            'file_name' => 'string',
            'user_id' => 'int',
            'email' => 'email',
            'send_at' => 'datetime',
        ];

    protected array $messages = [
        //
    ];

    protected string $paginationTheme = 'bootstrap';

    public function render()
    {
        $paginatedInvoice = $this->search($this->query)->orderBy($this->orderBy, $this->orderAsc)->simplePaginate($this->perPage);
        //results count available with search only
        $this->resultCount = empty($this->query) ? null :
            $paginatedInvoice->count().' '.Str::plural('invoice', $paginatedInvoice->count()).' found';

        return view('livewire.admin.invoices.table', compact('paginatedInvoice'));
    }

    public function store()
    {
        $validatedData = $this->validate();
        DB::transaction(function () use ($validatedData) {
            Invoices::create($validatedData);
        });
        $this->refresh('Invoice successfully created!');
    }

    //Get & assign selected post props
    public function initData(Invoices $invoice)
    {
        // assign values to public props
        $this->invoice = $invoice;
        $this->invoice_id = $invoice->id;
        $this->user_id = $invoice->user_id;
        $this->name = $invoice->name;
        $this->file_name = $invoice->file_name;
    }

    public function update()
    {
        $validatedData = $this->validate();
        $this->invoice->update($validatedData);
        $this->refresh('User successfully updated!');
    }

    public function delete()
    {
        if (! empty($this->invoice)) {
            DB::transaction(function () {
                $this->invoice->delete();
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
        $this->invoice = new Invoices;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
    }

    public function clearFields()
    {
        $this->reset([
            'invoice_id',
            'user_id',
            'name',
            'file_name',
            'send_at',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * This method make more sense the model file.
     **/
    public function search($query)
    {
        $invoice = new Invoices;

        return empty($query) ? $invoice :
            $invoice->where(function ($q) use ($query) {
                $q->where('name', 'like', '%'.$query.'%');
            });
    }

    public function redirectToDetail(string $name, $id)
    {
        return redirect()->route($name, $id);
    }

    public function download(Invoices $invoice)
    {
        if (! Storage::disk('local')->exists('/invoices/'.$invoice->file_name)) {
            session()->flash('message', 'Could not find file!');
            return;

//            session()->flash('message', 'Could not find file!');
//            return redirect()->to('/admin-dashboard');
        }
        $filePath = storage_path('/app/invoices/'.$invoice->file_name);

        return response()->download($filePath);
    }
}
