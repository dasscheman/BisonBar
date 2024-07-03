<div class="col-md-5 mt-4">
    <div class="card h-100 mb-4">
        <div class="card-header pb-0 px-3">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-0">Your Transaction's</h6>
                </div>
                <div class="col-md-6 d-flex justify-content-end align-items-center">
                    <i class="far fa-calendar-alt me-2"></i>
                    <small>23 - 30 March 2020</small>
                </div>
            </div>
        </div>
        <div class="card-body pt-4 p-3">
            <h6 class="text-uppercase text-body text-xs font-weight-bolder mb-3">Newest</h6>
            <ul class="list-group">
                @foreach($tallies as $tally)
                    <li
                        class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                        <div class="d-flex align-items-center">
                            <button
                                class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-3 btn-sm d-flex align-items-center justify-content-center"><i
                                    class="fas fa-arrow-down"></i></button>
                            <div class="d-flex flex-column">
                                <h6 class="mb-1 text-dark text-sm">{{$tally->assortment->name}}</h6>
                                <span class="text-xs">{{$tally->created_at}}</span>
                            </div>
                        </div>
                        <div
                            class="d-flex align-items-center text-danger text-gradient text-sm font-weight-bold">
                            @currency($tally->price)
                        </div>
                    </li>
                @endforeach
                {{$tallies->links()}}
            </ul>
        </div>
    </div>
</div>
