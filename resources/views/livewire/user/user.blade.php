@section('title', 'Mary Grace Restaurant Operation System / User List')

<div class="container-xl">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Account</li>
        </ol>
    </nav>
    <div class="page-utilities mb-3">
        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
            <div class="col-auto">
                <form class="docs-search-form row gx-1 align-items-center">
                    <div class="col-auto">
                        <input type="text" id="search-docs" name="searchdocs" class="form-control search-docs"
                            wire:model.debounce.100ms="searchTerm" placeholder="Search">
                    </div>
                </form>
            </div>
            <div class="col-auto">
                <div class="col-auto">
                    <a class="btn app-btn-primary" data-bs-toggle="modal" data-bs-target="#createModal"  wire:click="create">Create</a>
                </div>
            </div>
        </div>
    </div>
    <div class="app-card app-card-orders-table shadow-sm mb-5">
        <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                            <th class="cell">Name</th>
                            <th class="cell">Email</th>
                            <th class="cell">E-mail Verified</th>
                            <th class="cell">User Type</th>
                            <th class="cell">Status</th>
                            <th class="cell table-action-sm"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($user_list as $user)
                            <tr>
                                <td class="cell">{{ $user->user_type == 3 ? $user->getStoreName->name : $user->name }}</td>
                                <td class="cell">{{ $user->email }}</td>
                                @if(is_null($user->email_verified_at))
                                    <th class="cell d-none d-lg-table-cell"><span class="badge bg-danger">Unverified</span><span class="note">NA</span></th>
                                @else
                                    <th class="cell d-none d-lg-table-cell"><span class="badge bg-success">Verified</span><span class="note">{{ date('Y/m/d H:i:s',strtotime($user->email_verified_at)) }}</span></th>
                                @endif
                                <td class="cell">{{ $user->UserLevel }}</td>
                                <td class="cell">
                                    <span @class(['badge',
                                    'bg-success' => (bool)$user->is_active == true,
                                    'bg-danger' => (bool)$user->is_active == false,])>
                                        {{ (bool)$user->is_active == true ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="cell table-action-sm">
                                    <a href="{{ route('user-details',[$user->id] ) }}">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                            <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                        </svg>
                                    </a>
                                    @if(Gate::allows('allow-delete','module-user-management'))
                                        @if($user->user_type > 0)
                                            <a class="btn btn-link link-danger px-1" title="Delete"  href="#" wire:click="getId({{$user->id}})" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                    <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                                </svg>
                                            </a>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <p class="text-center m-0">
                                        No data found.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- Pagination --}}

    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="page-utilities d-flex justify-start">
                <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                    <div class="col-auto">
                        <label for="limit">Display</label>
                    </div>
                    <div class="col-auto">
                        <select class="form-select-sm w-auto" id="limit">
                            <option selected value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <!--//col-->
                    <div class="col-auto">
                        <label for="">entries</label>
                    </div>
                </div>
                <!--//row-->
            </div>
            <!--//table-utilities-->
        </div>
        <div class="col-sm-12 col-md-6">
            <nav class="app-pagination">
                 {{ $user_list->onEachSide(0)->links() }}
            </nav>
            <!--//app-pagination-->
        </div>
    </div>
     <!-- User Create Modal -->
    <div wire:ignore.self class="modal fade" id="createModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Create User</h1>
                    <button type="button" wire:click="cancel" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="settings-form">
                        <div class="mb-2">
                            <label for="user_type" class="form-label small">User Type<span class="text-danger">*</span></label>
                            <select id="user_type" name="user_type" wire:model="user_type" class="form-select form-select-sm" required>
                                <option value selected>--Select User Type--</option>
                                @if(auth()->user()->user_type < 2)
                                <option value=1>Administrator</option>
                                @endif
                                <option value=2>User</option>
                                <option value=3>Store</option>
                            </select>
                            @error('user_type') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        @if ($user_type == 3)
                            <div class="mb-3">
                                <label for="" class="form-label">Store <span class="text-danger">*</span></label>
                                <select class="form-select form-select-md" wire:model="user.name" id="store_id">
                                    <option selected hidden>Select store</option>
                                    @foreach ($store_list as $item)
                                        <option value="{{ $item->id }}">{{ $item->TypeString }} - {{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('user.name')<span class="text-danger mt-1 ">{{ $message }}</span>@enderror
                            </div>
                        @else
                            <div class="mb-2">
                                <label for="name" class="form-label small">Name<span class="text-danger">*</span></label>
                                <input id="name" name="name" wire:model.defer="user.name" type="text" class="form-control form-control-sm" required>
                                @error('user.name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        @endif
                        <div class="mb-2">
                            <label for="email" class="form-label small">E-mail<span class="text-danger">*</span></label>
                            <input id="email" name="email" type="email" class="form-control form-control-sm" wire:model.defer="user.email" required>
                            @error('user.email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-2">
                            <label for="contactno" class="form-label small">Contact Number</label>
                            <input id="contactno" name="contactno" type="text" class="form-control form-control-sm" wire:model.defer="user.contact_number" required>
                            @error('user.contact_number') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-2">
                            <label for="password" class="form-label small">Password<span class="text-danger">*</span></label>
                            <input id="password" name="password" type="password" class="form-control form-control-sm" wire:model.defer="password" required>
                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-2">
                            <label for="password_confirmation" class="form-label small">Password Confirmation<span class="text-danger">*</span></label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control form-control-sm" wire:model.defer="password_confirmation" required>
                            @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                       
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" wire:click="save" class="btn btn-primary">Save</button>
                    <button type="button" wire:click="cancel" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close" >Close</button>
                </div>
            </div>
        </div>
    </div>
       <!-- Delete Modal -->
    <div wire:ignore class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title">Delete Routes</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="">
                        Do you want to delete selected record?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="delete" class="btn btn-danger text-light" data-bs-dismiss="modal">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
