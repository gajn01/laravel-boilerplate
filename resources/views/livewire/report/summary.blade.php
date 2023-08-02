@section('title', 'Mary Grace Restaurant Operation System / Report Summary')
<div class="">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Sumary</li>
        </ol>
    </nav>
    <h1 class="app-page-title mb-0">Summary</h1>
    <div class="page-utilities mb-3">
        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
            <div class="col-auto">
                <svg data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-expanded="true"
                    aria-controls="collapseFilter" data-bs-toggle="tooltip" data-bs-placement="top" title="Filter"
                    class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                    <path
                        d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z" />
                </svg>
            </div>
            <div class="col-auto">
                <input type="text" id="search-docs" name="searchdocs" class="form-control search-docs"
                    wire:model.debounce.100ms="search" placeholder="Search Store">
            </div>
            <div class="col-auto">
                <div class="col-auto">
                    <a class="btn btn-primary" wire:click="exportCSV">CSV Export</a>
                </div>
            </div>
        </div>
    </div>
    <div class="accordion" id="accordionFilter" wire:ignore>
        <div class="accordion-item secondary-bg border-0">
            <div id="collapseFilter" class="accordion-collapse collapse " aria-labelledby="headingOne"
                data-bs-parent="#accordionFilter">
                <div class="accordion-body">
                    <div class="page-utilities">
                        <div class="row g-2 justify-content-start justify-content-md-start align-items-center">
                            <div class="col-auto d-flex flex-column">
                                <label for="type" class="form-label">Store Type</label>
                                <select name="type" id="type"
                                    class="form-select form-select-md ms-auto d-inline-flex w-auto" wire:model="type">
                                    <option value hidden selected>--Select Type--</option>
                                    <option value="all">All</option>
                                    <option value="1">Cafe</option>
                                    <option value="2">Kiosk</option>
                                </select>
                            </div>
                            <div class="col-auto d-flex flex-column">
                                <label for="area" class="form-label">Area</label>
                                <select name="area" id="area"
                                    class="form-select form-select-md ms-auto d-inline-flex w-auto" wire:model="area">
                                    <option value hidden selected>--Select Area--</option>
                                    <option value="all">All</option>
                                    <option value="South">South</option>
                                    <option value="North">North</option>
                                    <option value="MFO">MFO</option>
                                </select>
                            </div>
                            <div class="col-auto d-flex flex-column">
                                <label for="store" class="form-label">Category</label>
                                <select class="form-select form-select-sm ms-auto d-inline-flex w-auto" wire:model="category">
                                    <option value hidden selected>--Select Category--</option>
                                    <option value="">All</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-auto d-flex flex-column">
                                <label for="wave" class="form-label">Wave</label>
                                <select name="wave" id="wave"
                                    class="form-select form-select-md ms-auto d-inline-flex w-auto" wire:model="wave">
                                    <option value hidden selected>--Select Wave--</option>
                                    <option value="all">All</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                </select>
                            </div>
                       {{--      <div class="col-auto d-flex flex-column">
                                <label for="pickup_date" class="form-label">Pick-up Date</label>
                                <input type="date" class="form-control" name="pickup_date" id="pickup_date" wire:model="date_pickup_filter">
                            </div> --}}
                        </div>
                    </div>
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
                            <th class="cell">Area</th>
                            <th class="cell">Stores</th>
                            <th class="cell">ROS</th>
                            <th class="cell">Category</th>
                            <th class="cell">Sub Category</th>
                            <th class="cell">Specific</th>
                            <th class="cell">Deviation Details</th>
                            <th class="cell">Remarks</th>
                            <th class="cell">Additional Info</th>
                            <th class="cell">Year</th>
                            <th class="cell">Wave</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($summary as $results)
                            <tr>
                                <td class="cell">{{ $results->forms->stores->area }}</td>
                                <td class="cell">{{ $results->forms->stores->name }}</td>
                                <td class="cell">{{ $results->category->Label }}</td>
                                <td class="cell">{{ $results->category_name }}</td>
                                <td class="cell">{{ $results->sub_name }}</td>
                                <td class="cell">{{ $results->sub_sub_name }}</td>
                                <td class="cell">{{ $results->label_name }}</td>
                                <td class="cell">
                                    {{ $results->sub_sub_remarks ? $results->sub_sub_remarks : $results->label_remarks }}
                                </td>
                                <td class="cell">{{ $results->sub_sub_deviation ? $results->sub_sub_deviation : $results->label_deviation  }}</td>
                                <td class="cell">{{ date('Y', strtotime($results->updated_at)) }}</td>
                                <td class="cell text-center">{{ $results->forms->wave }}</td>
                                {{-- <td class="cell">{{ $results->sub_sub_remarks ? $results->sub_sub_remarks : $results->label_remarks }}</td>
                                <td class="cell">{{ $results->sub_sub_deviation ? $results->sub_sub_deviation : $results->label_name }}</td>
                                <td class="cell">{{ $results->sub_sub_point != "" ? $results->sub_sub_point : $results->label_point  }}</td> --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11">
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
                  {{ $summary->onEachSide(0)->links() }}
            </nav>
        </div>
    </div>
</div>
