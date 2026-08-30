<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="editModal" tabindex="-1" role="dialog"
     aria-labelledby="editTallyList" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit tally list</h5>
                <button type="button" class="btn-close" wire:click.prevent="clearFields" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="update">

            <div class="form-group">
                <label for="serial_number_edit">Serial number:</label>
                <input wire:model="serial_number" type="text" class="form-control" name="serial_number"
                       id="serial_number_edit"
                       title="Serial number" placeholder="Enter serial number..." autofocus>
                @error("serial_number")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="start_date_edit">Start date:</label>
                <input wire:model="start_date" type="date" class="form-control" name="start_date"
                       id="start_date_edit"
                       title="Start date">
                <small class="text-muted">Value: {{ $start_date }}</small>
                @error("start_date")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="end_date_edit">End date:</label>
                <input wire:model="end_date" type="date" class="form-control" name="end_date"
                       id="end_date_edit"
                       title="End date">
                @error("end_date")
                    <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
                    <input wire:model.live="tallylist_id" type="hidden" name="id">
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
