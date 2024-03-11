@extends('layouts.adminLayout')
@php
use Illuminate\Support\Str;
@endphp



@push('page-js')
<script>

$(document).ready(function() {
	$(document).on('click', '.delete-btn-inside', function() { 
		var reportName = $(this).data('scanreportname');
		var card = $(this).closest('.scanreport-card');
        var confirmDelete = confirm("Are you sure you want to delete this vulnerability?");
        if (confirmDelete) {
			$.ajax({
				url: `/report_/${reportName}`,
                type: 'GET',
                success: function(response) {
				card.hide();
				toastr.success("Report deleted successfully");
            },
            error: function(error) {
					toastr.error("Deleting attempt unsuccessful.");
                }
            });
        }
    });
	
	
});

</script>

@endpush


@section('main-body')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Report Wise Vulnerabilities</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->


    <div class="row">

        @if ($scanReports->isEmpty())
        <div class="col-md-12 col-xxl-3 d-flex align-items-center justify-content-center">
            <!-- project card -->
            <div class="card d-block">
                <div class="card-body text-center">
                    <div class="alert alert-info" role="alert">
                        No scan reports found. Consider performing a scan or check back later.
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->

        @else

        @foreach($scanReports as $scanReport )
        <div class="col-md-6 col-xxl-3 scanreport-card">
            <!-- project card -->
            <div class="card d-block">
                <div class="card-body">
                    <!-- project title-->
                    <h4 class="mt-0">
                        <a href="{{ url('scan-report/' . str_replace('sr_', '', $scanReport->code)) }}"
                            class="text-title">{{ $scanReport->report_name }}</a>
                    </h4>
                    <div class="badge" style="background-color: #91243E; color: white;">
                        {{ $vulnerabilityCount[$scanReport->report_name]['Critical'] }}</div>
                    <div class="badge" style="background-color: #DD4B50; color: white;">
                        {{ $vulnerabilityCount[$scanReport->report_name]['High'] }}</div>
                    <div class="badge" style="background-color: #F18C43; color: white;">
                        {{ $vulnerabilityCount[$scanReport->report_name]['Medium'] }}</div>
                    <div class="badge" style="background-color: #F8C851; color: white;">
                        {{ $vulnerabilityCount[$scanReport->report_name]['Low'] }}</div>
                    <div class="badge" style="background-color: #67ACE1; color: white;">
                        {{ $vulnerabilityCount[$scanReport->report_name]['Info'] }}</div>

                    @if ($vulnerabilityCount[$scanReport->report_name]['Total'] > 0)
                    <p class="text-muted font-13 my-3">
                        {{ Str::limit(str_replace("\n", ' ', $scanReport->vulnerabilities->first()->description ?? ""), 50, '...') }}
                        <a href="{{ url('scan-report/' . str_replace('sr_', '', $scanReport->code)) }}" class="
                            fw-bold text-muted">view more</a>
                    </p>
                    @else
                    <p class="text-muted font-13 my-3">
                        No vulnerabilities found in this report.
                    </p>
                    @endif

                    <!-- project detail-->
                    <p class="mb-1">
                        <span class="pe-2 text-nowrap mb-2 d-inline-block">
                            <i class="mdi mdi-format-list-bulleted-type text-muted"></i>
                            <b>{{ $vulnerabilityCount[$scanReport->report_name]['Total'] }}</b> Total Vulnerabilities
                        </span>
                    </p>
                </div> <!-- end card-body-->
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" style="margin-top: -10% !important;">
                        <!-- project progress-->
                        <p class="mb-2 fw-bold">Reported <span
                                class="float-end">{{ \Carbon\Carbon::parse($scanReport->created_at)->format('d M Y H:i:s') }}</span>
                        </p>
                        <div class="progress progress-sm">
                            <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                aria-valuemax="100" style="width: 100%;">
                            </div><!-- /.progress-bar -->
                        </div><!-- /.progress -->
                    </li>
                </ul>
            <a class="btn text-dark delete-btn-inside" data-scanreportname="{{ str_replace('sr_', '', $scanReport->code) }}">
				<i class="mdi mdi-delete"></i>
			</a>
			<a target= "_blank" href="{{ url('download-report/' . str_replace('sr_', '', $scanReport->code)) }}" class="btn text-dark download-btn-inside" >
				<i class="mdi mdi-download-box"></i>
			</a>
			</div> <!-- end card-->
        	
		</div> <!-- end col -->
        @endforeach
        @endif



    </div>
    <!-- end row-->
</div> <!-- container -->



@endsection