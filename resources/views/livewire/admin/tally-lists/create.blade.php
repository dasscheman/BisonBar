<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="createModal" tabindex="-1" role="dialog"
     aria-labelledby="createTallyList" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create new tally list</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="store">

            <div class="form-group">
                <label for="serial_number">Serial number:</label>
                <input wire:model="serial_number" type="text" class="form-control" name="serial_number"
                       id="serial_number"
                       title="Serial number" placeholder="Enter serial number..." autofocus>
                @error("serial_number")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="start_date">Start date:</label>
                <input wire:model="start_date" type="date" class="form-control" name="start_date"
                       id="start_date"
                       title="Start date">
                @error("start_date")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="end_date">End date:</label>
                <input wire:model="end_date" type="date" class="form-control" name="end_date"
                       id="end_date"
                       title="End date">
                @error("end_date")
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
