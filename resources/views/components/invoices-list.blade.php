<div class="card h-100">
    <div class="card-header pb-0 p-3">
        <div class="row">
            <div class="col-md-6 d-flex align-items-center">
                <h6 class="mb-0">Invoices</h6>
            </div>
            <div class="col-md-6 text-right">
                <button class="btn btn-outline-primary btn-sm mb-0">View All</button>
            </div>
        </div>
    </div>
    <div class="card-body p-3 pb-0">
        <ul class="list-group">
            @foreach($invoices as $invoice)
                <li
                    class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                    <div class="d-flex flex-column">
                        <h6 class="mb-1 text-dark font-weight-bold text-sm">{{$invoice->name}}</h6>
                        <span class="text-xs">{{$invoice->created_at}}</span>
                    </div>
                    <div class="d-flex align-items-center text-sm">
                        @currency($invoice->totalOnDate()) €
                        <button class="btn btn-link text-dark text-sm mb-0 px-0 ms-4" wire:click="download({{$invoice}})"><i
                                class="fas fa-file-pdf text-lg me-1"></i> PDF</button>
                    </div>
                </li>
            @endforeach
            {{$invoices->links()}}
        </ul>
    </div>
</div>
