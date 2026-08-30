<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="createModal" tabindex="-1" role="dialog"
     aria-labelledby="createUser" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="store">
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <input wire:model="description" type="text" class="form-control" name="description"
                               id="description"
                               title="User description" placeholder="Enter user description..." autofocus>
                        @error("description")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="user_id">User:</label>
                        <select  class="form-select" aria-label="Default select example"
                                 wire:model.live="user_id" id="user_id">
                            <option value="">-- Select --</option>
                            @foreach( App\Models\User::all()->pluck("name", "id") as $key=>$option)
                                <option value="{{$key}}" >{{$option}}</option>
                            @endforeach
                        </select>
                        @error("user_id")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

{{--                    <div class="form-group">--}}
{{--                        <label for="invoice_id">invoice id:</label>--}}
{{--                        <input wire:model="invoice_id" type="number" class="form-control" name="invoice_id"--}}
{{--                               id="invoice_id"--}}
{{--                               title="User description" placeholder="Enter invoice_id..." autofocus>--}}
{{--                        @error("invoice_id")--}}
{{--                        <span class="text-danger">{{$message}}</span>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
                    <div class="form-group">
                        <label for="receipt_id">Receipt_ id:</label>
                        <input wire:model="receipt_id" type="number" class="form-control" name="receipt_id"
                               id="receipt_id"
                               title="User description" placeholder="Enter receipt_id..." autofocus>
                        @error("receipt_id")
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status_id">Status:</label>
                        <select  class="form-select" aria-label="Default select example"
                                 wire:model.live="status_id" id="status_id">
                            <option value="">-- Select --</option>
                            @foreach( $expense->getStatusOptions() as $key=>$option)
                                <option value="{{$key}}" >{{$option}}</option>
                            @endforeach
                        </select>
                        @error("status_id")
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input wire:model="price" type="number" class="form-control" name="price"
                               id="price"
                               title="Price" placeholder="Enter price..." autofocus>
                        @error("price")
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" wire:click.prevent="clearFields" data-bs-dismiss="modal">Close</button>
                <button wire:click.prevent="store" type="submit" class="btn btn-outline-primary">Submit
                </button>
            </div>
        </div>
    </div>
</div>
