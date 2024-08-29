<x-body-layout :title="$title">
    <!-- Edit Modal -->
{{--    @include('livewire.admin.invoices.edit')--}}
    <!-- Delete Confirmation Modal -->
    @include('livewire.admin.invoices.delete')
    <!-- View Modal -->
    @include('livewire.admin.invoices.view')

    <div class="card card-header shadow-blur mx-6 mt-custom opacity-9">
        <div class="row">
            <div class="col-md-3">
                <label for="search">Search: </label>
                <input wire:model.live="query" id="search" type="text" placeholder="Search..." class="form-control">
                <p class="badge badge-info" wire:model.live="resultCount">{{$resultCount}}</p>
            </div>
            <div class="col-md-3">
                <label for="orderBy">Order By: </label>
                <select wire:model.live="orderBy" id="orderBy" class="form-select">
                    <option value="invioce_id">id</option>
                    <option value="user_id">User</option>
                    <option value="name">Name</option>
                    <option value="file_name">File Name</option>
                    <option value="send_at">Send at</option>
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
                        <th>Name</th>
                        <th>User</th>
                        <th>File Name</th>
                        <th>Send at</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($paginatedInvoice as $model)
                        <tr>
                            <td>{{$model->id}}</td>
                            <td>{{$model->name}}</td>
                            <td>{{$model->user->name}}</td>
                            <td>{{$model->file_name}}</td>
                            <td>{{$model->send_at}}</td>
                            <td>
                                <button data-bs-toggle="modal" data-bs-target="#viewModal"
                                        wire:click="initData({{ $model }})"
                                        class="btn btn-outline-info btn-sm">View
                                </button>
                                <button type="button" wire:click="download({{$model}})"
                                        class="btn btn-outline-secondary btn-sm">Download</button>
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
                {{$paginatedInvoice->links()}}
            </div>
        </div>
    </div>
</x-body-layout>
