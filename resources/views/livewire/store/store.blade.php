@section('title', 'Mary Grace Restaurant Operation System / Store Settings')

<div class="">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Store Management</li>
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
                    {{--   <div class="col-auto">
                        <a class="btn app-btn-primary" href="#" wire:click="test">Search</a>
                    </div> --}}
                </form>
            </div>
            <!--//col-->
            <div class="col-auto">
                <div class="col-auto">
                    <a class="btn cta-bg" data-bs-toggle="modal" data-bs-target="#store_modal"
                        wire:click="showModal">Add</a>
                </div>
            </div>
            <div class="col-auto">
                <div class="col-auto">
                    <a class="btn btn-primary" wire:click="exportCSV">CSV Export</a>
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
                            <th class="cell">Code</th>
                            <th class="cell">Name</th>
                            <th class="cell">Type</th>
                            <th class="cell">Area</th>
                            <th class="cell table-action-sm">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($store_list as $store)
                            <tr>
                                <td class="cell">{{ $store['code'] }}</td>
                                <td class="cell">{{ $store['name'] }}</td>
                                <td class="cell">{{ $store['type'] == 1 ? 'Cafe' : 'Kiosk' }}</td>
                                <td class="cell">{{ $store['area'] }}</td>
                                <td class="cell table-action-sm">
                                    <a href="{{ route('audit.details', ['store_id' => $store->id]) }}">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                            <path
                                                d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z" />
                                        </svg>
                                    </a>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#store_modal"
                                        wire:click="showModal({{ $store['id'] }})">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path
                                                d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
                                        </svg>
                                    </a>
                                    <a href="#"
                                        wire:click="onAlert(true,'Confirm','Are you sure you want to delete this store record?','warning',{{ $store['id'] }})">
                                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                            <path
                                                d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
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
                            <option value="9999">All</option>
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
                {{ $store_list->onEachSide(0)->links() }}
            </nav>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" id="store_modal" tabindex="-1" data-bs-backdrop="static"
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
                            <label for="name" class="form-label">Store Name<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" wire:model="name" id="name">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label">Store Code<span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" wire:model="code" id="code">
                            @error('code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="type" class="form-label">Store Type<span
                                    class="text-danger">*</span></label>
                            <select class="form-select form-select-md" wire:model="type" id="type">
                                <option selected hidden>Select one</option>
                                <option value="1">Cafe</option>
                                <option value="0">Kiosk</option>
                            </select>
                            @error('type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="area" class="form-label">Store Area<span
                                    class="text-danger">*</span></label>
                            <select class="form-select form-select-md" wire:model="area" id="area">
                                <option selected hidden>Select one</option>
                                <option value="MFO">MFO</option>
                                <option value="South">South</option>
                                <option value="North">North</option>
                            </select>
                            @error('area')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
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
