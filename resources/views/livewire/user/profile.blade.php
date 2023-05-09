@section('title', 'Mary Grace Restaurant Operation System / Profile')
<div class="container-xl">
    <h1 class="app-page-title">My Account</h1>
    <div class="row gy-4 mb-3">
        <div class="col-12 col-lg-12">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">Profile</h4>
                        </div>
                        <div class="col-auto ">
                            <div class="card-header-action col ">
                                <a class="btn app-btn-primary" wire:click="onUpdate(true)">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-card-body p-3 ">
                    <form wire:submit.prevent="onSave">
                        @csrf
                        <div class="item border-bottom py-3">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-12">
                                    <div class="item-label mb-1"><strong>Employee ID</strong></div>
                                    @if ($is_edit)
                                        <input type="text" class="form-control" wire:model="input_employee_id"
                                            id="input_employee_id" value="{{ $user->employee_id }}">
                                        @error('input_employee_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    @else
                                        <div class="item-data">{{ $user->employee_id }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="item border-bottom py-3">
                            <div class="row ">
                                <div class="col-12">
                                    <div class="item-label mb-1"><strong>Full Name</strong></div>
                                    @if ($is_edit)
                                        <input type="text" class="form-control" wire:model="input_name"
                                            id="input_name" value="{{ $name }}">
                                        @error('input_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    @else
                                        <div class="item-data">{{ $user->name }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="item py-3 {{ $is_edit ? '' : 'border-bottom ' }}">
                            <div class="row ">
                                <div class="col-12">
                                    <div class="item-label mb-1"><strong>Email</strong></div>
                                    @if ($is_edit)
                                        <input type="text" class="form-control" wire:model="input_email"
                                            id="input_email">
                                        @error('input_email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    @else
                                        <div class="item-data">{{ $user->email }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if (!$is_edit)
                            <div class="item py-3">
                                <div class="row justify-content-between align-items-center">
                                    <div class="item-label mb-1"><strong>Status</strong></div>
                                    <div class="col-12">
                                        @if ($user->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @elseif($user->status == 0)
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="app-card-footer pt-2 mt-auto text-end {{ $is_edit ? '' : 'd-none' }}">
                            <button type="button" class="btn btn-secondary"
                                wire:click="onUpdate(false)">Cancel</button>
                            <button type="button" class="btn app-btn-primary" wire:click="onSaveAccount">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
