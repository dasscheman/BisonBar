<?php

namespace App\Livewire\Tallies;

use App\Models\Assortment;
use App\Models\Status;
use App\Models\Tally;
use App\Models\TallyList;
use App\Models\User;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public bool $showAll = false;

    public ?string $resultCount;

    public string $orderBy = 'created_at';

    public string $orderAsc = 'desc';

    public int $perPage = 15;

    //Create, Edit, Delete, View Tally props
    public ?string $user = null;

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

    public $tallies = null;

    public $users = [];

    public $tallyLists = [];

    public $assortments = [];

    //Update & Store Rules
    protected array $rules =
        [
            'tally_list_id' => 'required|int',
            'assortment_id' => 'required|int',
            'user_id' => 'required|int',
            'count' => 'required|int',
            'price' => 'required|decimal:0,2',
            'type_id' => 'required|int',
            'status_id' => 'required|int',
            'invoice_id' => 'nullable|int',
            'payment_id' => 'nullable|int',
        ];

    protected array $messages = [
        //
    ];

    protected string $paginationTheme = 'bootstrap';

    public function mount(Request $request)
    {
        $this->tally = new Tally();
        if ($request->get('user')) {
            $this->user = $request->get('user');
        }
        $this->users = User::select('name', 'id')->get();
        $this->tallyLists = TallyList::select('serial_number', 'id')->orderBy('id', 'desc')->get();
        $this->assortments = Assortment::select('name', 'price', 'id')->orderBy('name')->get();
        $this->type_id = Tally::TYPE_tally;
        $this->status_id = Status::STATUS_ingevoerd;
        $this->count = 1;
    }

    public function updatedAssortmentId()
    {
        $this->recalculatePrice();
    }

    public function updatedCount()
    {
        $this->recalculatePrice();
    }

    public function recalculatePrice()
    {
        $assortment = $this->assortment_id ? Assortment::find($this->assortment_id) : null;
        if ($assortment) {
            $this->price = $assortment->price * ($this->count ?: 1);
        }
    }

    public function render()
    {
        $tallies = $this->search()
            ->orderBy($this->orderBy, $this->orderAsc);

        if (!Auth::user()->can('admin')) {
            $tallies = $this->search()
                ->where('user_id', Auth::user()->id)
                ->orderBy($this->orderBy, $this->orderAsc);
        }

        if ($this->showAll) {
            $tallies = $tallies->withTrashed();
        }
        $paginatedTallies = $tallies->simplePaginate($this->perPage);

        //results count available with search only
        $this->resultCount = empty($this->query) ? null :
            $paginatedTallies->count().' '.Str::plural('tally', $paginatedTallies->count()).' found';

        return view('livewire.admin.tallies.table', compact('paginatedTallies'));
    }

    public function store()
    {
        $validatedData = $this->validate();
        if (!Auth::user()->can('admin')) {
            $validatedData['user_id'] = Auth::user()->id;
        }
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
        if (!Auth::user()->can('admin')) {
            $validatedData['user_id'] = Auth::user()->id;
        }
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
        $this->count = 1;
        $this->type_id = Tally::TYPE_tally;
        $this->status_id = Status::STATUS_ingevoerd;
    }

    /**
     * This method make more sense the model file.
     **/
    public function search()
    {
        $tally = new Tally;

        // When a search query is present, search by user name and tally list serial number
        if (! empty($this->query)) {
            $query = $this->query;

            $tally = $tally->where(function ($q) use ($query) {
                $q->whereHas('user', function ($userQuery) use ($query) {
                    $userQuery->where('name', 'like', '%'.$query.'%');
                })
                    ->orWhereHas('tallyList', function ($tallyListQuery) use ($query) {
                        $tallyListQuery->where('serial_number', 'like', '%'.$query.'%');
                    });
            });
        }

        return empty($this->user) ? $tally :
            $tally->where(function ($q) {
                $q->where('user_id', $this->user);
            });
    }

}
