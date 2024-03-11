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
	
	$(document).on('click', '.delete-system', function() { 
	
		var rowIndex = $(this).closest('tr')[0].rowIndex;
		var table = $('#products-datatable').DataTable();
		
		var systemName = $(this).closest('tr').data('devicename');
		
        var confirmDelete = confirm("Are you sure you want to delete this vulnerability?");
		console.log(systemName);
        if (confirmDelete) {
			table.row(rowIndex - 1).remove().draw();
			$.ajax({
                url: `{{ url ('system_') }}/${systemName}`,
                type: 'get',
                success: function(response) {
				toastr.success("System deleted successfully");
            },
            error: function(error) {
				toastr.error("Deleting attempt unsuccessful.");
                }
            });
        }
    });
	
	$(document).on('click', '.start-scan', function() { 
	
		var rowIndex = $(this).closest('tr')[0].rowIndex;

		var systemName = $(this).closest('tr').data('devicename');
		
        var confirmDelete = confirm("Are you sure you want to start scan on this device?");
		console.log(systemName);
        if (confirmDelete) {
			$.ajax({
                url: `{{ url ('start-scan') }}/${systemName}`,
                type: 'get',
                success: function(response) {
				toastr.success(response.message);
            },
            error: function(error) {
				toastr.error(error.responseJSON.error);
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
                <h4 class="page-title">Clients</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-5">
                            <a class="btn btn-danger mb-2" id="btn-new-client"> <i class="mdi mdi-plus-circle me-2"></i>
                                Add Client</a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable">
                            <thead class="table-light">
                                <tr>
                                    <th class="all" style="width: 20px;">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="customCheck1">
                                            <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                        </div>
                                    </th>
                                    <th class="all">Client Name</th>
                                    <th>MAC Address</th>
                                    <th>Operating System</th>
                                    <th>API Key</th>
                                    <th>Creation Date</th>
                                    <th>Status</th>
                                    <th style="width: 85px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($devices as $device)
                                <tr data-devicename="{{ str_replace('de_', '', $device->code) }}">
                                    <td>
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="customCheck2">
                                            <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                        </div>
                                    </td>

                                    <td>
                                        <p class="m-0 d-inline-block align-middle font-16">
                                            <a
                                                class="text-body">{{ $device->device_name }}</a>
                                            <br />
                                        </p>
                                    </td>
                                    <td>
                                        {{ $device->MAC_address }}
                                    </td>
                                    <td>
                                        {{ $device->operating_system }}
                                    </td>
                                    <td>
                                        {{ $device->auth_key }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($device->created_at)->format('d M Y') }}
                                    </td>
                                    <td>
                                        @if($device->is_active)
                                        <span class="badge bg-success">ON</span>
                                        @else
                                        <span class="badge bg-danger">OFF</span>
                                        @endif
                                    </td>
                                    <td class="table-action">
                                        <a href="javascript:void(0);" class="action-icon delete-system"> <i
                                                class="mdi mdi-delete"></i></a>
										
										@if($device->is_active)
											<a href="javascript:void(0);" class="action-icon start-scan" style="color: green;" title="Start Scan"> <i
                                                class="mdi mdi-restart"></i></a>
										@else
											<a class="action-icon start-scan" style="color: red; cursor: not-allowed;" title="Device Inactive" disabled>  <i class="mdi mdi-restart"></i> </a>
                                        @endif
                                        		
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->



    </div>
    <!-- end row -->

</div> <!-- container -->



@endsection