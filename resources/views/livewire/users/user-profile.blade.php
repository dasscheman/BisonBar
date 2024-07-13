<x-body-layout :title="$title">
    <div class="card card-body shadow-blur mx-6 mt-custom opacity-9">
        <div class="row gx-4">
            <div class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                <div class="nav-wrapper position-relative end-0">
                    <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                        <li class="nav-item">
                            <a wire:click=setTab('profile') class="nav-link mb-0 px-0 py-1 {{$tab=='profile'?"active":''}}"
                               data-bs-toggle="tab" href="javascript:;" role="tab"
                               aria-controls="overview" aria-selected="true">
                                <span class="ms-1">{{ __('Profiel') }} {{$tab}}</span>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a wire:click="setTab('tally')" class="nav-link mb-0 px-0 py-1 {{$tab=='tally'?"active":''}}"
                               data-bs-toggle="tab" href="javascript:;" role="tab"
                                aria-controls="teams" aria-selected="false">
                                <span class="ms-1">{{ __('Tally') }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a wire:click="setTab('invoices')" class="nav-link mb-0 px-0 py-1 {{$tab=='invoices'?"active":''}}"
                               data-bs-toggle="tab" href="javascript:;" role="tab"
                                aria-controls="dashboard" aria-selected="false">
                                <span class="ms-1">{{ __('Invoices') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">{{ __('Profile Information') }}</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    @if ($showSuccesNotification)
                        <div wire:model.live="showSuccesNotification"
                            class="mt-3 alert alert-primary alert-dismissible fade show" role="alert">
                            <span class="alert-icon text-white"><i class="ni ni-like-2"></i></span>
                            <span
                                class="alert-text text-white">{{ __('Your profile information have been successfuly saved!') }}</span>
                            <button wire:click="$set('showSuccesNotification', false)" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>
                    @endif
                    @if($tab == 'profile')
                        <livewire:Users.user-edit :user="$user"/>
                    @endif
                    @if($tab == 'tally')
                        <livewire:Users.user-tally :user="$user"/>
                    @endif
                    @if($tab == 'invoices')
                        <livewire:Users.user-invoices :user="$user"/>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-body-layout>
