@section('title', 'Mary Grace Restaurant Operation System / Dashboard')
<div class="" wire:poll.10s>
    <h1 class="app-page-title">Overview</h1>
    <div class="row g-4 mb-4">
        <div class="col-sm-6 col-lg-4">
            <div class="app-card app-card-stat shadow-sm h-100">

                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Total Stores</h4>
                    <div class="row">
                        @forelse ($storeCounts as $storeCount)
                            <div class="col-6">
                                <div class="stats-figure">{{ $storeCount->type ? 'Cafe' : 'Kiosk' }}</div>
                                <div class="stats-meta">{{ $storeCount->count ? $storeCount->count : 0 }}</div>
                            </div>
                        @empty
                            <div class="col-6">
                                <div class="stats-figure">Cafe</div>
                                <div class="stats-meta">0</div>
                            </div>
                            <div class="col-6">
                                <div class="stats-figure">Kiosk</div>
                                <div class="stats-meta">0</div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <a class="app-card-link-mask" href="{{ route('store') }}"></a>
            </div>
        </div>
        <div class="col-sm-6  col-lg-4">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4 bg-">
                    <h4 class="stats-type mb-1">Completion</h4>
                    <div class="row">
                        <div class="col-6">
                            <div class="stats-figure">Cafe</div>
                            <div class="stats-meta">
                                {{ isset($completion[0]) ? round(($completion[0]->count / $storeCounts[0]->count) * 100, 0) . '%' : 0 }}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-figure">Kiosk</div>
                            <div class="stats-meta">
                                {{ isset($completion[1]) ? round(($completion[1]->count / $storeCounts[1]->count) * 100, 0) . '%' : 0 }}
                            </div>
                        </div>
                    </div>
                </div>
                <a class="app-card-link-mask" href="#"></a>
            </div>
        </div>
        <div class="col-sm-12  col-lg-4">
            <div class="app-card app-card-stat shadow-sm h-100">
                <div class="app-card-body p-3 p-lg-4">
                    <h4 class="stats-type mb-1">Passing hit rate</h4>
                    <div class="row">
                        <div class="col-6">
                            <div class="stats-figure">Cafe</div>
                            <div class="stats-meta">
                                {{ (isset($passingRate[0]) ? $passingRate[0]->count : 0) . '/' . (isset($storeCounts[0]->count) ? $storeCounts[0]->count : 0) }}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-figure">Kiosk</div>
                            <div class="stats-meta">
                                {{ (isset($passingRate[1]) ? $passingRate[1]->count : 0) . '/' . (isset($storeCounts[1]->count) ? $storeCounts[1]->count : 0) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="app-card-link-mask" href="#"></a>
        </div>
    </div>
    <div class="row mb-4">
        
    </div>
    <div class="row mb-4">
        <div class="col-sm-12 col-md-6">
            <div class="app-card app-card-chart shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">Today`s Schedule</h4>
                        </div>
                        <div class="col-auto">
                            <div class="card-header-action">
                                <a href="{{ route('audit.schedule') }}">More Schedule</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-card-body p-3 p-lg-4">
                    <div class="app-card app-card-orders-table shadow-sm">
                        <div class="app-card-body">
                            <div class="table-responsive">
                                <table class="table app-table-hover mb-0 text-left">
                                    <thead>
                                        <tr>
                                            <th class="cell">Store Name</th>
                                            <th class="cell">Type</th>
                                            <th class="cell">Area</th>
                                            <th class="cell">Auditor(s)</th>
                                            <th class="cell">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($schedule as $item)
                                            <tr>
                                                <td class="cell">{{ $item->stores->name }}</td>
                                                <td class="cell">{{ $item->stores->TypeString }}</td>
                                                <td class="cell">{{ $item->stores->area }}</td>
                                                <td class="cell">
                                                    @foreach ($item->auditors as $name)
                                                        {{ $name->auditor_name }}
                                                        @if (!$loop->last)
                                                        ,
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="cell">
                                                    <span class="badge  {{ $item->StatusBadge }}">{{ $item->StatusString }}</span>
                                                </td>
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
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="app-card app-card-chart h-100 shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">Activity Logs</h4>
                        </div>
                        <!--//col-->
                        <div class="col-auto">
                            <div class="card-header-action">
                                <a href="{{ route('activity-log') }}">More Logs</a>
                            </div>
                            <!--//card-header-actions-->
                        </div>
                        <!--//col-->
                    </div>
                    <!--//row-->
                </div>
                <!--//app-card-header-->
                <div class="app-card-body p-3 p-lg-4">
                    <div class="app-card app-card-orders-table shadow-sm">
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
                                                <td class="cell">
                                                    {{ date('F d Y | h:i A', strtotime($item->date_created)) }}</td>
                                                <td class="cell">{{ $item->activity }}</td>
                                                <td class="cell">{{ $item->created_by->name }}</td>
                                                <td class="cell">{{ $item->device }}</td>
                                                <td class="cell">{{ $item->browser }}</td>
                                                <td class="cell">{{ $item->platform }}</td>
                                                <td class="cell">{{ $item->ip_address }}</td>
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
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
