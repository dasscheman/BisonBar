<?php

namespace App\Livewire\Admin;

use App\Models\TallyList;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class TallyListTable extends Component
{
    use AuthorizesRequests, WithPagination;

    public $title = 'TallyLists';

    //DataTable props
    public ?string $query = null;

    public ?string $resultCount;

    public string $orderBy = 'created_at';

    public string $orderAsc = 'desc';

    public int $perPage = 15;

    //Create, Edit, Delete, View TallyList props

    public ?string $serial_number = null;

    public ?Date $start_date = null;

    public ?Date $end_date = null;

    public ?DateTime $created_at = null;

    public ?DateTime $updated_at = null;

    public ?int $tallylist_id = null;

    public ?TallyList $tallylist = null;

    //Update & Store Rules
    protected array $rules =
        [
            'serial_number' => 'string',
            'start_date' => 'date',
            'end_date' => 'date',
        ];

    protected array $messages = [
        //
    ];

    protected string $paginationTheme = 'bootstrap';

    public function render()
    {
        $paginatedTallyLists = $this->search($this->query)->orderBy($this->orderBy, $this->orderAsc)->paginate($this->perPage);
        //results count available with search only
        $this->resultCount = empty($this->query) ? null :
            $paginatedTallyLists->count().' '.Str::plural('tallylist', $paginatedTallyLists->count()).' found';

        return view('livewire.admin.tally-lists.table', compact('paginatedTallyLists'));
    }

    public function store()
    {
        $validatedData = $this->validate();
        \DB::transaction(function () use ($validatedData) {
            TallyList::create($validatedData);
        });
        $this->refresh('TallyList successfully created!');
    }

    //Get & assign selected post props
    public function initData(TallyList $tallylist)
    {
        // assign values to public props
        $this->tallylist = $tallylist;
        $this->tallylist_id = $tallylist->id;
        $this->serial_number = $tallylist->serial_number;
        $this->start_date = $tallylist->start_date;
        $this->end_date = $tallylist->end_date;
        $this->created_at = $tallylist->created_at;
        $this->updated_at = $tallylist->updated_at;
    }

    public function update()
    {
        $validatedData = $this->validate();
        $this->tallylist->update($validatedData);
        $this->refresh('TallyList successfully updated!');
    }

    public function delete()
    {
        if (! empty($this->tallylist)) {
            DB::transaction(function () {
                $this->tallylist->delete();
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
            'tallylist_id',
            'serial_number',
            'start_date',
            'end_date',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * This method make more sense the model file.
     **/
    public function search($query)
    {
        $tallylist = new TallyList;

        return empty($query) ? $tallylist :
            $tallylist->where(function ($q) use ($query) {
                $q->where('name', 'like', '%'.$query.'%');
            });
    }

    public function redirectToDetail(string $name, $id)
    {
        return redirect()->route($name, $id);
    }
}
