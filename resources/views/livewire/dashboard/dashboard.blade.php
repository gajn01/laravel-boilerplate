@section('title', 'Mary Grace Restaurant Operation System / Dashboard')
<div class="container-xl" wire:poll.10s>
    <h1 class="app-page-title">Overview</h1>
    {{--   <div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
        <div class="inner">
            <div class="app-card-body p-3 p-lg-4">
                <h3 class="mb-3">Welcome, developer!</h3>
                <div class="row gx-5 gy-3">
                    <div class="col-12 col-lg-9">

                        <div>Portal is a free Bootstrap 5 admin dashboard template. The design is simple, clean
                            and modular so it's a great base for building any modern web app.</div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <a class="btn app-btn-primary"
                            href="https://themes.3rdwavemedia.com/bootstrap-templates/admin-dashboard/portal-free-bootstrap-admin-dashboard-template-for-developers/"><svg
                                width="1em" height="1em" viewBox="0 0 16 16"
                                class="bi bi-file-earmark-arrow-down me-2" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z" />
                                <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z" />
                                <path fill-rule="evenodd"
                                    d="M8 6a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 10.293V6.5A.5.5 0 0 1 8 6z" />
                            </svg>Free Download</a>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

        </div>
        <!--//inner-->
    </div> --}}
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
                <a class="app-card-link-mask" href=""></a>
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
            <div class="col-12 ">
                <div class="app-card app-card-chart h-100 shadow-sm">
                    <div class="app-card-header p-3">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-auto">
                                <h4 class="app-card-title">Activity Logs</h4>
                            </div><!--//col-->
                            <div class="col-auto">
                                <div class="card-header-action">
                                    <a href="{{ route('activity-log')}}">More Logs</a>
                                </div><!--//card-header-actions-->
                            </div><!--//col-->
                        </div><!--//row-->
                    </div><!--//app-card-header-->
                    <div class="app-card-body p-3 p-lg-4">
                        <div class="app-card app-card-orders-table shadow-sm"  >
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
                                                    <td colspan="3">
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
                    </div><!--//app-card-body-->
                </div><!--//app-card-->
            </div><!--//col-->
      
    </div>
</div>

