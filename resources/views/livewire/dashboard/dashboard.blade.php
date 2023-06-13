@section('title', 'Mary Grace Restaurant Operation System / Dashboard')
<div class="container-xl">
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
                                {{ (isset($completion[0]) ? $completion[0]->count : 0) . '/' . (isset($storeCounts[0]->count) ? $storeCounts[0]->count : 0) }}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-figure">Kiosk</div>
                            <div class="stats-meta">
                                {{ (isset($completion[1]) ? $completion[1]->count : 0) . '/' . (isset($storeCounts[1]->count) ? $storeCounts[1]->count : 0) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="app-card-link-mask" href="#"></a>
        </div>
    </div>
</div>
<div class="row g-4 mb-4">


    <div class="col-12 col-lg-6">
        <div class="app-card app-card-chart h-100 shadow-sm">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title">Bar Chart Example</h4>
                    </div>
                    <div class="col-auto">
                        <div class="card-header-action">
                            <a href="charts.html">More charts</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-card-body p-3 p-lg-4">
                <div class="mb-3 d-flex">
                    <select class="form-select form-select-sm ms-auto d-inline-flex w-auto">
                        <option value="1" selected>This week</option>
                        <option value="2">Today</option>
                        <option value="3">This Month</option>
                        <option value="3">This Year</option>
                    </select>
                </div>
                <div class="chart-container">
                    <canvas id="canvas-barchart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
     'use strict';

/* Chart.js docs: https://www.chartjs.org/ */

window.chartColors = {
	green: '#75c181',
	gray: '#a9b5c9',
	text: '#252930',
	border: '#e7e9ed'
};

/* Random number generator for demo purpose */
var randomDataPoint = function(){ return Math.round(Math.random()*10000)};

var barChartConfig = {
	type: 'bar',

	data: {
		labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
		datasets: [{
			label: 'Orders',
			backgroundColor: window.chartColors.green,
			borderColor: window.chartColors.green,
			borderWidth: 1,
			maxBarThickness: 16,

			data: [
				23,
				45,
				76,
				75,
				62,
				37,
				83
			]
		}]
	},

}


// Generate charts on load
window.addEventListener('load', function(){

	var barChart = document.getElementById('canvas-barchart').getContext('2d');
	window.myBar = new Chart(barChart, barChartConfig);

});


    </script>
@endpush



</div>
