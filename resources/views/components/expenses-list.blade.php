<div class="col-lg-4 col-md-5">
    <div class="card h-100">
        <div class="card-header pb-0">
            <h6>Expenses overview</h6>
        </div>
        <div class="card-body p-3">
            <div class="timeline timeline-one-side">
                @foreach($expenses as $expense)
                    <div class="timeline-block mb-2">
                        <span class="timeline-step my-6">
                            <i class="ni ni-bell-55 text-success text-gradient"></i>
                        </span>
                        <div class="timeline-content">
                            <div class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex flex-column">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">{{$expense->description}}

                                    </h6>

                                    <div class="text-primary font-weight-bold text-xs mt-1 mb-0">
                                        @currency($expense->price)
                                    </div>

                                </div>
                                <div class="d-flex align-items-center text-sm">
                                    <div class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                        {{$expense->user->name}}
                                        {{$expense->created_at}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{$expenses->links()}}
            </div>
        </div>
    </div>
</div>
