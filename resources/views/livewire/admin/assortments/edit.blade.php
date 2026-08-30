<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="editModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                <button type="button" class="btn-close" wire:click.prevent="clearFields" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="update">
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
                        <label for="status_id">Category:</label>
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
                               title="Price" placeholder="Enter price..." autofocus
                               {{$assortment->tallies()->exists()?"disabled":''}}>
                        @error("price")
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                        @if($assortment->tallies()->exists())
                            <span class="text-warning">{{__('When assortment has tallies, you can not change the price.')}}</span>
                        @endif
                    </div>
                    <input wire:model.live="user_id" type="hidden" name="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" wire:click.prevent="clearFields" data-bs-dismiss="modal">Close</button>
                <button type="submit" wire:click.prevent="update"
                        class="btn btn-outline-primary" data-bs-dismiss="modal">Update
                </button>
            </div>
        </div>
    </div>
</div>
