@if (isset($message))
    <div x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 13500)"
         class="mt-3 alert alert-dark alert-dismissible fade show" role="alert">
        <span class="alert-icon text-dark"><i class="ni ni-like-2"></i></span>
        <span class="alert-text text-white">{{$message}}</span>
        <button wire:click="$set('showSuccesNotification', false)" type="button"
                class="btn-close" data-bs-dismiss="alert" aria-label="Close">
        </button>
    </div>
@endif
