<x-body-layout :title="$title">
    <div class="card card-body shadow-blur mx-6 mt-custom opacity-9">
        <div class="d-grid gap-4">
            <button class="btn btn-primary fs-5" type="button"
                @empty($selection) disabled @endempty
                @isset($selection)wire:click="save()"@endisset>
                Turven
            </button>
        </div>
        <div class="row my-1" >
            @foreach($assortments as $assortment)
                <div class="col-xl-3 col-sm-3 mb-xl-2 mb-4 py-2">
                    <div class="card btn btn-primary">
                        @isset($selection[$assortment->id])
                            <div class="position-absolute top-100 start-50 translate-middle badge rounded-pill bg-info"
                                wire:click="deSelect({{$assortment->id}})">
                                <div class="text-4xl fs-2 font-weight-bolder mx-2">
                                    -
                                </div>
                            </div>
                        @endisset
                        @isset($selection[$assortment->id])
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                <div class="text-4xl font-weight-bolder mx-1">
                                    {{$selection[$assortment->id]}}
                                </div>
                            </span>
                        @endisset
                        <div class="card-body p-4"
                            wire:click="select({{$assortment->id}})">
                            <div class="row">
                                <h5 class="font-weight-bolder mb-4 text-start">
                                    {{$assortment->name}}
                                </h5>
                            </div>
                            <div class="row">
                                <span class="text-info text-sm font-weight-bolder text-start">{{$assortment->description}}
                                </span>
                                <span class="text-success text-sm font-weight-bolder text-end">@currency($assortment->price) €</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-body-layout>
