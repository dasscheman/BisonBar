<x-body-layout :title="$title">
    @can('admin')
        <!-- Delete Confirmation Modal -->
        @include('livewire.admin.tallies.delete')
        <!-- View Modal -->
        @include('livewire.admin.tallies.view')
    @endcan
    <div class="card card-header shadow-blur mx-6 mt-custom opacity-9">
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
                        <option value="assortment_id">assortment_id</option>
                        <option value="type_id">type_id</option>
                        <option value="status_id">status_id</option>
                        <option value="invoice_id">invoice_id</option>
                        <option value="payment_id">payment_id</option>
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
                        <th>assortment_id</th>
                        <th>user_id</th>
                        <th>count</th>
                        <th>price</th>
                        <th>type_id</th>
                        <th>status_id</th>
                        <th>invoice_id</th>
                        @can('admin')
                            <th>payment_id</th>
                            <th>Deleted at</th>
                            <th>Actions</th>
                        @endcan
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($paginatedTallies as $model)
                        <tr>
                            <td>{{$model->assortment->name}}</td>
                            @if($model->user)
                                <td><a href="{{route('user-tab', $model->user->id)}}">{{$model->user->name}}</a></td>
                            @else
                                <td></td>
                            @endif
                            <td>{{$model->count}}</td>
                            <td>{{ currency($model->price) }}</td>
                            <td>{{$model->type()}}</td>
                            <td>{{$model->status()}}</td>
                            <td>{{$model->invoice?$model->invoice->name:''}}</td>
                            @can('admin')
                                <td>{{$model->payment?$model->payment->name:''}}</td>
                                <td>{{$model->deleted_at}}</td>
                                <td>
                                    <button data-bs-toggle="modal" data-bs-target="#viewModal"
                                            wire:click="initData({{ $model }})"
                                            class="btn btn-outline-info btn-sm">View
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
                {{$paginatedTallies->links()}}
            </div>
        </div>
    </div>
</x-body-layout>
