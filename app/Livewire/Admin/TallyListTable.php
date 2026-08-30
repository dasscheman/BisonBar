<?php

namespace App\Livewire\Admin;

use App\Models\TallyList;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class TallyListTable extends Component
{
    use AuthorizesRequests, WithPagination;

    public string $title = 'TallyLists';

    // DataTable props
    public ?string $query = null;

    public ?string $resultCount = null;

    public string $orderBy = 'created_at';

    public string $orderAsc = 'desc';

    public int $perPage = 15;

    // Create, Edit, Delete, View TallyList props
    public ?string $serial_number = null;

    // Stored as date strings from the form/DB; validated as 'date' in $rules
    public ?string $start_date = null;

    public ?string $end_date = null;

    public ?DateTime $created_at = null;

    public ?DateTime $updated_at = null;

    public ?int $tallylist_id = null;

    public ?TallyList $tallylist = null;

    // Update & Store Rules
    protected array $rules = [
        'serial_number' => 'string',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected array $messages = [];

    protected string $paginationTheme = 'bootstrap';

    public function render()
    {
        $paginatedTallyLists = $this->search($this->query)
            ->orderBy($this->orderBy, $this->orderAsc)
            ->paginate($this->perPage);

        // Results count available with search only
        $this->resultCount = empty($this->query)
            ? null
            : $paginatedTallyLists->count().' '.Str::plural('tallylist', $paginatedTallyLists->count()).' found';

        return view('livewire.admin.tally-lists.table', compact('paginatedTallyLists'));
    }

    public function store()
    {
        $validatedData = $this->validate();

        DB::transaction(function () use ($validatedData) {
            TallyList::create($validatedData);
        });

        $this->refresh('TallyList successfully created!');
    }

    // Get & assign selected tally list props
    public function initData(int $tallylistId): void
    {
        $tallylist = TallyList::findOrFail($tallylistId);

        $this->tallylist = $tallylist;
        $this->tallylist_id = $tallylist->id;
        $this->serial_number = $tallylist->serial_number;

        // Format for HTML date inputs (expects Y-m-d)
        $this->start_date = $tallylist->start_date
            ? $tallylist->start_date->format('Y-m-d')
            : null;

        $this->end_date = $tallylist->end_date
            ? $tallylist->end_date->format('Y-m-d')
            : null;

        $this->created_at = $tallylist->created_at;
        $this->updated_at = $tallylist->updated_at;
    }

    public function update()
    {
        $validatedData = $this->validate();

        if ($this->tallylist) {
            $this->tallylist->update($validatedData);
        }

        $this->refresh('TallyList successfully updated!');
    }

    public function delete()
    {
        if ($this->tallylist) {
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

        // Close the active modal
        $this->dispatch('hideModal');
    }

    public function mount()
    {
        // No-op, kept for compatibility
    }

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
            'tallylist',
        ]);
    }

    /**
     * Simple search on serial_number, since la_tally_lists has no name column.
     */
    public function search(?string $query)
    {
        $tallylist = TallyList::query();

        if (empty($query)) {
            return $tallylist;
        }

        return $tallylist->where(function ($q) use ($query) {
            $q->where('serial_number', 'like', '%'.$query.'%');
        });
    }

    public function redirectToDetail(string $name, $id)
    {
        return redirect()->route($name, $id);
    }
}
