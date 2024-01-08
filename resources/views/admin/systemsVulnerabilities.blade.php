@extends('layouts.adminLayout')


@push('page-css')
<link href="{{ asset('admin/assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css">
@endpush


@push('page-js')
<!-- third party js -->
<script src="{{ asset('admin/assets/js/vendor/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
<script src="{{ asset('admin/assets/js/vendor/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/vendor/dataTables.checkboxes.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/pages/table.js') }}"></script>


<script>

$(document).ready(function() {
	$(document).on('click', '.delete-btn-inside', function() { 
	
		var systemName = $(this).data('devicename');
		var card = $(this).closest('.system-card-icon');
	
        var confirmDelete = confirm("Are you sure you want to delete this System?");
        if (confirmDelete) {

			$.ajax({
                url: `/system_/${systemName}`,
                type: 'GET',
                success: function(response) {
				card.hide();
				toastr.success("System deleted successfully");
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
                <h4 class="page-title">Client Vulnerabilities</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
	<?php if(count($devices)) { ?>
    <div class="row">
        <!-- Right Sidebar -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
					
                    <div class="mt-3">
                        <h5 class="mb-2">Quick Access</h5>

                        <div class="row mx-n1 g-0">

                            @foreach ($devices as $device)
                            <div class="col-xxl-3 col-lg-6 system-card-icon">
                                <div class="card m-1 shadow-none border">
                                    <div class="p-2">
                                        <a href="{{ url('system/' . str_replace('de_', '', $device->code)) }}"
                                            class="text-muted fw-bold">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="avatar-sm">
                                                        <span class="avatar-title bg-light text-secondary rounded">
                                                            <i class="mdi mdi-desktop-mac font-16"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col ps-0">
                                                    <p class="mb-0 font-17">
                                                        {{ $device->device_name }}
                                                    </p>

                                                    <p class="mb-0 font-13">
                                                        {{ $reportCount[$device->device_name]['Total'] }} Report

                                                        @if(!$device->is_verified)
                                                        (Not Connected)
                                                        @endif
                                                    </p>
                                                </div>
                                            </div> <!-- end row -->
                                        </a>
                                        <a class="btn text-dark delete-btn-inside" data-devicename="{{ str_replace('de_', '', $device->code) }}">
                                            <i class="mdi mdi-delete"></i>
                                        </a>
                                    </div> <!-- end .p-2-->
                                </div> <!-- end col -->
                            </div> <!-- end col-->
                            @endforeach

                        </div> <!-- end row-->
                    </div> <!-- end .mt-3-->
                </div>
                <!-- end card-body -->
                <div class="clearfix"></div>
            </div> <!-- end card-box -->

        </div> <!-- end Col -->
    </div><!-- End row -->
	<?php } ?>
</div> <!-- container -->



@endsection