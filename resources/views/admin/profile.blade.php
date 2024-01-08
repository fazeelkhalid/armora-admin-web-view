@extends('layouts.adminLayout')


@section('main-body')
<!-- Start Content-->
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Profile</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card text-center">
                <div class="card-body">

                    <form method="post" action="{{ route('admin.update-profile-picture') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div style="position: relative; display: inline-block;">
                            <!-- Profile Image -->
                            <img src="{{ asset($user->profile_image ? 'storage/'.$user->profile_image : 'admin/assets/images/users/avatar-1.jpg') }}"
                                class="rounded-circle avatar-lg img-thumbnail" alt="profile-image" id="profileImage">

                            <!-- Camera Icon -->
                            <div
                                style="position: absolute; bottom: 0; right: 0; background-color: #fff; border-radius: 50%; padding: 5px; cursor: pointer;">
                                <i style="color: #333;" class="dripicons-camera"></i>
                            </div>
                        </div>

                        <h4 class="mb-0 mt-2">{{ auth()->user()->name }}</h4>
                        <p class="text-muted font-14"></p>

                        <!-- Hidden file input -->
                        <input type="file" name="profile_pic" id="profile_pic_input" accept="image/*"
                            style="display: none;">

                        <button type="submit" class="btn btn-success btn-sm mb-2">Save Pic</button>
                    </form>
                    <div class="text-start mt-3">
                        <h4 class="font-13 text-uppercase">About Me :</h4>
                        <p class="text-muted font-13 mb-3">
                            {{ $user->bio ?? 'Nothing here in the bio' }}
                        </p>
                        <p class="text-muted mb-2 font-13"><strong>Full Name :</strong> <span
                                class="ms-2">{{ $user->name }}</span>
                        </p>

                        <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span
                                class="ms-2 ">{{ $user->email }}</span></p>
                        @if( $user->company_name !== '' && $user->company_website !== '' )
                        <p class="text-muted mb-1 font-13"><strong>Comapny Name:</strong> <span class="ms-2">
                                <a href="{{ $user->company_website }}">
                                    {{ $user->company_name }}</a>
                            </span>
                        </p>
                        @endif
                    </div>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col-->

        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="settings">
                            <form method="POST" action="{{ route('admin.update-profile') }}">
                                @csrf
                                <h5 class="mb-4 text-uppercase"><i class="mdi mdi-account-circle me-1"></i> Personal
                                    Info</h5>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" name="name" class=" form-control" id="name"
                                                placeholder="Enter your name" value="{{ $user->name }}">
                                        </div>
                                    </div>
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="userbio" class="form-label">Bio</label>
                                            <textarea class="form-control" name="bio" id="userbio" rows="4"
                                                placeholder="Write something...">{{ $user->bio }}</textarea>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id=" useremail"
                                                placeholder="Server Error" value={{ $user->email }} disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="userpassword" class="form-label">Password</label>
                                            <input type="password" class="form-control" name="password"
                                                id="userpassword" placeholder="Enter Password">
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <h5 class="mb-3 text-uppercase bg-light p-2"><i
                                        class="mdi mdi-office-building me-1"></i> Company Info</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="companyname" class="form-label">Company Name</label>
                                            <input type="text" class="form-control" id="companyname"
                                                placeholder="Company Name" name="company_name"
                                                value="{{ $user->company_name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cwebsite" class="form-label">Website</label>
                                            <input type="text" class="form-control" id="cwebsite"
                                                placeholder="Company Website" name="company_website"
                                                value="{{ $user->company_website }}">
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->


                                <div class="text-end">
                                    <button type="submit" class="btn btn-success mt-2"><i
                                            class="mdi mdi-content-save"></i> Save</button>
                                </div>
                            </form>
                        </div>
                        <!-- end settings content-->

                    </div> <!-- end tab-content -->
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row-->
    <!-- end row-->
</div> <!-- container -->



@endsection

@push('page-js')
<script>
$(document).ready(function() {
    $('#profileImage').on('click', function() {
        $('#profile_pic_input').click();
    });

    $('#profile_pic_input').on('change', function() {
        var input = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#profileImage').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    });
});
</script>

@endpush