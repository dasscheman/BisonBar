<x-body-layout :title="$title">
    <div class="card card-body shadow-blur mx-4 mt-custom opacity-9">
        <div class="d-grid gap-4">
            <button class="btn btn-primary fs-5 text-sm" type="button"
                @empty($selection) disabled @endempty
                @isset($selection)wire:click="save()"@endisset>
                Turven voor <u>{{$user->name}}</u> opslaan
            </button>
        </div>
        <div class="row" >
            @foreach($assortments as $assortment)
                <div class="col-sm-3">
                    <div class="card">
                        @isset($selection[$assortment->id])
                            <div class="position-absolute top-85 start-10 translate-middle badge rounded-pill bg-info"
                                wire:click="deSelect({{$assortment->id}})">
                                -
                            </div>
                        @endisset
                        @isset($selection[$assortment->id])
                            <span class="position-absolute top-15 start-90 translate-middle badge rounded-pill bg-danger">
                                {{$selection[$assortment->id]}}
                            </span>
                        @endisset
                        <div class="card-body p-4"
                            wire:click="select({{$assortment->id}})">
                            <div class="row">
                                <h5 class="text-start font-weight-bolder">
                                    {{$assortment->name}}
                                </h5>
                            </div>
                            <div class="row">
                                <span class="text-info text-sm font-weight-bolder text-start">{{$assortment->description}}
                                </span>
                                <span class="text-success text-sm font-weight-bolder text-end">{{ currency($assortment->price) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-body-layout>
