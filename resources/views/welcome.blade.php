@extends('layouts.basicLayout')

@section('main-body')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="intro py-8 bg-primary position-relative text-white">
    <div class="bg-overlay-primary">
        <img src="img/photos/8.jpg" class="img-fluid img-cover" alt="Robust UI Kit" />
    </div>
    <div class="intro-content mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <h1 class="display-4 mb-3">Your Gateway to a<br /> Secure Tomorrow</h1>
                    <p class="lead mb-4">Where security meets innovation. Protecting your assets, fueling growth.
                        Let's build a brighter future.</p>
                </div><!-- /.col-md-6 -->
                <div class="col-md-5 ml-auto">
                    <div class="card">
                        <div class="card-body text-dark">
                            <form>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter your email">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password"
                                        placeholder="Enter your password">
                                </div>
                                <div class="form-group">
                                    <label for="password-repeat">Repeat password</label>
                                    <input type="password" class="form-control" id="password-repeat"
                                        placeholder="Repeat your password">
                                </div>
                                <button type="submit" class="btn btn-success btn-block btn-lg mb-2">Sign up</button>
                                <div class="text-center">
                                    Already have an account? <a href="#">Sign in</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!-- /.col-md-6 -->
            </div>
        </div>
    </div>
</div>

<main class="main" role="main">
    <div class="bg-white py-7">
        <div class="container">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <div class="row">
                        <div class="col-md-4 ml-auto">
                            <h2>Uncover Vulnerabilities, Ensure Security</h2>
                        </div>
                        <div class="col-md-6 mr-auto">
                            <p class="lead text-dark">
                                Explore our advanced vulnerability detection tool. We identify weaknesses,
                                empowering your business with enhanced security. Stay protected effortlessly.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="media">
                        <div class="icon mr-3">
                            <i class="far fa-id-badge"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="h4">Smart Scanning</h3>
                            <p class="text-dark text-left">
                                Efficiently identifies and pinpoints system vulnerabilities in seconds.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="media">
                        <div class="icon mr-3">
                            <i class="far fa-hand-scissors"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="h4">Real-time Alerts</h3>
                            <p class="text-dark text-left">
                                Instant notifications ensure immediate response to security threats.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="media">
                        <div class="icon mr-3">
                            <i class="far fa-comments"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="h4">Premium support</h3>
                            <p class="text-dark text-left">
                                Scheduled, recurring scans ensure continuous vulnerability monitoring and timely
                                insights.
                            </p>
                        </div>
                    </div>
                </div>
            </div><!-- /.row -->
        </div>
    </div>


    <div class="py-6 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h3>What others are saying</h3>
            </div>
        </div>
        <div data-flickity='{ "prevNextButtons": false, "wrapAround": true}'>
            <div class="carousel-cell">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 mx-auto">
                            <div class="media">
                                <img src="img/avatars/1.jpg" alt="Avatar" class="img-fluid rounded-circle mr-4"
                                    style="max-width:128px;" />
                                <div class="media-body">
                                    <blockquote class="h3 font-weight-normal">
                                        “This tool is a game-changer! It identified vulnerabilities we didn't even
                                        know existed, allowing us to secure our systems effectively! ”
                                    </blockquote>
                                    <span> Sarah M.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-cell">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 mx-auto">
                            <div class="media">
                                <img src="img/avatars/2.jpg" alt="Avatar" class="img-fluid rounded-circle mr-4"
                                    style="max-width:128px;" />
                                <div class="media-body">
                                    <blockquote class="h3 font-weight-normal">
                                        “The real-time alerts feature saved us from a potential cyber disaster. We
                                        could respond swiftly, thanks to this tool. Highly recommended for any
                                        business! ”
                                    </blockquote>
                                    <span>John Roe</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-cell">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 mx-auto">
                            <div class="media">
                                <img src="img/avatars/3.jpg" alt="Avatar" class="img-fluid rounded-circle mr-4"
                                    style="max-width:128px;" />
                                <div class="media-body">
                                    <blockquote class="h3 font-weight-normal">
                                        “Detailed reports provided by this tool are invaluable. They offer precise
                                        insights, enabling us to make informed decisions about our cybersecurity
                                        strategies. Exceptional service!”
                                    </blockquote>
                                    <span>Emily T</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-6 bg-white">
        <div class="container">

            <div class="row mb-6">
                <div class="col-md-3 ml-auto">
                    <h2>Empowering Your Security Journey</h2>
                </div>
                <div class="col-md-5 mr-auto">
                    <p class="lead text-dark">
                        Discover the cutting-edge features that redefine cybersecurity, ensuring your digital
                        fortress stays impenetrable.
                    </p>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="media">
                        <div class="icon mr-3">
                            <i class="far fa-id-badge"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="h4">Smart Scanning</h3>
                            <p class="text-dark text-left">
                                Efficiently identifies and pinpoints system vulnerabilities in seconds.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="media">
                        <div class="icon mr-3 bg-warning">
                            <i class="far fa-hand-scissors"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="h4">Real-time Alerts</h3>
                            <p class="text-dark text-left">
                                Instant notifications ensure immediate response to security threats.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="media">
                        <div class="icon mr-3 bg-danger">
                            <i class="far fa-comments"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="h4">Premium support</h3>
                            <p class="text-dark text-left">
                                Scheduled, recurring scans ensure continuous vulnerability monitoring and timely
                                insights.
                            </p>
                        </div>
                    </div>
                </div>
            </div><!-- /.row -->

            <div class="row mt-5">
                <div class="col-md-4">
                    <div class="media">
                        <div class="icon mr-3 bg-success">
                            <i class="far fa-clone"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="h4">Cross-Platform Compatibility</h3>
                            <p class="text-dark text-left">
                                Compatible with Windows, Linux, and macOS servers, ensuring thorough assessments
                                across diverse platforms.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="media">
                        <div class="icon mr-3 bg-purple">
                            <i class="far fa-gem"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="h4">Efficient Resource Utilization</h3>
                            <p class="text-dark text-left">
                                Optimized algorithms ensure minimal resource consumption, maximizing system
                                performance during scans.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="media">
                        <div class="icon mr-3">
                            <i class="far fa-arrow-alt-circle-down"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="h4">Backup and Restore</h3>
                            <p class="text-dark text-left">
                                From time to time you'll receive an update containing new components, improvements
                                and bugfixes.
                            </p>
                        </div>
                    </div>
                </div>
            </div><!-- /.row -->
        </div>
    </div>

    <div class="py-6 bg-danger text-white">
        <div class="container">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    <div class="row">
                        <div class="col-md-4 ml-auto">
                            <h2>Versatile Platform Compatibility</h2>
                        </div>
                        <div class="col-md-6 mr-auto">
                            <p class="lead text-light">
                                Our tool seamlessly integrates with Windows, Linux, and other servers, ensuring
                                comprehensive vulnerability assessments across diverse platforms. </p>
                        </div>
                    </div>
                    <div class="row align-items-center my-md-4 text-center">
                        <div class="col">
                            <i class="fab fa-4x fa-microsoft"></i>
                        </div>
                        <div class="col">
                            <i class="fab fa-4x fa-linux"></i>
                        </div>
                        <div class="col">
                            <i class="fab fa-4x fa-apple"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>



<div class="modal fade" id="signin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Join the Secure Revolution</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" type="email" name="email" placeholder="Enter your email" />
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input class="form-control" type="password" name="password"
                                placeholder="Enter your password" />
                            <small><a data-toggle="modal" data-target="#forget-password" target="_blank">Forgot
                                    password?</a></small>
                        </div>
                        <div class="text-center mt-3">
                            <a href="pages-dashboard.html" class="btn btn-primary">Sign in</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="forget-password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset Your Passwordaa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Email</label>
                            <input class="form-control" type="email" name="email" placeholder="Enter your email" />
                        </div>
                        <div class="text-center mt-3">
                            <a href="pages-dashboard.html" class="btn btn-primary">Reset Password</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    // When the forget-password modal is shown, hide the signin modal
    $('#forget-password').on('show.bs.modal', function(e) {
        $('#signin').modal('hide');
    });

    // When the signin modal is shown, hide the forget-password modal
    $('#signin').on('show.bs.modal', function(e) {
        $('#forget-password').modal('hide');
    });
});
</script>



@endsection