<div class="card h-100">
    <div class="card-header pb-0">
        <h6>Payments</h6>
    </div>
    <div class="card-body pt-4 p-3">
        @foreach($payments as $payment)
            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg ">
                <div class="d-flex flex-column">
                    <h6 class="mb-3 text-sm">{{$payment->name}}</h6>
                    <span class="mb-2 text-xs">User Name: <span
                            class="text-dark font-weight-bold ms-2">{{$payment->user->name}}</span></span>
                    <span class="mb-2 text-xs">Datum: <span
                            class="text-dark ms-2 font-weight-bold">{{$payment->created_at}}</span></span>
                </div>
                <div class="d-sm-flex">
                    <a class="btn btn-link text-danger text-gradient px-3 mb-0" href="javascript:;"><i
                            class="far fa-trash-alt me-2"></i>{{$payment->status()}}</a>
                    <a class="btn btn-link text-dark px-3 mb-0" href="javascript:;"><i
                            class="fas fa-pencil-alt text-dark me-2" aria-hidden="true"></i>{{$payment->type()}}</a>
                </div>
            </li>
        @endforeach
        {{$payments->links()}}
    </div>
</div>
