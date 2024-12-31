<div wire:ignore.self class="modal fade" id="viewModal" tabindex="-1" role="dialog"
     aria-labelledby="viewPost" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">User Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h6 class="text-decoration-underline">Assortment</h6>
                    <p class="text-muted">{{$tally?$tally->assortment->name:''}}</p>
                <hr>
                <h6 class="text-decoration-underline">User</h6>
                    <p class="text-muted">{{$tally?$tally->user->name:''}}</p>
                <hr>

                <h6 class="text-decoration-underline">Count</h6>
                    <p class="text-muted">{{$count}}</p>
                <hr>

                <h6 class="text-decoration-underline">Price</h6>
                    <p class="text-muted">@currency($price)</p>
                <hr>

                <h6 class="text-decoration-underline">Type</h6>
                    <p class="text-muted">{{$tally?$tally->type():''}}</p>
                <hr>

                <h6 class="text-decoration-underline">Status</h6>
                    <p class="text-muted">{{$tally?$tally->status():''}}</p>
                <hr>

                <h6 class="text-decoration-underline">Invoice</h6>
                    <p class="text-muted">{{$tally&&$tally->invoice?$tally->invoice->name:''}}</p>
                <hr>

                <h6 class="text-decoration-underline">Payment</h6>
                    <p class="text-muted">{{$tally&&$tally->payment?$tally->payment->name:''}}</p>
                <hr>

                <h6 class="text-decoration-underline">Created_at</h6>
                    <p class="text-muted">{{$created_at}}</p>
                <hr>

                <h6 class="text-decoration-underline">Updated_at</h6>
                    <p class="text-muted">{{$updated_at}}</p>
                <hr>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
