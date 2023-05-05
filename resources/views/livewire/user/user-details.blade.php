@section('title', 'Mary Grace Restaurant Operation System / User Details')

<div class="container-xl">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('user') }}">Account</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $name }}</li>
        </ol>
    </nav>
    <div class="row gy-4 mb-3">
        <div class="col-12 col-lg-6">
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
                                            id="input_employee_id" value="{{ $name }}">
                                        @error('input_employee_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    @else
                                        <div class="item-data">{{ $employee_id }}</div>
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
                                        <div class="item-data">{{ $name }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="item border-bottom py-3">
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
                                        <div class="item-data">{{ $email }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="item py-3">
                            <div class="row justify-content-between align-items-center">
                                <div class="item-label mb-1"><strong>Status</strong></div>
                                <div class="col-12">
                                    @if ($is_edit)

                                        <select class="form-select form-select-md" name="input_status" id="input_status"
                                            wire:model="input_status">
                                            <option selected>Select status</option>
                                            <option value="0">Pending</option>
                                            <option value="1">Active</option>
                                            <option value="2">Inactive</option>
                                        </select>
                                    @else
                                        @if ($status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @elseif($status == 0)
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="app-card-footer pt-2 mt-auto text-end {{ $is_edit ? '' : 'd-none' }}">
                            <button type="button" class="btn btn-secondary"
                                wire:click="onUpdate(false)">Cancel</button>
                            <button type="button" class="btn app-btn-primary" wire:click="onSaveAccount">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">Schedule</h4>
                        </div>
                        <div class="col-auto">
                            <div class="card-header-action col">
                                <a class="btn app-btn-primary" href="#" data-bs-toggle="modal"
                                    wire:model="showModal" data-bs-target="#assign_modal">Assign Store</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-card-body p-3 ">
                    <div class="mb-3 d-flex">
                        <select class="form-select form-select-sm ms-auto d-inline-flex w-auto"
                            wire:model.debounce.100ms="date_filter">
                            <option value="{{ $today }}" selected>Today</option>
                            <option value="weekly">This week</option>
                            <option value="monthly">This Month</option>
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table class="table app-table-hover mb-0 text-left">
                            <thead>
                                <tr>
                                    <th class="cell">Date </th>
                                    <th class="cell">Store</th>
                                    <th class="cell table-action-sm">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($schedule_list as $item)
                                    <tr>
                                        <td class="cell">{{ $item->audit_date }}</td>
                                        <td class="cell">{{ $item->store_name }}</td>
                                        <td class="cell table-action-sm">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#assign_modal"
                                                wire:click="showModal({{ $item->id }})" data-toggle="tooltip"
                                                data-placement="top" title="Update">
                                                <svg class="icon" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 512 512">
                                                    <path
                                                        d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
                                                </svg>
                                            </a>
                                            <a href="#"
                                                wire:click="onAlert(true,'Confirm','Are you sure you want to delete this schedule?','warning',{{ $item->id }})">
                                                <svg class="icon" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 448 512">
                                                    <path
                                                        d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">
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
                <div class="app-card-footer p-4 mt-auto">
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
                                 {{ $schedule_list->onEachSide(0)->links() }}
                            </nav>
                            <!--//app-pagination-->
                        </div>
                    </div>

                </div>
                <!--//app-card-footer-->

            </div>
        </div>
    </div>
    <div class="app-card app-card-orders-table shadow-sm mb-5 p-3">
        <div class="app-card-header p-3">
            <div class="row justify-content-between align-items-center">
                <div class="col-auto">
                    <h4 class="app-card-title">Audit Records</h4>
                </div>
            </div>
        </div>
        <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                            <th class="cell">Date </th>
                            <th class="cell">Store</th>
                            <th class="cell">Overall Score</th>
                            <th class="cell">Wave</th>
                            <th class="cell table-action-sm">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td class="cell">March 15 2023</td>
                        <td class="cell">SM Megamall</td>
                        <td class="cell">95%</td>
                        <td class="cell">Wave 1</td>
                        <td class="cell table-action-sm">
                            <a href="" data-toggle="tooltip" data-placement="top" title="View">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                    <path
                                        d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                </svg>
                            </a>
                        </td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div wire:ignore.self  class="modal fade" id="assign_modal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Assign Store</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="store" class="form-label">Store</label>
                        <select class="form-select form-select-md" name="store" id="store" wire:model="store">
                            <option selected hidden>Select store</option>
                            @foreach ($store_list as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for=audit_date class="form-label">Date of Audit</label>
                        <input type="date" class="form-control" name=audit_date id=audit_date
                            wire:model="audit_date" aria-describedby="helpId" placeholder="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn app-btn-primary" wire:click="onAssign">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
