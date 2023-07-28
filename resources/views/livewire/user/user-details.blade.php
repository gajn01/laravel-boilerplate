<div>
    <nav aria-label="breadcrumb" class="">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user-management') }}">User Management</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Detail</li>
        </ol>
    </nav>
    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0">User Detail</h1>
        </div>
        @if (Gate::allows('access-enabled', 'module-reset-password'))
            <div class="col-auto">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmResetPasswordModal">Reset
                    Password</button>
            </div>
        @endif
    </div>
    <hr class="mb-4">
    <div class="row g-4 settings-section">
        <div class="col-12 col-md-4">
            <h3 class="section-title">General</h3>
            <div class="section-intro">General account information.</div>
        </div>
        <div class="col-12 col-md-8">
            <div class="app-card app-card-settings shadow-sm p-4">
                <div class="app-card-body">
                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col">
                                <div class="item-label"><strong>Name</strong><span class="text-danger">*</span></div>
                                @if ($isedit == false)
                                    <div class="item-data">{{ $user->name }}</div>
                                @else
                                    <input wire:model.defer="user.name" type="text" class="form-control" required>
                                    @error('user.name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col">
                                <div class="item-label"><strong>E-mail</strong><span class="text-danger">*</span></div>
                                @if ($isedit == false)
                                    <div class="item-data">{{ $user->email }}</div>
                                @else
                                    <input wire:model.defer="user.email" type="email" class="form-control" required>
                                    @error('user.email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col">
                                <div class="item-label"><strong>Contact Number</strong></div>
                                @if ($isedit == false)
                                    <div class="item-data">{{ $user->contact_number }}</div>
                                @else
                                    <input wire:model.defer="user.contact_number" type="contactno" class="form-control"
                                        required>
                                    @error('user.contact_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="item border-bottom py-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col">
                                <div class="item-label"><strong>User Type</strong><span class="text-danger">*</span>
                                </div>
                                @if ($isedit == false)
                                    <div class="item-data">{{ $user->userLevel }}</div>
                                @else
                                    @if ($sameUser == true || $user->user_type == 0)
                                        <div class="item-data">{{ $user->userLevel }}</div>
                                    @else
                                        <select wire:model="usertype" class="form-select" required>
                                            @if (auth()->user()->user_type < 2)
                                                <option value=1>Administrator</option>
                                            @endif
                                            <option value=2>User</option>
                                        </select>
                                        @error('usertype')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-card-footer pt-4 mt-auto row justify-content-end">
                    <div class="col-auto">
                        @if (Gate::allows('allow-edit', 'module-user-management'))
                            @if ($isedit == true)
                                <button name="save_changes" wire:click="save" class="btn btn-sm btn-primary">Save
                                    Changes</button>
                                <button name="cancel_changes" wire:click="cancel"
                                    class="btn btn-sm btn-secondary">Cancel</button>
                            @else
                                <button name="edit_changes" wire:click="edit" class="btn btn-sm app-btn-primary">Edit
                                    Detail</button>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-4">
    <div class="row g-4 settings-section">
        <div class="col-12 col-md-4">
            <h3 class="section-title">Account Status</h3>
            <div class="section-intro">Settings for activating or deactivating account.</div>
        </div>
        <div class="col-12 col-md-8">
            <div class="app-card app-card-settings shadow-sm p-4">

                <div class="app-card-body">
                    <div class="row">
                        <div class="col-auto mb-2"><strong>Status:</strong>
                        </div>
                        <div class="col-auto form-check form-switch ml-5 ">
                            @if (Gate::allows('access-enabled', 'module-set-status'))
                                @if ($sameUser == false || $user->user_type > 0)
                                    <input class="form-check-input" type="checkbox" wire:model="isactive" id="isactive"
                                        checked>
                                @endif
                            @endif
                            <label class="form-check-label" for="isactive">
                                @if ((bool) $user->is_active == true)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </label>
                        </div>
                    </div>
                    <div class="mb-2"><strong>Date Created:</strong>
                        {{ date('F d, Y h:i A', strtotime($user->date_created)) }}</div>
                    <div class="mb-2"><strong>Date Last Updated:</strong>
                        {{ date('F d, Y h:i A', strtotime($user->date_updated)) }}</div>
                    <div class="mb-2"><strong>Email Verified:</strong>
                        @if (is_null($user->email_verified_at))
                            <span class="badge bg-danger"> Unverified</span>
                            @if (Gate::allows('access-enabled', 'module-override-email-verification'))
                                <a class="link-primary" data-bs-toggle="modal" data-bs-target="#confirmOverride"
                                    href="#"><small class="p-1">Override Verification</small></a>
                            @endif
                        @else
                            <span class="badge bg-success">Verified</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($user->user_type != 2 && $this->sameUser == false)
        <hr class="my-4">
        @if (Gate::allows('access-enabled', 'module-set-module-access'))
            <div class="row g-4 settings-section">
                <div class="col-12 col-md-4">
                    <h3 class="section-title">Module Access</h3>
                    <div class="section-intro">Settings to enable or disable access to specified modules.</div>
                </div>
                <div class="col-12 col-md-8">
                    <div class="app-card app-card-settings shadow-sm p-4">
                        <div class="app-card-body">
                            <form class="settings-form">
                                <ul class="list-group gap-2">
                                    @php
                                        $last_parent = '';
                                        $last_parent_enabled = false;
                                    @endphp
                                    @foreach($moduleList as $index => $module)
                                        @if(is_null($module['parent']) || $last_parent_enabled)
                                            <li class="border-0 list-group-item d-flex justify-content-between align-items-center py-0">
                                                <div class="{{ is_null($module['parent']) ? 'col-7 col-lg-5' : 'col-6 col-lg-4 offset-1' }}">
                                                    <div class="form-check form-switch mb-3">
                                                        @if(!(($module['module'] == "module-user-management" || $module['parent'] == "module-user-management") && auth()->user()->user_type > 1))
                                                            <input class="form-check-input" type="checkbox" id="{{$module['module']}}" wire:model="useraccess.{{ $index }}.enabled">
                                                        @endif
                                                        <label class="form-check-label{{ is_null($module['parent']) ? ' fw-semibold' : '' }}" for="{{$module['module']}}">{{ $module['module_name']}}</label>
                                                    </div>
                                                </div>
                                                <div class="col-5 col-lg-4">
                                                    @if(!($module['module'] == "module-user-management" && auth()->user()->user_type > 1))
                                                        @if($module['access_type'] == 1)
                                                            <select class="form-select form-select-sm" wire:model="useraccess.{{ $index }}.access_level" style="max-width:12em" {{ !$useraccess[$index]['enabled'] ? 'disabled' : '' }}>
                                                                <option value=0>View</option>
                                                                <option value=1>Create</option>
                                                                <option value=2>Create + Update</option>
                                                                <option value=3>Full Access</option>
                                                            </select>
                                                        @endif
                                                    @endif
                                                </div>
                                                <div class="d-none d-lg-block small col-12 col-lg-3">
                                                    {{$module['description']}}
                                                </div>
                                            </li>
                                        @endif
                                        @php
                                            if(is_null($module['parent'])) {
                                                $last_parent = $module['module'];
                                                $last_parent_enabled = $useraccess[$index]['enabled'];
                                            }
                                        @endphp
                                    @endforeach
                                </ul>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <hr class="my-4">
        @endif
    @endif

    <!-- Modal -->
    <div wire:ignore class="modal fade" id="confirmOverride" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="confirmOverrideLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Override E-mail Verification</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Do you want to override e-mail verification process for this user?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary text-light" wire:click="overrideEmailVerification"
                        data-bs-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore class="modal fade" id="confirmResetPasswordModal" data-bs-backdrop="static"
        data-bs-keyboard="false" tabindex="-1" aria-labelledby="confirmResetPasswordLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Reset Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Do you want to reset user password to "Password123"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary text-light" wire:click="resetPassword"
                        data-bs-dismiss="modal">Yes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="alertToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="" class="rounded me-2" alt="">
                <strong class="me-auto">
                    @if (session()->has('title'))
                        <!-- Session Message -->
                        <span class="{{ $class }}">{{ session('title') }}</span>
                    @endif
                </strong>
                <small>
                    @if (session()->has('timestamp'))
                        {{ session('timestamp') }}
                    @endif
                </small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                @if (session()->has('message'))
                    <!-- Session Message -->
                    {{ session('message') }}
                @endif
            </div>
        </div>
    </div>
    @push('custom-scripts')
        <script>
            window.livewire.on('show-toast', event => {
                var toast = bootstrap.Toast.getOrCreateInstance(document.getElementById('alertToast'));
                toast.show();
            });
        </script>
    @endpush
</div>
