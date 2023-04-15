@section('title', 'Mary Grace Restaurant Operation System / User List')

<div class="container-xl">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">User</li>
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
                    <a class="btn app-btn-primary" data-bs-toggle="modal" data-bs-target="#user_modal"
                        wire:click="showModal">Create</a>
                </div>
            </div>
            <!--//col-->

        </div>
        <!--//row-->
    </div>
    <!--//table-utilities-->
    <div class="app-card app-card-orders-table shadow-sm mb-5">
        <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                            <th class="cell">ID</th>
                            <th class="cell">Name</th>
                            <th class="cell">Email</th>
                            <th class="cell">Status</th>
                            <th class="cell table-action-sm">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($user_list as $user)
                            <tr>
                                <td class="cell">{{ $user['employee_id'] }}</td>
                                <td class="cell">{{ $user['name'] }}</td>
                                <td class="cell">{{ $user['email'] }}</td>
                                <td class="cell">
                                    @if ($user['status'] == 1)
                                        <span class="badge bg-success">Active</span>
                                    @elseif($user['status'] == 0)
                                        <span class="badge bg-warning">Pending</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="cell table-action-sm">
                                    <a href="{{ route('information', ['user_id' => $user['id']]) }}">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                            <!--! Font Awesome Pro 6.3.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path
                                                d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                        </svg>
                                    </a>
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
            <!--//table-responsive-->
        </div>
        <!--//app-card-body-->
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
                {{--  {{ $user_list->onEachSide(0)->links() }} --}}
            </nav>
            <!--//app-pagination-->

        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="user_modal" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id=""> {{ $modalTitle }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="reset"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="onSave">
                        @csrf
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Employee ID<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" wire:model="employee_id" id="employee_id">
                            @error('employee_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" wire:model="name" id="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" wire:model="email" id="email">
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password<span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control" wire:model="password" id="password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        {{--  <div class="form-group" >
                            <label for="password">Password</label>
                            <div class="password-container">
                                <input  type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                                <span class="eye-icon bi bi-eye {{$is_toggle ? 'hide' : '' }} " id="eye-icon" wire:click="onTogglePassword"></span>
                            </div>
                        </div> --}}
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn app-btn-primary"
                        wire:click="onSave">{{ $modalButtonText }}</button>
                </div>
            </div>
        </div>
    </div>


</div>
