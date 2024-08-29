<x-body-layout :title="$title">
    <!-- Edit Modal -->
    @include('livewire.admin.assortments.edit')
    <!-- Create Modal -->
    @include('livewire.admin.assortments.create')
    <!-- Delete Confirmation Modal -->
    @include('livewire.admin.assortments.delete')
    <!-- View Modal -->
    @include('livewire.admin.assortments.view')

    <div class="card card-header shadow-blur mx-6 mt-custom opacity-9">
        <div class="row">
            <button data-bs-toggle="modal" data-bs-target="#createModal"
                    class="btn btn-outline-success btn-outline-md mb-2 col-md-3 mx-5">{{__('Create New Assortment')}}
            </button>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label for="search">Search: </label>
                <input wire:model.live="query" id="search" type="text" placeholder="Search..." class="form-control">
                <p class="badge badge-info" wire:model.live="resultCount">{{$resultCount}}</p>
            </div>
            <div class="col-md-3">
                <label for="orderBy">Order By: </label>
                <select wire:model.live="orderBy" id="orderBy" class="form-select">
                    <option value="name">Name</option>
                    <option value="category_id">Category</option>
                    <option value="status_id">Status</option>
                    <option value="price">Price</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="direction">Order direction: </label>
                <select wire:model.live="orderAsc" id="direction" class="form-select">
                    <option value="asc">Ascending</option>
                    <option value="desc">Descending</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="perPage">Items Per Page: </label>
                <select wire:model.live="perPage" id="perPage" class="form-select">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="15">15</option>
                    <option value="20">20</option>
                </select>
            </div>
        </div>


    </div>
    <div class="card card-body shadow-blur mx-6 mt-1 opacity-9">
        @include('components.alert')
        <div class="row justify-content-center">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>name</th>
                        <th>category</th>
                        <th>status</th>
                        <th>price</th>
                        <th>Sold</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($paginatedAssortments as $model)
                        <tr>
                            <td>{{$model->name}}</td>
                            <td>{{$model->category()}}</td>
                            <td>{{$model->status()}}</td>
                            <td>@currency($model->price)</td>
                            <td>@currency($model->totalSold())</td>
                            <td>
                                <button data-bs-toggle="modal" data-bs-target="#viewModal"
                                        wire:click="initData({{ $model }})"
                                        class="btn btn-outline-info btn-sm">View
                                </button>
                                <button data-bs-toggle="modal" data-bs-target="#editModal"
                                        wire:click="initData({{ $model }})"
                                        class="btn btn-outline-primary btn-sm">Edit
                                </button>
                                <button data-bs-toggle="modal" data-bs-target="#deleteModal"
                                        wire:click="initData({{ $model }})"
                                        {{$model->tallies()->exists()?"disabled":''}}
                                        class="btn btn-outline-danger btn-sm">Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No assortment found...</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{$paginatedAssortments->links()}}
            </div>
        </div>
    </div>
</x-body-layout>
