<div class="col-lg-8 col-md-6 mb-md-0 mb-4">
    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
                <div class="col-lg-6 col-7">
                    <h6>Jaar overzichten</h6>
                </div>
            </div>
        </div>
        <div class="card-body px-0 pb-2">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7">Year</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Tallies</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Payments</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Expenses</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Nett</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($years as $year => $value)
                            <tr>
                                <td>
                                    <div class="px-2">
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="mb-0 text-sm">{{$year}}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="avatar-group mt-2">
                                        <h6 class="align-items-center text-end">@currency($value['tally-total'])</h6>
                                    </div>
                                </td>
                                <td>
                                    <div class="avatar-group mt-2">
                                        <h6 class="align-items-center text-end">@currency($value['payment-total'])</h6>
                                    </div>
                                </td>
                                <td>
                                    <div class="avatar-group mt-2">
                                        <h6 class="align-items-center text-end">@currency($value['expenses-total'])</h6>
                                    </div>
                                </td>
                                <td>
                                    <div class="avatar-group mt-2">
                                        <h6 class="align-items-center text-end">@currency($value['nett'])</h6>
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
