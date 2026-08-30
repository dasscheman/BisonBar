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
                        <label for="name">User name:</label>
                        <input wire:model="name" type="text" class="form-control" name="name"
                               id="name"
                               title="User name" placeholder="Enter user name..." autofocus>
                        @error("name")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category:</label>
                        <select  class="form-select" aria-label="Default select example" wire:model.live="category_id" id="category_id">
                            <option value="">-- Select --</option>
                            @foreach( $assortment->getCategoryOptions() as $key=>$option)
                                <option value="{{$key}}" >{{$option}}</option>
                            @endforeach
                        </select>
                        @error("category_id")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="status_id">Status:</label>
                        <select  class="form-select" aria-label="Default select example" wire:model.live="status_id" id="status_id">
                            <option value="">-- Select --</option>
                            @foreach( $assortment->getStatusOptions() as $key=>$option)
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
