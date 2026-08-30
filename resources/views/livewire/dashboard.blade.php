<div>
    <div class="page-header min-height-500 border-radius-xl"
         style="background-image: url('../assets/img/bison-logo.jpg'); background-position-y: 50%;">
        <span class="mask bg-success opacity-5">
            <h2 class="font-semibold text-xl-center text-gray-800 dark:text-gray-200 leading-tight">
                {{ __($title) }}
            </h2>
        </span>
    </div>

    <div class="card card-body shadow-blur mx-4 mt-custom opacity-9">
        @include('components.alert')
        <div class="d-md-flex justify-content-md-end">
            @if($showAll)
                <a
                    class="btn btn-success active mb-0 text-white" role="button" aria-pressed="true"
                    wire:click="toggleShowAll()">
                    Toon selectie recent actief
                </a>
            @else
                <a
                    class="btn btn-primary active mb-0 text-white" role="button" aria-pressed="true"
                    wire:click="toggleShowAll()">
                    Toon alle (alfabetisch)
                </a>
            @endif
        </div>
        <div class="row g-1">
            @foreach($users as $user)
                <livewire:components.name-tag :user="$user" wire:key="user-{{$user->id}}"/>
            @endforeach
        </div>
    </div>

    <div wire:loading.class.remove="d-none" wire:target="toggleShowAll"
         class="position-fixed top-0 start-0 w-100 h-100 d-none align-items-center justify-content-center bg-white bg-opacity-75"
         style="z-index: 9999; cursor: wait;">
        <div class="d-flex flex-column align-items-center gap-2">
            <div class="spinner-border text-success" role="status" style="width: 3rem; height: 3rem;">
                <span class="visually-hidden">Bezig met verwerken…</span>
            </div>
            <span class="text-secondary fw-medium">Bezig met verwerken…</span>
        </div>
    </div>
</div>
