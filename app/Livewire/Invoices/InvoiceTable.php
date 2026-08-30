<?php

namespace App\Livewire\Invoices;

use App\Mail\InvoiceSend;
use App\Models\Invoices;
use App\Models\User;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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

    public bool $showAll = false;

    public ?string $resultCount;

    public string $orderBy = 'created_at';

    public string $orderAsc = 'desc';

    public int $perPage = 15;

    //Create, Edit, Delete, View User props
    public ?string $user = null;

    public ?string $name = null;

    public ?string $file_name = null;

    public ?int $user_id = null;

    public ?DateTime $send_at = null;

    public ?DateTime $created_at = null;

    public ?DateTime $updated_at = null;

    public ?int $invoice_id = null;

    public ?Invoices $invoice = null;

    public $invoices = null;

    public $users = [];

    public $showSuccesNotification = true;
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

    public function mount(Request $request)
    {
        $this->invoice = new Invoices;
        if ($request->get('user')) {
            $this->user = $request->get('user');
        }
        $this->users = User::select('name', 'id')->get();
    }

    public function render()
    {
        $invoice = $this->search()
            ->orderBy($this->orderBy, $this->orderAsc);

        if (!Auth::user()->can('admin')) {
            $invoice = $this->search()
                ->where('user_id', Auth::user()->id)
                ->orderBy($this->orderBy, $this->orderAsc);
        }
        if ($this->showAll) {
            $invoice = $invoice->withTrashed();
        }

        $paginatedInvoice = $invoice->paginate($this->perPage);

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
                $this->invoice->recalculate();
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
    public function search()
    {
        $invoice = new Invoices;
        $invoice =  empty($this->query) ? $invoice :
            $invoice->where(function ($q) {
                $q->where('name', 'like', '%'.$this->query.'%');
            });

        return empty($this->user) ? $invoice :
            $invoice->where(function ($q) {
                $q->where('user_id', $this->user);
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
        }
        $filePath = storage_path('/app/invoices/'.$invoice->file_name);

        return response()->download($filePath);
    }

    public function sendInvoice(Invoices $invoice)
    {
        if(!Mail::to($invoice->user->email)->send(new InvoiceSend($invoice))) {
            session()->flash('message', 'Lukt niet om een invoice te verzenden voor: ' . $invoice->user->name);
        }

        DB::transaction(function () use($invoice) {
            $invoice->send_at = now();
            if (!$invoice->save()) {
                session()->flash('message', 'Lukt niet om invoice status op te slaan voor voor: ' . $invoice->user->name);
            }
            $invoice->sendInvoice();
            session()->flash('message', 'Invoice verzonden.');
        });
    }
}
