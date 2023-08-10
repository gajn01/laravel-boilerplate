@section('title', 'Mary Grace Restaurant Operation System / Profile')
<div class="">
    <h1 class="app-page-title">Change Password</h1>
    <div class="row gy-4 mb-3 justify-content-lg-center ">
        <div class="col-12 col-lg-6">
            <div class="app-card app-card-chart h-100 shadow-sm">

                <div class="app-card-body p-3 ">
                    <form wire:submit.prevent="onSave">
                        @csrf
                        <div class="item pb-3">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-12">
                                    <div class="item-label mb-1"><strong>Current Password</strong><span class="text-danger"> *</span></div>
                                    <input type="password" class="form-control" wire:model="current_password"
                                        id="current_password" >
                                    @error('current_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="item pb-3">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-12">
                                    <div class="item-label mb-1"><strong>New Password</strong><span class="text-danger"> *</span></div>
                                    <input type="password" class="form-control" wire:model="new_password"
                                        id="new_password" >
                                    @error('new_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="item pb-3">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-12">
                                    <div class="item-label mb-1"><strong>Confirm Password</strong><span class="text-danger"> *</span></div>
                                    <input type="password" class="form-control" wire:model="confirm_password"
                                        id="confirm_password" >
                                    @error('confirm_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                            <div class="app-card-footer pt-2 mt-auto text-end">
                                <button type="button" class="btn app-btn-primary"
                                    wire:click="onChangePassword">Change Password</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
