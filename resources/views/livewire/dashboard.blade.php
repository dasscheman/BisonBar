<x-body-layout :title="$title">
    <div class="card card-body shadow-blur mx-6 mt-custom opacity-9">
        @include('components.alert')
        <div class="d-md-flex justify-content-md-end my-4">
            @if($showAll)
                <a
                    class="btn btn-success active mb-0 text-white" role="button" aria-pressed="true"
                    wire:click="toggleShowAll()">
                    Toon selectie
                </a>
            @else
                <a
                    class="btn btn-primary active mb-0 text-white" role="button" aria-pressed="true"
                    wire:click="toggleShowAll()">
                    Toon alle
                </a>
            @endif
        </div>
        <div class="row g-1">
            @foreach($users as $user)
                <livewire:components.name-tag :user="$user" wire:key="user-{{$user->id}}"/>
            @endforeach
        </div>
    </div>
</x-body-layout>
