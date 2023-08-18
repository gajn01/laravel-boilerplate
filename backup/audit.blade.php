@section('title', 'Mary Grace Restaurant Operation System / Store')

<div class="">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Audit</li>
        </ol>
    </nav>
    {{-- <h1 class="app-page-title">Store</h1> --}}
    <div class="page-utilities mb-3">
        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
            <div class="col-auto">
                <select class="form-select form-select-sm ms-auto d-inline-flex w-auto" wire:model="date_filter">
                    <option value="all">All</option>
                    <option value="{{ $date_today }}" selected>Today</option>
                    <option value="weekly">This week</option>
                    <option value="monthly">This month</option>
                </select>
            </div>
            {{-- <div class="col-auto">
                <a href="">
                    <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path
                            d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z" />
                    </svg>
                </a>
            </div> --}}
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
                                <td class="cell">{{ $store->store->code }}</td>
                                <td class="cell">{{ $store->store->name }}</td>
                                <td class="cell">{{ $store->store->TypeString}}</td>
                                <td class="cell">{{ $store->store->area }}</td>
                                <td class="cell">
                                    {{ $store->audit_date != null ? \Carbon\Carbon::parse($store->audit_date)->format('F d Y') : 'No schedule' }}
                                </td>
                                <td class="cell">{{ $store->wave }}</td>
                                <td class="cell">
                                    <span class="badge  {{ $store->StatusBadge }}">{{ $store->StatusString }}</span>
                                </td>
                                <td class="cell table-action-sm">
                                    @if ($store->is_complete != 2)
                                        <a href="{{ route('audit.form', ['id' => $store->store->id]) }}">
                                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                            </svg>
                                        </a>
                                    @endif
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
</div>