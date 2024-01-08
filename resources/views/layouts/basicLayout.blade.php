<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Fazeel Khalid">

    <title>Armora</title>

    <link href=" {{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-lg navbar-expand-lg navbar-transparant navbar-dark navbar-absolute w-100">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Armora.</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    <!-- <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Pages
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="pages-landing.html">Landing</a>
                            <a class="dropdown-item" href="pages-dashboard.html">Dashboard</a>
                            <a class="dropdown-item" href="pages-general.html">General</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Components
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="components-bootstrap.html">Bootstrap</a>
                            <a class="dropdown-item" href="components-robust.html">Robust</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Docs
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="getting-started.html">Introduction</a>
                            <a class="dropdown-item" href="getting-started.html#quick-start">Quick start</a>
                            <a class="dropdown-item" href="getting-started.html#build-tools">Build tools</a>
                            <a class="dropdown-item" href="getting-started.html#contents">Contents</a>
                            <a class="dropdown-item" href="getting-started.html#changelog">Changelog</a>
                        </div>
                    </li> -->
                </ul>
                <a class="btn btn-outline-white" data-toggle="modal" data-target="#signin" target="_blank">Login</a>
            </div>
        </div>
    </nav>

    <div>
        @yield('main-body')
    </div>

    <footer role="contentinfo" class="py-6 lh-1 bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <h3 class="h4 mb-4">Armora.</h3>
                </div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-3 col-sm-6">
                            <h4 class="h6">Address</h4>
                            <address>
                                <ul class="list-unstyled">
                                    <li>
                                        City Hall<br>
                                        212 Street<br>
                                        Lawoma<br>
                                        735<br>
                                    </li>
                                </ul>
                            </address>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <h4 class="h6">Popular Services</h4>
                            <ul class="list-unstyled">
                                <li><a href="#">Payment Center</a></li>
                                <li><a href="#">Contact Directory</a></li>
                                <li><a href="#">Forms</a></li>
                                <li><a href="#">News and Updates</a></li>
                                <li><a href="#">FAQs</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <h4 class="h6">Website Information</h4>
                            <ul class="list-unstyled">
                                <li><a href="#">Website Tutorial</a></li>
                                <li><a href="#">Accessibility</a></li>
                                <li><a href="#">Disclaimer</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">FAQs</a></li>
                                <li><a href="#">Webmaster</a></li>
                            </ul>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <h4 class="h6">Company</h4>
                            <ul class="list-unstyled">
                                <li><a href="#">Our team</a></li>
                                <li><a href="#">About</a></li>
                                <li><a href="#">Contact</a></li>
                                <li><a href="https://themes.getbootstrap.com/product/robust-ui-kit-dashboard-landing/"
                                        target="_blank">Purchase</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12 text-center text-sm">
                    <p class="mb-0">&copy; {{ date('Y') }} - <a href="{{ url('/') }}">Armora</a>.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="js/app.js"></script>
</body>

</html>