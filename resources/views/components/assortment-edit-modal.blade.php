<!-- Modal -->
<div class="modal fade" id="assortment-update-{{$assortment->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalSignTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <h3 class="font-weight-bolder text-primary text-gradient">Join us today</h3>
                        <p class="mb-0">Enter your email and password to register</p>
                    </div>
                    <div class="card-body pb-3">
                        <form role="form text-left">
                            <label>Name</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Name" aria-label="Name"
                                       value="{{$assortment->name}}"
                                       aria-describedby="name-addon">
                                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <label>Email</label>
                            <div class="input-group mb-3">
                                <input type="price" class="form-control" placeholder="Price" aria-label="Price"
                                       value="{{$assortment->price}}"
                                       aria-describedby="price-addon">
                                @error('price') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>

                            <div class="text-center">
                                <button type="button" class="btn bg-gradient-primary btn-lg btn-rounded w-100 mt-4 mb-0">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
