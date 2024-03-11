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
                <h1 class="text-error">4<i class="mdi mdi-emoticon-sad"></i>4</h1>
                <h4 class="text-uppercase text-danger mt-3">Page Not Found</h4>
                <p class="text-muted mt-3">It's looking like you may have taken a wrong turn. Don't worry... it
                    happens to the best of us. Here's a
                    little tip that might help you get back on track.</p>

                <a class="btn btn-info mt-3" href="{{ route('admin.home') }}"><i class="mdi mdi-reply"></i> Return Home</a>
            </div>
        </div> <!-- end card-body-->
    </div>
    <!-- end card -->
</div> <!-- end col -->

@endsection