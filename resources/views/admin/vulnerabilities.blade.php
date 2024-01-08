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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
$(document).ready(function() {
	$(document).on('click', '.delete-vulnerability', function() { 
		var table = $('#products-datatable').DataTable();
		var tr = $(this).closest('tr');
		var vulnerabilityName = null;
		var rowIndex = -1;
		
		if(tr.hasClass('child')) {
			vulnerabilityName = tr.prev().data('vulnerabilityname');
		}
		else {
			vulnerabilityName = tr.data('vulnerabilityname');
		}
		
		$('#products-datatable tr[data-vulnerabilityName]').each(function(k, v) {
			if($(this).data('vulnerabilityname') === vulnerabilityName) {
				rowIndex = k;
			}
		});
		
        var confirmDelete = confirm("Are you sure you want to delete this vulnerability?");

        if (confirmDelete) {
			
			$.ajax({
                url: `/vulnerability_/${vulnerabilityName}`,
                type: 'GET',
                success: function(response) {
				table.row(rowIndex).remove().draw();
				toastr.success("Vulnerability deleted successfully");
            },
            error: function(error) {
				toastr.error("Deleting attempt unsuccessful.");
                }
            });
        }
    });
	
	$(document).on('click', '.detail-vulnerability', function() { 
		var table = $('#products-datatable').DataTable();
		var tr = $(this).closest('tr');
		var vulnerabilityName = null;
		
		if(tr.hasClass('child')) {
			vulnerabilityName = tr.prev().data('vulnerabilityname');
		}
		else {
			vulnerabilityName = tr.data('vulnerabilityname');
		}
		
		$.ajax({
			url: `vulnerability_details/${vulnerabilityName}`,
			type: 'GET',
			success: function(response) {
				
				Swal.fire({
					icon: 'info',
					title: 'Vulnerability Details',
					width: '50%',
					html: formatVulnerabilityDetails(response.vulnerability[0]),
				});
			},
			error: function(error) {
				toastr.error("Retrieving vulnerability details unsuccessful.");
			}
		});
    });
});

// Helper function to format vulnerability details
function formatVulnerabilityDetails(details) {
    return `
        <div style="text-align: left;">
            
			<div> <strong>Device Name:</strong> ${details.device_name} </div> <br> 
			<div> <strong>Host:</strong> ${details.host} </div> <br>
			<div> <strong>Vulnerability Name:</strong> ${details.name} </div> <br>
			<div> <strong>Plugin Output:</strong> ${details.plugin_output} </div> <br>
			
            <div> <strong>Protocol:</strong> ${details.protocol} </div> <br>
            <div> <strong>Vulnerability Description:</strong> ${details.description} </div> <br>
            <div> <strong>Helping Note:</strong> ${details.see_also} </div> <br>
            <div> <strong>Solution:</strong> ${details.solution} </div> <br>
        </div>
    `;
}

</script>

@endpush

@section('main-body')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Vulnerabilities</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable">
                            <thead class="table-light">
                                <tr>
                                    <th class="all" style="width: 20px;">
                                        Delete
                                    </th>
                                    <th class="all">Client</th>
                                    <th>Plugin Id</th>
                                    <th style="width: 150px !important;">vulnerability Name</th>
                                    <th>Host</th>
                                    <th>Reported At</th>
                                    <th>Severity</th>
                                    <th style="width: 85px;">Action</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach($vulnerabilities as $vulnerability )
                                <tr data-vulnerabilityName="{{ str_replace('vu_', '', $vulnerability->code) }}">
                                    <td>
                                        <div class="form-check">
                                            fasdsd
                                        </div>
                                    </td>

                                    <td>
                                        <p class="m-0 d-inline-block align-middle font-16">
                                            <a href="apps-ecommerce-products-details.html" class="text-body">{{$vulnerability->device_name}}
                                            </a>
                                            <br />
                                        </p>
                                    </td>
                                    <td>
                                        <a href='https://www.tenable.com/plugins/nessus/{{$vulnerability->plugin_id}}'
                                            target=" _blank">
                                            {{$vulnerability->plugin_id}}</a>

                                    </td>
                                    <td style="width: 250px; word-wrap: break-word; ">
                                        {{$vulnerability->name}}
                                    </td>
                                    <td>

                                        {{$vulnerability->host}}
                                    </td>
                                    <td>
                                        24/Feb/2012:17:48:13 GMT
                                    </td>
                                    <td>

                                        @php
                                        // Determine background color based on vulnerability host
                                        $backgroundColor = '';
                                        switch ($vulnerability->risk) {
                                        case 'Critical':
                                        $backgroundColor = '#91243E';
                                        break;
                                        case 'High':
                                        $backgroundColor = '#DD4B50';
                                        break;
                                        case 'Medium':
                                        $backgroundColor = '#F18C43';
                                        break;
                                        case 'Low':
                                        $backgroundColor = '#F8C851';
                                        break;
                                        case 'Info':
                                        default:
                                        $backgroundColor = '#67ACE1';
                                        }
                                        @endphp

                                        <span class="badge"
                                            style="background-color: {{ $backgroundColor }};">{{ $vulnerability->risk }}</span>
                                        <!-- You can include other details as needed -->

                                    </td>
                                    <td class="table-action">
                                        <a href="javascript:void(0);" class="action-icon detail-vulnerability"> <i
                                                class="mdi mdi-eye"></i></a>
                                        <a href="javascript:void(0);" class="action-icon delete-vulnerability">
                                            <i class="mdi mdi-delete"></i>
                                        </a>
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