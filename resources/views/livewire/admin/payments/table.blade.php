<x-body-layout :title="$title">
    <!-- Edit Modal -->
    @include('livewire.admin.payments.edit')
    <!-- Create Modal -->
    @include('livewire.admin.payments.create')
    <!-- Delete Confirmation Modal -->
    @include('livewire.admin.payments.delete')
    <!-- View Modal -->
    @include('livewire.admin.payments.view')

    <div class="card card-header shadow-blur mx-6 mt-custom opacity-9">
        @can('admin')
            <div class="row">
                <button data-bs-toggle="modal" data-bs-target="#createExpensesModal"
                        class="btn btn-outline-success btn-outline-md mb-2 col-md-3 mx-5">Add payment
                </button>
            </div>
        @endcan
        <div class="row">
            <div class="col-md-3">
                <label for="search">Search: </label>
                <input wire:model.live="query" id="search" type="text" placeholder="Search..." class="form-control">
                <p class="badge badge-info" wire:model.live="resultCount">{{$resultCount}}</p>
            </div>

            @can('admin')
                <div class="col-md-2">
                    <label for="user">User: </label>
                    <select wire:model.live="user" id="user" class="form-select">
                        <option value="">All</option>
                        @foreach($users as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="orderBy">Order By: </label>
                    <select wire:model.live="orderBy" id="orderBy" class="form-select">
                        <option value="user_id">User_id</option>
                        <option value="name">Name</option>
                        <option value="created_at">Created_at</option>
                        <option value="updated_at">Updated_at</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="direction">Order direction: </label>
                    <select wire:model.live="orderAsc" id="direction" class="form-select">
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label for="perPage">Items Per Page: </label>
                    <select wire:model.live="perPage" id="perPage" class="form-select">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <label for="showAll">Show deleted</label>
                    <div class="custom-control">
                        <input wire:model.live="showAll"  id="showAll" type="checkbox" class="custom-control-input">
                    </div>
                </div>
            @endcan
        </div>


    </div>
    <div class="card card-body shadow-blur mx-6 mt-1 opacity-9">
        @include('components.alert')
        <div class="row justify-content-center">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        @can('admin')
                            <th>User</th>
                            <th>receipt_id</th>
                        @endcan
                        <th>date</th>
                        <th>invoice_id</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Price</th>
                        @can('admin')
                            <th>Deleted at</th>
                            <th>Actions</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($paginatedPayment as $model)
                        <tr>
                            <td>{{$model->name}}</td>
                            <td>{{$model->description}}</td>
                            @can('admin')
                                <td>{{($model->user?$model->user->name:'n.v.t')}}</td>
                                <td>{{$model->receipt_id}}</td>
                            @endcan
                            <td>{{$model->date}}</td>
                            <td>{{$model->invoice_id}}</td>
                            <td>{{ $model->type() }}</td>
                            <td>{{ $model->status() }}</td>
                            <td>{{ currency($model->price) }}</td>
                            @can('admin')
                                <td>{{$model->deleted_at}}</td>
                                <td>
                                    @if($model->status_id == \App\Models\Status::STATUS_ingevoerd)
                                        <button wire:click="check({{ $model }})"
                                                class="btn btn-outline-info btn-sm">check
                                        </button>
                                    @endif

                                    <button data-bs-toggle="modal" data-bs-target="#viewModal"
                                            wire:click="initData({{ $model }})"
                                            class="btn btn-outline-info btn-sm">View
                                    </button>
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
                            @endcan
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No user found...</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{$paginatedPayment->links()}}
            </div>
        </div>
    </div>
</x-body-layout>
