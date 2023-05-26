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
                        <h4 class="app-card-title">Line Chart Example</h4>
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
                    <canvas id="canvas-linechart"></canvas>
                </div>
            </div>
        </div>
    </div>


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


//Chart.js Line Chart Example

var lineChartConfig = {
	type: 'line',

	data: {
		labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'],

		datasets: [{
			label: 'Current week',
			fill: false,
			backgroundColor: window.chartColors.green,
			borderColor: window.chartColors.green,
			data: [
				randomDataPoint(),
				randomDataPoint(),
				randomDataPoint(),
				randomDataPoint(),
				randomDataPoint(),
				randomDataPoint(),
				randomDataPoint()
			],
		}, {
			label: 'Previous week',
		    borderDash: [3, 5],
			backgroundColor: window.chartColors.gray,
			borderColor: window.chartColors.gray,

			data: [
				randomDataPoint(),
				randomDataPoint(),
				randomDataPoint(),
				randomDataPoint(),
				randomDataPoint(),
				randomDataPoint(),
				randomDataPoint()
			],
			fill: false,
		}]
	},
	options: {
		responsive: true,
		aspectRatio: 1.5,

		legend: {
			display: true,
			position: 'bottom',
			align: 'end',
		},

		title: {
			display: true,
			text: 'Chart.js Line Chart Example',

		},
		tooltips: {
			mode: 'index',
			intersect: false,
			titleMarginBottom: 10,
			bodySpacing: 10,
			xPadding: 16,
			yPadding: 16,
			borderColor: window.chartColors.border,
			borderWidth: 1,
			backgroundColor: '#fff',
			bodyFontColor: window.chartColors.text,
			titleFontColor: window.chartColors.text,

            callbacks: {
	            //Ref: https://stackoverflow.com/questions/38800226/chart-js-add-commas-to-tooltip-and-y-axis
                label: function(tooltipItem, data) {
	                if (parseInt(tooltipItem.value) >= 1000) {
                        return "$" + tooltipItem.value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    } else {
	                    return '$' + tooltipItem.value;
                    }
                }
            },

		},
		hover: {
			mode: 'nearest',
			intersect: true
		},
		scales: {
			xAxes: [{
				display: true,
				gridLines: {
					drawBorder: false,
					color: window.chartColors.border,
				},
				scaleLabel: {
					display: false,

				}
			}],
			yAxes: [{
				display: true,
				gridLines: {
					drawBorder: false,
					color: window.chartColors.border,
				},
				scaleLabel: {
					display: false,
				},
				ticks: {
		            beginAtZero: true,
		            userCallback: function(value, index, values) {
		                return '$' + value.toLocaleString();   //Ref: https://stackoverflow.com/questions/38800226/chart-js-add-commas-to-tooltip-and-y-axis
		            }
		        },
			}]
		}
	}
};



// Chart.js Bar Chart Example

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
	options: {
		responsive: true,
		aspectRatio: 1.5,
		legend: {
			position: 'bottom',
			align: 'end',
		},
		title: {
			display: true,
			text: 'Chart.js Bar Chart Example'
		},
		tooltips: {
			mode: 'index',
			intersect: false,
			titleMarginBottom: 10,
			bodySpacing: 10,
			xPadding: 16,
			yPadding: 16,
			borderColor: window.chartColors.border,
			borderWidth: 1,
			backgroundColor: '#fff',
			bodyFontColor: window.chartColors.text,
			titleFontColor: window.chartColors.text,

		},
		scales: {
			xAxes: [{
				display: true,
				gridLines: {
					drawBorder: false,
					color: window.chartColors.border,
				},

			}],
			yAxes: [{
				display: true,
				gridLines: {
					drawBorder: false,
					color: window.chartColors.borders,
				},


			}]
		}

	}
}



// Generate charts on load
window.addEventListener('load', function(){

	var lineChart = document.getElementById('canvas-linechart').getContext('2d');
	window.myLine = new Chart(lineChart, lineChartConfig);

	var barChart = document.getElementById('canvas-barchart').getContext('2d');
	window.myBar = new Chart(barChart, barChartConfig);

});


    </script>
@endpush


<div class="row g-4 mb-4">
    <div class="col-12 col-lg-6">
        <div class="app-card app-card-progress-list h-100 shadow-sm">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title">Progress</h4>
                    </div>
                    <div class="col-auto">
                        <div class="card-header-action">
                            <a href="#">All projects</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-card-body">
                <div class="item p-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="title mb-1 ">Project lorem ipsum dolor sit amet</div>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%;"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-right"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </div>
                    </div>
                    <a class="item-link-mask" href="#"></a>
                </div>
                <div class="item p-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="title mb-1 ">Project duis aliquam et lacus quis ornare</div>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 34%;"
                                    aria-valuenow="34" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-right"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </div>
                    </div>
                    <a class="item-link-mask" href="#"></a>
                </div>
                <div class="item p-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="title mb-1 ">Project sed tempus felis id lacus pulvinar</div>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 68%;"
                                    aria-valuenow="68" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-right"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </div>
                    </div>
                    <a class="item-link-mask" href="#"></a>
                </div>
                <div class="item p-3">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="title mb-1 ">Project sed tempus felis id lacus pulvinar</div>
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 52%;"
                                    aria-valuenow="52" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-right"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z" />
                            </svg>
                        </div>
                    </div>
                    <a class="item-link-mask" href="#"></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="app-card app-card-stats-table h-100 shadow-sm">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title">Stats List</h4>
                    </div>
                    <div class="col-auto">
                        <div class="card-header-action">
                            <a href="#">View report</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-card-body p-3 p-lg-4">
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <thead>
                            <tr>
                                <th class="meta">Source</th>
                                <th class="meta stat-cell">Views</th>
                                <th class="meta stat-cell">Today</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="#">google.com</a></td>
                                <td class="stat-cell">110</td>
                                <td class="stat-cell">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16"
                                        class="bi bi-arrow-up text-success" fill="currentColor"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z" />
                                    </svg>
                                    30%
                                </td>
                            </tr>
                            <tr>
                                <td><a href="#">getbootstrap.com</a></td>
                                <td class="stat-cell">67</td>
                                <td class="stat-cell">23%</td>
                            </tr>
                            <tr>
                                <td><a href="#">w3schools.com</a></td>
                                <td class="stat-cell">56</td>
                                <td class="stat-cell">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16"
                                        class="bi bi-arrow-down text-danger" fill="currentColor"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z" />
                                    </svg>
                                    20%
                                </td>
                            </tr>
                            <tr>
                                <td><a href="#">javascript.com </a></td>
                                <td class="stat-cell">24</td>
                                <td class="stat-cell">-</td>
                            </tr>
                            <tr>
                                <td><a href="#">github.com </a></td>
                                <td class="stat-cell">17</td>
                                <td class="stat-cell">15%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row g-4 mb-4">
    <div class="col-12 col-lg-4">
        <div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
            <div class="app-card-header p-3 border-bottom-0">
                <div class="row align-items-center gx-3">
                    <div class="col-auto">
                        <div class="app-icon-holder">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-receipt"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27zm.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0l-.509-.51z" />
                                <path fill-rule="evenodd"
                                    d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z" />
                            </svg>
                        </div>

                    </div>
                    <div class="col-auto">
                        <h4 class="app-card-title">Invoices</h4>
                    </div>
                </div>
            </div>
            <div class="app-card-body px-4">

                <div class="intro">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam aliquet
                    eros vel diam semper mollis.</div>
            </div>
            <div class="app-card-footer p-4 mt-auto">
                <a class="btn app-btn-secondary" href="#">Create New</a>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
            <div class="app-card-header p-3 border-bottom-0">
                <div class="row align-items-center gx-3">
                    <div class="col-auto">
                        <div class="app-icon-holder">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-code-square"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M14 1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                <path fill-rule="evenodd"
                                    d="M6.854 4.646a.5.5 0 0 1 0 .708L4.207 8l2.647 2.646a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 0 1 .708 0zm2.292 0a.5.5 0 0 0 0 .708L11.793 8l-2.647 2.646a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708 0z" />
                            </svg>
                        </div>

                    </div>
                    <div class="col-auto">
                        <h4 class="app-card-title">Apps</h4>
                    </div>
                </div>
            </div>
            <div class="app-card-body px-4">

                <div class="intro">Pellentesque varius, elit vel volutpat sollicitudin, lacus quam
                    efficitur augue</div>
            </div>
            <div class="app-card-footer p-4 mt-auto">
                <a class="btn app-btn-secondary" href="#">Create New</a>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm">
            <div class="app-card-header p-3 border-bottom-0">
                <div class="row align-items-center gx-3">
                    <div class="col-auto">
                        <div class="app-icon-holder">
                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-tools"
                                fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M0 1l1-1 3.081 2.2a1 1 0 0 1 .419.815v.07a1 1 0 0 0 .293.708L10.5 9.5l.914-.305a1 1 0 0 1 1.023.242l3.356 3.356a1 1 0 0 1 0 1.414l-1.586 1.586a1 1 0 0 1-1.414 0l-3.356-3.356a1 1 0 0 1-.242-1.023L9.5 10.5 3.793 4.793a1 1 0 0 0-.707-.293h-.071a1 1 0 0 1-.814-.419L0 1zm11.354 9.646a.5.5 0 0 0-.708.708l3 3a.5.5 0 0 0 .708-.708l-3-3z" />
                                <path fill-rule="evenodd"
                                    d="M15.898 2.223a3.003 3.003 0 0 1-3.679 3.674L5.878 12.15a3 3 0 1 1-2.027-2.027l6.252-6.341A3 3 0 0 1 13.778.1l-2.142 2.142L12 4l1.757.364 2.141-2.141zm-13.37 9.019L3.001 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z" />
                            </svg>
                        </div>

                    </div>
                    <div class="col-auto">
                        <h4 class="app-card-title">Tools</h4>
                    </div>
                </div>
            </div>
            <div class="app-card-body px-4">

                <div class="intro">Sed maximus, libero ac pharetra elementum, turpis nisi molestie neque,
                    et tincidunt velit turpis non enim.</div>
            </div>
            <div class="app-card-footer p-4 mt-auto">
                <a class="btn app-btn-secondary" href="#">Create New</a>
            </div>
        </div>
    </div>
</div>

</div>
