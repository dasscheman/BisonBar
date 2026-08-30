@if (session('status') || session('message'))
    <div x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 10000)"
         class="mt-3 alert alert-dark alert-dismissible fade show" role="alert">
        <span class="alert-icon text-dark"><i class="ni ni-like-2"></i></span>
        <span class="alert-text text-white">{{ session('status') . session('message')}}</span>
        <button wire:click="$set('showSuccesNotification', false)" type="button"
                class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
@endif
@if (session('saved_tallie'))
    <div x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 10000)"
         class="mt-3 alert alert-dark alert-dismissible fade show" role="alert">
        <span class="alert-icon text-dark"><i class="ni ni-like-2"></i></span>
        <span class="alert-text text-white">
            {{ __('Turven opgeslagen') }}
            @foreach(session('saved_tallie') as $name => $message)
                <br>
                {{$message . ' ' . $name . ' '}}
            @endforeach
        </span>
        <button wire:click="$set('showSuccesNotification', false)" type="button"
                class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
@endif
