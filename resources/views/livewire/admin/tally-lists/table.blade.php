<x-body-layout :title="$title">
    <!-- Edit Modal -->
    @include('livewire.admin.tally-lists.edit')
    <!-- Create Modal -->
    @include('livewire.admin.tally-lists.create')
    <!-- Delete Confirmation Modal -->
    @include('livewire.admin.tally-lists.delete')
    <!-- View Modal -->
    @include('livewire.admin.tally-lists.view')

    <div class="card card-header shadow-blur mx-6 mt-custom opacity-9">
        <div class="row">
            <button data-bs-toggle="modal" data-bs-target="#createModal"
                    class="btn btn-outline-success btn-outline-md mb-2 col-md-3 mx-5">Create New User
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
                    <option value="user_id">User_id</option>
                    <option value="name">Name</option>
                    <option value="created_at">Created_at</option>
                    <option value="updated_at">Updated_at</option>
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
                        <th>id</th>
                        <th>Serial number</th>
                        <th>Start date</th>
                        <th>End date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($paginatedTallyLists as $model)
                        <tr>
                            <td>{{$model->id}}</td>
                            <td>{{$model->serial_number}}</td>
                            <td>{{date('d-m-Y', strtotime($model->start_date))}}</td>
                            <td>{{date('d-m-Y', strtotime($model->end_date))}}</td>
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
                                        class="btn btn-outline-danger btn-sm">Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No user found...</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{$paginatedTallyLists->links()}}
            </div>
        </div>
    </div>
</x-body-layout>
