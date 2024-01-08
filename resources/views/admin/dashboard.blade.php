@extends('layouts.adminLayout')

@push('page-js')
<!-- third party js -->
<script src="admin/assets/js/vendor/chart.min.js"></script>

<!-- demo app -->
<script>
! function(o) {
    "use strict";

    function t() {
        this.$body = o("body"), this.charts = []
    }
    t.prototype.respChart = function(r, a, e, i) {
        Chart.defaults.font.color = "#8391a2", Chart.defaults.scale.grid.color = "#8391a2";
        var n = r.get(0).getContext("2d"),
            s = o(r).parent();
        return function() {
            var t;
            switch (r.attr("width", o(s).width()), a) {
                case "Line":
                    t = new Chart(n, {
                        type: "line",
                        data: e,
                        options: i
                    });
                    break;
                case "Bar":
                    t = new Chart(n, {
                        type: "bar",
                        data: e,
                        options: i
                    });
                    break;
                case "Doughnut":
                    t = new Chart(n, {
                        type: "doughnut",
                        data: e,
                        options: i
                    })
            }
            return t
        }()
    }, t.prototype.initCharts = function() {
        var t, r, a, e = [];
        return 0 < o("#task-area-chart").length && (t = {
            labels: ["Device 1", "Device 2", "Device 3", "Device 4", "Device 5", "Device 6", "Device 7",
                "Device 8", "Device 9", "Device 10", "Device 11", "Device 12", "Device 13", "Device 14",
                "Device 15"
            ],
            datasets: [{
                label: "This year",
                backgroundColor: o("#task-area-chart").data("bgcolor") || "#727cf5",
                borderColor: o("#task-area-chart").data("bordercolor") || "#727cf5",
                data: [50, 68, 34, 26, 44, 32, 48, 72, 60, 74, 52, 62, 50, 32, 22]
            }]
        }, e.push(this.respChart(o("#task-area-chart"), "Bar", t, {
            maintainAspectRatio: !1,
            barPercentage: .7,
            categoryPercentage: .5,
            plugins: {
                filler: {
                    propagate: !1
                },
                legend: {
                    display: !1
                },
                tooltips: {
                    intersect: !1
                },
                hover: {
                    intersect: !0
                }
            },
            scales: {
                x: {
                    grid: {
                        color: "rgba(0,0,0,0.05)"
                    }
                },
                y: {
                    ticks: {
                        stepSize: 10,
                        display: !1
                    },
                    min: 10,
                    max: 100,
                    display: !0,
                    borderDash: [5, 5],
                    grid: {
                        color: "rgba(0,0,0,0)",
                        fontColor: "#fff"
                    }
                }
            }
        }))), 0 < o("#project-status-chart").length && (a = {
            labels: ["Critical", "High", "Medium", "Low", "Info"],
            datasets: [{
                data: [{{ $dashboardData['vulnerability-total-critical'] }}, 
				{{ $dashboardData['vulnerability-total-high']}},
				{{ $dashboardData['vulnerability-total-medium']}},
				{{ $dashboardData['vulnerability-total-low'] }},
				{{ $dashboardData['vulnerability-total-info'] }}],
                backgroundColor: (r = o("#project-status-chart").data("colors")) ? r.split(",") : [
                    "#0acf97", "#727cf5", "#fa5c7c","rgb(255, 39, 0)","rgb(255, 188, 0)"
                ],
                borderColor: "transparent",
                borderWidth: "3"
            }]
        }, e.push(this.respChart(o("#project-status-chart"), "Doughnut", a, {
            maintainAspectRatio: !1,
            cutout: 80,
            plugins: {
                cutoutPercentage: 40,
                legend: {
                    display: !1
                }
            }
        }))), e
    }, t.prototype.init = function() {
        var r = this;
        Chart.defaults.font.family =
            '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,Oxygen-Sans,Ubuntu,Cantarell,"Helvetica Neue",sans-serif',
            r.charts = this.initCharts(), o(window).on("resizeEnd", function(t) {
                o.each(r.charts, function(t, r) {
                    try {
                        r.destroy()
                    } catch (t) {}
                }), r.charts = r.initCharts()
            }), o(window).resize(function() {
                this.resizeTO && clearTimeout(this.resizeTO), this.resizeTO = setTimeout(function() {
                    o(this).trigger("resizeEnd")
                }, 500)
            })
    }, o.ChartJs = new t, o.ChartJs.Constructor = t
}(window.jQuery),
function() {
    "use strict";
    window.jQuery.ChartJs.init()
}();
</script>



<!-- end demo js-->
@endpush

@section('main-body')

<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Scanner</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-sm-6 col-lg-4">
                            <div class="card shadow-none m-0">
                                <div class="card-body text-center">
                                    <i class=" dripicons-device-desktop text-muted" style="font-size: 24px;"></i>
                                    <h3><span>{{  $dashboardData ['total-devices'] }}</span></h3>
                                    <p class="text-muted font-15 mb-0">Total Devices</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-4">
                            <div class="card shadow-none m-0 border-start">
                                <div class="card-body text-center">
                                    <i class="dripicons-bell text-muted" style="font-size: 24px;"></i>
                                    <h3><span> {{ $dashboardData ['total-vulnerability'] }} </span></h3>
                                    <p class="text-muted font-15 mb-0">Total Alerts</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-4">
                            <div class="card shadow-none m-0 border-start">
                                <div class="card-body text-center">
                                    <i class=" dripicons-blog text-muted" style="font-size: 24px;"></i>
                                    <h3><span>{{ $dashboardData ['total-report'] }} </span></h3>
                                    <p class="text-muted font-15 mb-0">Reports</p>
                                </div>
                            </div>
                        </div>

                    </div> <!-- end row -->
                </div>
            </div> <!-- end card-box-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->

	@if($dashboardData ['total-devices'] != 0)
    <div class="row">
        <div class="col-lg-4" >
            <div class="card" id='pie-graph'>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Vulnerabilities</h4>
                    </div>

                    <div class="mt-3 mb-4 chartjs-chart" style="height: 207px;">
                        <canvas id="project-status-chart" data-colors="#0acf97,#727cf5,#fa5c7c,#ffbc00"></canvas>
                    </div>

                    <div class="row text-center mt-2 py-2">
                        <div class="col-sm-4">
                            <div class="my-2 my-sm-0">
                                <h3 class="fw-normal">
                                    <span>{{ number_format(($dashboardData['vulnerability-total-critical']/$dashboardData['vulnerability-total']) * 100, 1) }}%
                                    </span>
                                </h3>
                                <p class="text-muted mb-0">Critical</p>
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="my-2 my-sm-0">
                                <h3 class="fw-normal">
                                    <span>{{ number_format(($dashboardData['vulnerability-total-high']/$dashboardData['vulnerability-total']) * 100, 1) }}%
                                    </span>
                                </h3>
                                <p class="text-muted mb-0"> High</p>
                            </div>

                        </div>
                        <div class="col-sm-4">
                            <div class="my-2 my-sm-0">
                                <h3 class="fw-normal">
                                    <span>{{ number_format(($dashboardData['vulnerability-total-medium']/$dashboardData['vulnerability-total']) * 100, 1) }}%
                                    </span>
                                </h3>
                                <p class="text-muted mb-0"> Medium</p>
                            </div>
                        </div>
                    </div>
                    <!-- end row-->
					<div class="row text-center justify-content-center">
                        <div class="col-sm-4">
                            <div class="my-2 my-sm-0">
                                <h3 class="fw-normal">
                                    <span>{{ number_format(($dashboardData['vulnerability-total-low']/$dashboardData['vulnerability-total']) * 100, 1) }}%
                                    </span>
                                </h3>
                                <p class="text-muted mb-0"> Low</p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="my-2 my-sm-0">
                                <h3 class="fw-normal">
                                    <span>{{ number_format(($dashboardData['vulnerability-total-info']/$dashboardData['vulnerability-total']) * 100, 1) }}%
                                    </span>
                                </h3>
                                <p class="text-muted mb-0"> Info</p>
                            </div>
                        </div>
                    </div>
                    <!-- end row-->
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
	
	 <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4 class="header-title">Vulnerabilities</h4>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-hover mb-0" id="report-table">
                            <tbody>
                                @foreach($dashboardData ['scanReports'] as $scanReport )

                                <tr>
                                    <td>
                                        <h5 class="font-14 my-1"><a href="{{ url('scan-report/' . str_replace('sr_', '', $scanReport->code)) }}"
                                                class="text-body">{{  $scanReport->report_name }}</a>
                                        </h5>
                                        <span class="text-muted font-13">Scan Date
                                            (
                                            {{ \Carbon\Carbon::parse($scanReport->created_at)->format('d M Y H:i:s') }}
                                            )</span>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Critical </span>
                                        <br />
                                        <span
                                            class="font-14 mt-1 fw-normal">{{ $dashboardData['vulnerabilityCount'][$scanReport->report_name]['Critical'] }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">High</span>
                                        <h5 class="font-14 mt-1 fw-normal">
                                            {{ $dashboardData['vulnerabilityCount'][$scanReport->report_name]['High'] }}
                                        </h5>
                                    </td>
                                    <td>
                                        <span class="text-muted font-13">Medium</span>
                                        <h5 class="font-14 mt-1 fw-normal">
                                            {{ $dashboardData['vulnerabilityCount'][$scanReport->report_name]['Medium'] }}
                                        </h5>
                                    </td>

                                    <td>
                                        <span class="text-muted font-13">Low</span>
                                        <h5 class="font-14 mt-1 fw-normal">
                                            {{ $dashboardData['vulnerabilityCount'][$scanReport->report_name]['Low'] }}
                                        </h5>
                                    </td>

                                    <td>
                                        <span class="text-muted font-13">Info</span>
                                        <h5 class="font-14 mt-1 fw-normal">
                                            {{ $dashboardData['vulnerabilityCount'][$scanReport->report_name]['Info'] }}
                                        </h5>
                                    </td>

                                    <td>
                                        <span class="text-muted font-13">Total</span>
                                        <h5 class="font-14 mt-1 fw-normal">
                                            {{ $dashboardData['vulnerabilityCount'][$scanReport->report_name]['Total'] }}
                                        </h5>
                                    </td>
                                    <td class="table-action" style="width: 90px;">
                                        
                                        <a href="{{ url('scan-report/' . str_replace('sr_', '', $scanReport->code)) }}" class="action-icon delete-report"> <i
                                                class="mdi mdi-eye"></i></a>
                                    </td>
                                </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div> <!-- end table-responsive-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    
        
	</div>
    <!-- end row-->
	@endif

</div> <!-- container -->

@endsection