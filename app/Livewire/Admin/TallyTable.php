<?php

namespace App\Livewire\Admin;

use App\Models\Tally;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class TallyTable extends Component
{
    use AuthorizesRequests, WithPagination;

    public $title = 'Tallys';

    //DataTable props
    public ?string $query = null;

    public ?string $resultCount;

    public string $orderBy = 'created_at';

    public string $orderAsc = 'desc';

    public int $perPage = 15;

    //Create, Edit, Delete, View Tally props

    public ?int $tally_list_id = null;

    public ?int $assortment_id = null;

    public ?int $user_id = null;

    public ?int $count = null;

    public ?float $price = null;

    public ?int $type_id = null;

    public ?int $status_id = null;

    public ?int $invoice_id = null;

    public ?int $payment_id = null;

    public ?DateTime $created_at = null;

    public ?DateTime $updated_at = null;

    public ?int $tally_id = null;

    public ?Tally $tally = null;

    //Update & Store Rules
    protected array $rules =
        [
            'tally_list_id' => 'int',
            'assortment_id' => 'int',
            'user_id' => 'int',
            'count' => 'int',
            'price' => 'decimal',
            'type_id' => 'int',
            'status_id' => 'int',
            'invoice_id' => 'int',
            'payment_id' => 'int',
        ];

    protected array $messages = [
        //
    ];

    protected string $paginationTheme = 'bootstrap';

    public function render()
    {
        $paginatedTallys = $this->search($this->query)->orderBy($this->orderBy, $this->orderAsc)->paginate($this->perPage);
        //results count available with search only
        $this->resultCount = empty($this->query) ? null :
            $paginatedTallys->count().' '.Str::plural('tally', $paginatedTallys->count()).' found';

        return view('livewire.admin.tallys.table', compact('paginatedTallys'));
    }

    public function store()
    {
        $validatedData = $this->validate();
        \DB::transaction(function () use ($validatedData) {
            Tally::create($validatedData);
        });
        $this->refresh('Tally successfully created!');
    }

    //Get & assign selected post props
    public function initData(Tally $tally)
    {
        // assign values to public props
        $this->tally = $tally;
        $this->tally_id = $tally->id;

        $this->tally_list_id = $tally->tally_list_id;
        $this->assortment_id = $tally->assortment_id;
        $this->user_id = $tally->user_id;
        $this->count = $tally->count;
        $this->price = $tally->price;
        $this->type_id = $tally->type_id;
        $this->status_id = $tally->status_id;
        $this->invoice_id = $tally->invoice_id;
        $this->payment_id = $tally->payment_id;
        $this->created_at = $tally->created_at;
        $this->updated_at = $tally->updated_at;

    }

    public function update()
    {
        $validatedData = $this->validate();
        $this->tally->update($validatedData);
        $this->refresh('Tally successfully updated!');
    }

    public function delete()
    {
        if (! empty($this->tally)) {
            DB::transaction(function () {
                $this->tally->delete();
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

    public function mount() {}

    public function hydrate()
    {
        $this->resetErrorBag();
    }

    public function clearFields()
    {
        $this->reset([
            'tally_id',
            'tally_list_id',
            'assortment_id',
            'user_id',
            'count',
            'price',
            'type_id',
            'status_id',
            'invoice_id',
            'payment_id',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * This method make more sense the model file.
     **/
    public function search($query)
    {
        $tally = new Tally;

        return empty($query) ? $tally :
            $tally->where(function ($q) use ($query) {
                $q->where('name', 'like', '%'.$query.'%');
            });
    }

    public function redirectToDetail(string $name, $id)
    {
        return redirect()->route($name, $id);
    }
}
