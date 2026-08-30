<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="editModal" tabindex="-1" role="dialog"
     aria-labelledby="editTally" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTally">Edit Tally</h5>
                <button type="button" class="btn-close" wire:click.prevent="clearFields" data-bs-dismiss="modal"
                        aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="update">
                    <div class="form-group">
                        <label for="tally_list_id">Tally list:</label>
                        <select class="form-select" aria-label="Select tally list" wire:model.live="tally_list_id"
                                id="tally_list_id">
                            <option value="">-- Select --</option>
                            @foreach($tallyLists as $tallyList)
                                <option value="{{$tallyList->id}}">{{$tallyList->serial_number}}</option>
                            @endforeach
                        </select>
                        @error("tally_list_id")
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="assortment_id">Assortment:</label>
                        <select class="form-select" aria-label="Select assortment" wire:model.live="assortment_id"
                                id="assortment_id">
                            <option value="">-- Select --</option>
                            @foreach($assortments as $assortment)
                                <option value="{{$assortment->id}}">{{$assortment->name}} ({{currency($assortment->price)}})</option>
                            @endforeach
                        </select>
                        @error("assortment_id")
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    @can('admin')
                        <div class="form-group">
                            <label for="user_id">User:</label>
                            <select class="form-select" aria-label="Select user" wire:model.live="user_id" id="user_id">
                                <option value="">-- Select --</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                            @error("user_id")
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                    @endcan
                    <div class="form-group">
                        <label for="count">Count:</label>
                        <input wire:model.live="count" type="number" min="1" class="form-control" name="count"
                               id="count" title="Count" placeholder="Enter count..." autofocus>
                        @error("count")
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input wire:model.live="price" type="number" step="0.01" class="form-control" name="price"
                               id="price" title="Price" placeholder="Enter price...">
                        @error("price")
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="type_id">Type:</label>
                        <select class="form-select" aria-label="Select type" wire:model.live="type_id" id="type_id">
                            <option value="">-- Select --</option>
                            @foreach($tally->getTypeOptions() as $key => $option)
                                <option value="{{$key}}">{{$option}}</option>
                            @endforeach
                        </select>
                        @error("type_id")
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status_id">Status:</label>
                        <select class="form-select" aria-label="Select status" wire:model.live="status_id"
                                id="status_id">
                            <option value="">-- Select --</option>
                            @foreach(\App\Models\Status::getStatusOptions() as $key => $option)
                                <option value="{{$key}}">{{$option}}</option>
                            @endforeach
                        </select>
                        @error("status_id")
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <input wire:model.live="tally_id" type="hidden" name="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" wire:click.prevent="clearFields"
                        data-bs-dismiss="modal">Close
                </button>
                <button type="submit" wire:click.prevent="update"
                        class="btn btn-outline-primary" data-bs-dismiss="modal">Update
                </button>
            </div>
        </div>
    </div>
</div>