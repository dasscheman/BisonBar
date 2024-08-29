<div class="col-lg-8 col-md-6 mb-md-0 mb-4">
    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
                <div class="col-lg-6 col-7">
                    <h6>Projects</h6>
                    <p class="text-sm mb-0">
                        <i class="fa fa-check text-info" aria-hidden="true"></i>
                        <span class="font-weight-bold ms-1">30 done</span> this month
                    </p>
                </div>
{{--                <div class="col-lg-6 col-5 my-auto text-end">--}}
{{--                    <div class="dropdown float-lg-end pe-4">--}}
{{--                        <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                            <i class="fa fa-ellipsis-v text-secondary"></i>--}}
{{--                        </a>--}}
{{--                        <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">--}}
{{--                            <li><a class="dropdown-item border-radius-md" href="javascript:;">Action</a></li>--}}
{{--                            <li><a class="dropdown-item border-radius-md" href="javascript:;">Another action</a></li>--}}
{{--                            <li><a class="dropdown-item border-radius-md" href="javascript:;">Something else here</a></li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Year</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tallies</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payments</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Expenses</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nett</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($years as $year => $value)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{$year}}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="avatar-group mt-2">
                                        <h6 class="mb-0 text-sm">@currency($value['tally-total'])</h6>
                                    </div>
                                </td>
                                <td>
                                    <div class="avatar-group mt-2">
                                        <h6 class="mb-0 text-sm">@currency($value['payment-total'])</h6>
                                    </div>
                                </td>
                                <td>
                                    <div class="avatar-group mt-2">
                                        <h6 class="mb-0 text-sm">@currency($value['expenses-total'])</h6>
                                    </div>
                                </td>
                                <td>
                                    <div class="avatar-group mt-2">
                                        <h6 class="mb-0 text-sm">@currency($value['nett'])</h6>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
