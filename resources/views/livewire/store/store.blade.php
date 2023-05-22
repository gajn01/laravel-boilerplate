@section('title', 'Mary Grace Restaurant Operation System / Store')

<div class="container-xl">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Audit</li>
        </ol>
    </nav>
    {{-- <h1 class="app-page-title">Store</h1> --}}
    <div class="page-utilities mb-3">
        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
            <div class="col-auto">
                <a href="">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path
                            d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z" />
                    </svg>
                </a>
            </div>
            <div class="col-auto">
                <form class="docs-search-form row gx-1 align-items-center">
                    <div class="col-auto">
                        <input type="text" id="search-docs" name="searchdocs" class="form-control search-docs"
                            wire:model.debounce.100ms="searchTerm" placeholder="Search">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="app-card app-card-orders-table shadow-sm mb-5">
        <div class="app-card-body">
            <div class="table-responsive">
                <table class="table app-table-hover mb-0 text-left">
                    <thead>
                        <tr>
                            <th class="cell">Code</th>
                            <th class="cell">Name</th>
                            <th class="cell">Type</th>
                            <th class="cell">Area</th>
                            <th class="cell">Date</th>
                            <th class="cell">Wave</th>
                            <th class="cell">Audit Status</th>

                            <th class="cell table-action-sm">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($store_sched_list as $store)
                            <tr>
                                <td class="cell">{{ $store->code }}</td>
                                <td class="cell">{{ $store->name }}</td>
                                <td class="cell">{{ $store->type == 1 ? 'Cafe' : 'Kiosk' }}</td>
                                <td class="cell">{{ $store->area }}</td>
                                <td class="cell">
                                    {{ $store->audit_date != null ? \Carbon\Carbon::parse($store->audit_date)->format('F d Y') : 'No schedule' }}
                                </td>
                                <td class="cell">{{ $store->wave }}</td>
                                <td class="cell">{{ $store->audit_status == 1 ? 'In-progress' : 'Pending' }}</td>

                                <td class="cell table-action-sm">
                                    <a href="{{ route('form', ['store_id' => $store->id]) }}">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path
                                                d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
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
                        <select class="form-select-sm w-auto" id="limit" wire:model="limit">
                            <option selected value="10">10</option>
                            <option value="20">20</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <label for="">entries</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <nav class="app-pagination">
                {{ $store_sched_list->onEachSide(0)->links() }}
            </nav>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="store_schedule_modal" tabindex="-1" data-bs-backdrop="static"
        data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">{{ $modalTitle }} Store Schedule</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="reset"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="saveSchedule">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Store <span class="text-danger">*</span></label>
                            <select class="form-select form-select-md" wire:model="store_id">
                                <option selected hidden>Select store</option>
                                @foreach ($store_list as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('store_id')
                                <span class="text-danger mt-1 ">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Date of Audit <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="audit_date" id="audit_date"
                                wire:model="audit_date">
                            @error('audit_date')
                                <span class="text-danger mt-1 ">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Wave <span class="text-danger">*</span></label>
                            <select class="form-select form-select-md" wire:model="wave">
                                <option selected value="">Select wave</option>
                                <option value="1">Wave 1</option>
                                <option value="2">Wave 2</option>
                            </select>
                            @error('wave')
                                <span class="text-danger mt-1 ">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="" class="form-label">Auditor</label>
                            <div class="d-flex">
                                <select class="form-select form-select-md mb-2" wire:model="auditor_id">
                                    <option selected hidden>Select auditor</option>
                                    @foreach ($user_list as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>

                                <svg class="icon float-right mr-3" wire:click="addAuditor"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <path
                                        d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                                </svg>

                            </div>

                            <ul class="list-group list-group-flush">
                                @forelse ($auditor_list as $index => $item)
                                    <li class="list-group-item">{{ $item['auditor_name'] }}
                                        <svg class="icon float-right" wire:click="removeAuditor({{ $index }})"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                            <path
                                                d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z" />
                                        </svg>
                                    </li>
                                @empty
                                @endforelse
                            </ul>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn app-btn-primary" wire:click="saveSchedule">Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
