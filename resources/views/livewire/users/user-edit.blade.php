
<form wire:submit.prevent="save" action="#" method="POST" role="form text-left">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name" class="form-control-label">{{ __('Full Name') }}</label>
                <div class="@error('name')border border-danger rounded-3 @enderror">
                    <input wire:model="name" class="form-control" type="text" placeholder="Name"
                            name="user.namee"
{{--                           id="site_name"--}}
                           id="name">
                </div>
                @error('name') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="email" class="form-control-label">{{ __('Email') }}</label>
                <div class="@error('email')border border-danger rounded-3 @enderror">
                    <input wire:model="email" class="form-control" type="email"
                           placeholder="@example.com" id="user-email">
                </div>
                @error('email') <div class="text-danger">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Save Changes' }}</button>
    </div>
</form>
