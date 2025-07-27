<x-app-layout :title="'Instellen automatisch ophogen'">
    <div class="row justify-content-evenly mt-5">
        <div class="col-md-3 mb-5">
            <div class="card card-body text-center shadow-blur mx-3">
                @include('components.alert')
                <div class="row">
                    <form name="payment-form" id="payment-form" method="POST" action="{{route('mollie.saveEditAutoPayment')}}" role="form text-left">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <select  name="amount" class="form-select" aria-label="Default select example">
                                        <option selected disabled>Open this select menu</option>
                                        @foreach($paymentAmountOptions as $key => $option)
                                            @if($user->mollie_amount == $key)
                                                <option value="{{$key}}" selected>{{$option}}</option>
                                                @continue
                                            @endif
                                            <option value="{{$key}}">{{$option}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" id="payment_key" name="payment_key" value="{{$user->pay_key}}">

                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn  bg-gradient-dark btn-md mt-4 mb-4">Sla wijziging op</button>
                    </form>
                    <form name="payment-cancel" id="payment-cancel" method="POST" action="{{route('mollie.cancelAutoPayment')}}" role="form text-left">
                        @csrf
                        <input type="hidden" id="payment_key" name="payment_key" value="{{$user->pay_key}}">
                        <button type="submit" class="btn  bg-gradient-faded-warning btn-md mt-4 mb-4">Stop automatische betaling</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
