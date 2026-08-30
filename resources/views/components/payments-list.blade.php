<div class="card h-100">
    <div class="card-header pb-0 p-3">
        <div class="row">
            <div class="col-md-6 d-flex align-items-center">
                <h6 class="mb-0">Betalingen</h6>
            </div>
            <div class="col-md-6 text-right">
                <a class="btn btn-outline-primary btn-sm mb-0" href="{{route('payments', ['user' => $user])}}">View All</a>
            </div>
        </div>
    </div>
    <div class="card-body pt-4 p-3">
        @foreach($payments as $payment)
            <li class="list-group-item border-0 p-4 mb-2 bg-gray-100 border-radius-lg ">
                <h6 class="mb-2 text-sm">{{$payment->name . '(' .$payment->status() . ')'}}</h6>
                <div class="d-flex">
                    <div class="d-flex flex-column mr-auto">
                        <span class="mb-2 text-xs">User Name: <span
                                class="text-dark font-weight-bold ms-2">{{$payment->user->name}}</span></span>
                        <span class="mb-2 text-xs">Bedrag: <span
                                class="text-dark ms-2 font-weight-bold">{{ currency($payment->price) }}</span></span>
                    </div>
                    <div class="d-flex flex-column ">
                        <div class="text-xs">
                            <div class="text-danger text-gradient text-sm font-weight-bold">{{$payment->type()}} </div>
                            <span class="text-dark font-weight-bold">{{$payment->invoice?$payment->invoice->name:''}}</span>
                        </div>
                    </div>
                </div>
                <span class="mb-2 text-xs">Datum:
                    <span class="text-dark ms-2 font-weight-bold">{{$payment->created_at}}</span>
                </span>
            </li>
        @endforeach
    </div>
</div>
