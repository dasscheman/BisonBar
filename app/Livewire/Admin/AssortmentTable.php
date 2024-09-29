<?php

namespace App\Livewire\Admin;

use App\Models\Assortment;
use App\Models\User;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class AssortmentTable extends Component
{
    use AuthorizesRequests, WithPagination;

    public $title = 'Assortment';

    //DataTable props
    public ?string $query = null;

    public ?string $resultCount;

    public string $orderBy = 'created_at';

    public string $orderAsc = 'desc';

    public int $perPage = 15;

    //Create, Edit, Delete, View User props
    public ?string $name = null;

    public ?int $category_id = null;

    public ?int $status_id = null;

    public ?string $description = null;

    public $price = null;

    public ?DateTime $created_at = null;

    public ?DateTime $updated_at = null;

    public ?int $assortment_id = null;

    public ?Assortment $assortment = null;

    //Update & Store Rules
    protected array $rules =
        [
            'name' => 'string',
            'category_id' => 'int',
            'status_id' => 'int',
            'price' => 'decimal:2',
        ];

    protected array $messages = [
        //
    ];

    protected string $paginationTheme = 'bootstrap';

    public function render()
    {
        $paginatedAssortments = $this->search($this->query)->orderBy($this->orderBy, $this->orderAsc)->paginate($this->perPage);
        //results count available with search only
        $this->resultCount = empty($this->query) ? null :
            $paginatedAssortments->count().' '.Str::plural('user', $paginatedAssortments->count()).' found';

        return view('livewire.admin.assortments.table', compact('paginatedAssortments'));
    }

    public function store()
    {
        $validatedData = $this->validate();
        \DB::transaction(function () use ($validatedData) {
            Assortment::create($validatedData);
        });
        $this->refresh('Assortment successfully created!');
    }

    //Get & assign selected post props
    public function initData(Assortment $assortment)
    {
        // assign values to public props
        $this->assortment = $assortment;
        $this->assortment_id = $assortment->id;
        $this->name = $assortment->name;
        $this->category_id = $assortment->category_id;
        $this->status_id = $assortment->status_id;
        $this->price = number_format($assortment->price, 2);
    }

    public function update()
    {
        $validatedData = $this->validate();
        $this->assortment->update($validatedData);
        $this->refresh('Assortment successfully updated!');
    }

    public function delete()
    {
        if (! empty($this->assortment)) {
            DB::transaction(function () {
                $this->assortment->delete();
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
        $this->assortment = new Assortment;
    }

    public function hydrate()
    {
        $this->resetErrorBag();
    }

    public function clearFields()
    {
        $this->reset([
            'assortment_id',
            'name',
            'price',
            'category_id',
            'status_id',
        ]);
    }

    /**
     * This method make more sense the model file.
     **/
    public function search($query)
    {
        $assortment = new Assortment;

        return empty($query) ? $assortment :
            $assortment->where(function ($q) use ($query) {
                $q->where('name', 'like', '%'.$query.'%');
            });
    }

    public function redirectToDetail(string $name, $id)
    {
        return redirect()->route($name, $id);
    }
}
