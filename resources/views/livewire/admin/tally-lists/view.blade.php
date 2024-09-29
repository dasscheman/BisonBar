<div wire:ignore.self class="modal fade" id="viewModal" tabindex="-1" role="dialog"
     aria-labelledby="viewPost" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">User Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                    <h6 class="text-decoration-underline">id</h6>
                        <p class="text-muted">{{$tallylist_id}}</p>
                    <hr>

                    <h6 class="text-decoration-underline">Serial Number</h6>
                        <p class="text-muted">{{$serial_number}}</p>
                    <hr>

                    <h6 class="text-decoration-underline">Start date</h6>
                        <p class="text-muted">{{$start_date}}</p>
                    <hr>

                    <h6 class="text-decoration-underline">End date</h6>
                        <p class="text-muted">{{$end_date}}</p>
                    <hr>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
