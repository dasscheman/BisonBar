<div wire:ignore.self class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="createExpensesModal" tabindex="-1" role="dialog"
     aria-labelledby="createExpense" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Betaling toevoegen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit="store">
                    <div class="form-group">
                        <label for="user_id">User:</label>
                        <select  class="form-select" aria-label="Default select example" wire:model.live="user_id" id="user_id">
                            <option value="">-- Select --</option>
                            @foreach( App\Models\User::all()->pluck("name", "id") as $key=>$option)
                                <option value="{{$key}}" >{{$option}}</option>
                            @endforeach
                        </select>
                        @error("user_id")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="receipt_id">Bonnummer</label>
                        <input wire:model="receipt_id" type="int" class="form-control" name="receipt_id"
                               id="receipt_id"
                               title="receipt_id" placeholder="Enter receipt_id..." autofocus>
                        @error("receipt_id")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Naam:</label>
                        <input wire:model="name" type="text" class="form-control" name="name"
                               id="name"
                               title="name" placeholder="Enter name..." autofocus>
                        @error("name")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Omschrijving:</label>
                        <input wire:model="description" type="text" class="form-control" name="description"
                               id="description"
                               title="description" placeholder="Enter omschrijving..." autofocus>
                        @error("description")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Bedrag</label>
                        <input wire:model="price" type="number" class="form-control" name="price"
                               id="price"
                               title="price" placeholder="Enter amount..." autofocus>
                        @error("price")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="add_subtract">Bij/Af:</label>
                        <select  class="form-select" aria-label="Default select example" wire:model.live="add_subtract" id="add_subtract">
                            <option value="">-- Select --</option>
                            <option value="{{\App\Models\Payment::ADDSUBTRACT_ADD}}" >Bij</option>
                            <option value="{{\App\Models\Payment::ADDSUBTRACT_SUBTRACT}}" >Af</option>
                        </select>
                        @error("add_subtract")
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="type_id">Type:</label>
                        <select  class="form-select" aria-label="Default select example" wire:model.live="type_id" id="type_id">
                            <option value="">-- Select --</option>
                            @foreach( App\Models\PaymentType::getTypeOptions() as $key=>$option)
                                <option value="{{$key}}" >{{$option}}</option>
                            @endforeach
                        </select>
                        @error("type_id")
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input wire:model="date" type="date" class="form-control" name="date"
                               id="date"
                               title="date" placeholder="Enter date..." autofocus>
                        @error("date")
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
