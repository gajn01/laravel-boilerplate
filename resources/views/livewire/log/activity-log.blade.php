<div>
    <nav aria-label="breadcrumb" class="">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page">Activity Log</li>
        </ol>
    </nav>
    <div class="row g-3 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0">Activity Log</h1>
        </div>
    </div><!--//row-->
    <div class="page-utilities mb-3">
        <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
            <div class="col-auto">
                <select class="form-select form-select-sm ms-auto d-inline-flex w-auto" wire:model="date_filter">
                    <option value="all" selected>All</option>
                    <option value="{{ $date_today }}" >Today</option>
                    <option value="weekly">This week</option>
                    <option value="monthly">This month</option>
                </select>
            </div>
        </div>
    </div>
    <div class="mb-4" >
        <div class="app-card app-card-orders-table shadow-sm mb-5  wire:poll.10s">
            <div class="app-card-body">
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left">
                        <thead>
                            <tr>
                                <th class="cell">Date</th>
                                <th class="cell">Log Message</th>
                                <th class="cell">Author</th>
                                <th class="cell">Device</th>
                                <th class="cell">Browser</th>
                                <th class="cell">Platform</th>
                                <th class="cell">IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($activity as $item)
                                <tr>
                                    <td class="cell">{{ date('F d Y | h:i A', strtotime($item->date_created)) }}</td>
                                    <td class="cell">{{ $item->activity}}</td>
                                    <td class="cell">{{ $item->created_by->name}}</td>
                                    <td class="cell">{{ $item->device}}</td>
                                    <td class="cell">{{ $item->browser}}</td>
                                    <td class="cell">{{ $item->platform}}</td>
                                    <td class="cell">{{ $item->ip_address}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <p class="text-center m-0">
                                            No logs found.
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
                            <select class="form-select-sm w-auto" id="limit" wire:model="limit">
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
                    {{ $activity->onEachSide(0)->links() }}
                </nav>
                <!--//app-pagination-->
            </div>
        </div>
    </div>
</div>
