
<div class="row">
    <div class="col-md-6">
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
                </ul>
                {{$tallies->links()}}
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">Billing Information</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <ul class="list-group">
                    <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                        <div class="d-flex flex-column">
                            <h6 class="mb-3 text-sm">Oliver Liam</h6>
                            <span class="mb-2 text-xs">Company Name: <span
                                    class="text-dark font-weight-bold ms-2">Viking Burrito</span></span>
                            <span class="mb-2 text-xs">Email Address: <span
                                    class="text-dark ms-2 font-weight-bold">oliver@burrito.com</span></span>
                            <span class="text-xs">VAT Number: <span
                                    class="text-dark ms-2 font-weight-bold">FRB1235476</span></span>
                        </div>
                        <div class="ms-auto">
                            <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i
                                    class="far fa-trash-alt me-2"></i>Delete</a>
                            <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i
                                    class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>
                        </div>
                    </li>
                    <li class="list-group-item border-0 d-flex p-4 mb-2 mt-3 bg-gray-100 border-radius-lg">
                        <div class="d-flex flex-column">
                            <h6 class="mb-3 text-sm">Lucas Harper</h6>
                            <span class="mb-2 text-xs">Company Name: <span
                                    class="text-dark font-weight-bold ms-2">Stone Tech Zone</span></span>
                            <span class="mb-2 text-xs">Email Address: <span
                                    class="text-dark ms-2 font-weight-bold">lucas@stone-tech.com</span></span>
                            <span class="text-xs">VAT Number: <span
                                    class="text-dark ms-2 font-weight-bold">FRB1235476</span></span>
                        </div>
                        <div class="ms-auto">
                            <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i
                                    class="far fa-trash-alt me-2"></i>Delete</a>
                            <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i
                                    class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>
                        </div>
                    </li>
                    <li class="list-group-item border-0 d-flex p-4 mb-2 mt-3 bg-gray-100 border-radius-lg">
                        <div class="d-flex flex-column">
                            <h6 class="mb-3 text-sm">Ethan James</h6>
                            <span class="mb-2 text-xs">Company Name: <span
                                    class="text-dark font-weight-bold ms-2">Fiber Notion</span></span>
                            <span class="mb-2 text-xs">Email Address: <span
                                    class="text-dark ms-2 font-weight-bold">ethan@fiber.com</span></span>
                            <span class="text-xs">VAT Number: <span
                                    class="text-dark ms-2 font-weight-bold">FRB1235476</span></span>
                        </div>
                        <div class="ms-auto">
                            <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i
                                    class="far fa-trash-alt me-2"></i>Delete</a>
                            <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i
                                    class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>Edit</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>
