<div class="col-xl-2 col-sm-4 mb-xl-0 mb-3 py-2">
    <div class="card" >
        <a class="nav-link" href="{{ route('user-select', $user) }}">
            <div class="card-body p-1">
                <div class="row">
                    <div >
                        <div class="numbers">
                            <h5 class="font-weight-bolder mb-1">
                                {{$user->name}}
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <span class="text-start small text-sm">
                        {{$user->updated_at}}
                    </span>
                    <span class="text-success text-sm font-weight-bolder text-end">@currency($user->total()) €</span>
                </div>
            </div>
        </a>
    </div>
</div>
