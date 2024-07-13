<div class="col-lg-4">
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
                @foreach($user->invoices as $invoice)
                    <livewire:components.invoices :invoice="$invoice"/>
                @endforeach
            </ul>
        </div>

    </div>
</div>
