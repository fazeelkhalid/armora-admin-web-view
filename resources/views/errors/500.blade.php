@extends('layouts.authLayout')

@section('main-body')
<div class="col-xxl-4 col-lg-5">
    <div class="card">
       <!-- Logo -->
       <div class="card-header pt-4 pb-4 text-center bg-primary">
            <a href="{{ route('admin.home') }}">
                <span><img src="{{ asset('admin/assets/images/logo.png') }}" alt="" height="18"></span>
            </a>
        </div>
        
        <div class="card-body p-4">

            <div class="text-center">
                <img src="{{ asset('admin/assets/images/startman.svg') }}" height="120" alt="File not found Image">

                <h1 class="text-error mt-4">500</h1>
                <h4 class="text-uppercase text-danger mt-3">Internal Server Error</h4>
                <p class="text-muted mt-3">Why not try refreshing your page? </p>

                <a class="btn btn-info mt-3" href="{{ route('admin.home') }}"><i class="mdi mdi-reply"></i> Return Home</a>
            </div>

        </div> <!-- end card-body-->
    </div>
    <!-- end card-->
    
</div> <!-- end col -->

@endsection