<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Loacal') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('dist/bootstrap/css/bootstrap.min.css')}}" crossorigin="anonymous" type="text/css">
    <link href="{{ asset('dist/bxslider/jquery.bxslider.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/lightbox2/css/lightbox.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/slick-1.6.0/slick/slick.css') }}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet" type="text/css">
    <link href="{{ asset('dist/sumo-select/sumoselect.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dist/bootstrap-datepicker-1.6.4/css/bootstrap-datepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/bootstrap-datepicker-1.6.4/css/bootstrap-datepicker3.css') }}" />
    <link rel="stylesheet" href="{{ asset('dist/bootstrap-slider/css/bootstrap-slider.min.css') }}" />
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('dist/bootstrap-select-1.12.2/css/bootstrap-select.min.css') }}">

    <!-- Flags Sprite -->
    <link rel="stylesheet" type="text/css" href="{{ asset('dist/world-flags-sprite/stylesheets/flags32.css') }}" />
    <link href="{{ asset('css/loacal.css') }}" rel="stylesheet">

    <script src="{{asset('dist/jquery-1.9.1/jquery.min.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    {{--
    <script src="{{ asset('dist/jquery/jquery-3.2.1.min.js') }}"></script>--}} {{--
    <script src="{{ asset('dist/jquery/jquery-migrate-3.0.0.min.js') }}"></script>--}}


    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtScuOyarJqca-s_4NjQQTXukOxVsy-SY&libraries=places"></script>
    <script src="{{ asset('dist/gmaps/gmaps.js') }}"></script>

    <script src="{{ asset('dist/bxslider/jquery.bxslider.min.js') }}"></script>
    <script src="{{ asset('dist/lightbox2/js/lightbox.min.js') }}"></script>
    <script src="{{ asset('dist/slick-1.6.0/slick/slick.js') }}"></script>
    <script src="{{asset('dist/sumo-select/jquery.sumoselect.min.js')}}"></script>
    <script src="{{asset('dist/gmaps/locationlist.js')}}"></script>

    {{--
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>--}}

    <script src="{{ asset('dist/bootstrap-datepicker-1.6.4/js/bootstrap-datepicker.min.js') }}"></script>

    {{-- Price Slider --}}
    <script src="{{ asset('dist/bootstrap-slider/js/bootstrap-slider.min.js') }}"></script>

    {{-- Bootstrap Select --}} {{-- https://silviomoreto.github.io/bootstrap-select/ --}}
    <!-- Latest compiled and minified JavaScript -->
    <script src="{{ asset('dist/bootstrap-select-1.12.2/js/bootstrap-select.min.js') }}"></script>
    <link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">
</head>

<body>
    <div id="app">
        @if (substr(Route::currentRouteAction(), (strpos(Route::currentRouteAction(), '@') + 1))== "homepage")
        <nav class="navbar navbar-default homepage" id="header">
            @else
            <nav class="navbar navbar-default" id="header">
                @endif
                <div class="container-fluid">
                    <div class="navbar-header">

                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expande="true" aria-controls="navbar">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                        <!-- Branding Image -->
                        <a class="navbar-brand" href="{{ url('/') }}">
                            <img id="mainLogo" alt="Loacal Logo" src="{{ asset('css/images/loacal_logo.png') }}">
                        </a>
                    </div>


                    @if (substr(Route::currentRouteAction(), (strpos(Route::currentRouteAction(), '@') + 1)) != "homepage")
                    <ul class="nav navbar-nav hide-on-mobile">
                        <form class="navbar-form" action="/experiences" role="search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search Experiences" name="search" id="srch-term">
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><i style="font-size: 15px;" class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </ul>
                    @endif
                    <!-- Left Side Of Navbar -->


                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right" id="navbar">
                        <li>
                            <a href="{{ route('experience.index') }}">
                                <i class="fa fa-globe" aria-hidden="true"></i><span class="menu-view-all-experiences">View All Experiences</span>
                            </a>
                        </li>
                        @role(['super_admin','admin'])
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user-secret" aria-hidden="true"></i>Admin
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('users.index') }}">Users</a></li>
                                <li><a href="{{ route('experience.manage') }}">Experiences</a></li>
                                <li><a href="{{ route('certificates.index') }}">Certificates</a></li>
                                <li><a href="{{ route('roles.index') }}">Roles</a></li>
                                <li><a href="{{ route('categories.index') }}">Categories</a></li>
                                <li><a href="{{ route('languages.index') }}">Experience Languages</a></li>
                                <li><a href="{{ route('countries.index') }}">Experience Countries</a></li>
                                <li><a href="/loacal-applications">Loacal Applications</a></li>
                                <li><a href="#">Translations</a></li>
                            </ul>
                        </li>
                        @endrole
                        <hr class="only-on-mobile">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-language" aria-hidden="true"></i>{{ LaravelLocalization::getCurrentLocaleName() }}
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <li>
                                    <a rel="alternate" hreflang="{{$localeCode}}" href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
                                        {{ $properties['native'] }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>

                        <!-- Authentication Links -->
                        @if (Auth::guest())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i>Login
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('login') }}">
                                        <i class="fa fa-sign-in" aria-hidden="true"></i>Login
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('register') }}">
                                        <i class="fa fa-user-plus" aria-hidden="true"></i>Register
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @else
                        <li class="">
                            <a href="{{ route('booking') }}">
                                <i class="fa fa-envelope" aria-hidden="true"></i> Message Box @include('booking.unread-count')
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i> {{ $auth->name }} <span class="caret"></span>
                            </a>

                            <ul class='dropdown-menu'>
                                <li>
                                    <a href='/my-account'>
                                        <i class='fa fa-home' aria-hidden='true'></i>{{ Lang::get('menu.myaccount') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class='fa fa-sign-out' aria-hidden='true'></i>Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                        @endif
                        <hr class="only-on-mobile">
                        <li class="only-on-mobile"><a href="/about-us">{{ Lang::get('footer.about_us') }}</a></li>
                        <li class="only-on-mobile"><a href="/careers">{{ Lang::get('footer.careers') }}</a></li>
                        <li class="only-on-mobile"><a href="#">{{ Lang::get('footer.blog') }}</a></li>
                        <li class="only-on-mobile"><a href="/what-is-a-loacal">{{ Lang::get('footer.what_is_a_loacal') }}</a></li>
                        <li class="only-on-mobile"><a href="/how-it-works">{{ Lang::get('footer.how_it_works') }}</a></li>
                        <li class="only-on-mobile"><a href="/terms-and-conditions">{{ Lang::get('footer.terms_and_conditions') }}</a></li>
                        <li class="only-on-mobile"><a href="/faq">{{ Lang::get('footer.help') }}</a></li>
                        <li class="only-on-mobile">
                            <h4 class="col-xs-12 white">{{ Lang::get('footer.join_us') }}</h4>
                        </li>
                        <li class="only-on-mobile">
                            <a href="https://www.facebook.com/Loacal/"><img class="rounded inline-block" style="width: 100%;" src="/images/general/facebook-icn.png"></a>
                            <a href="https://www.instagram.com/theloacal/"><img class="rounded inline-block" style="width: 100%;" src="/images/general/instagram-icn.png"></a>
                            <a href="https://twitter.com/theloacal"><img class="rounded inline-block" style="width: 100%;" src="/images/general/twitter-icn.png"></a>
                        </li>
                        <li class="only-on-mobile">
                            <h4 class="col-xs-12 white">© 2017 - Loacal.com</h4>
                        </li>
                    </ul>
                </div>
    </div>
    </nav>

    <div class="page-content">
        @yield('content')
    </div>

    <div class="container-fluid" id="footer">
        <div class="row" id="footer-divider">

            <div class="container">
                <div id="footer-first" class="centered white">
                    <ul class="footer-links col-xs-12">
                        <li><a href="/about-us">{{ Lang::get('footer.about_us') }}</a><span class="footer-separate">|</span> </li>
                        <li><a href="/careers">{{ Lang::get('footer.careers') }}</a><span class="footer-separate">|</span></li>
                        <li><a href="#">{{ Lang::get('footer.blog') }}</a><span class="footer-separate">|</span></li>
                        <li><a href="/what-is-a-loacal">{{ Lang::get('footer.what_is_a_loacal') }}</a><span class="footer-separate">|</span></li>
                        <li><a href="/how-it-works">{{ Lang::get('footer.how_it_works') }}</a><span class="footer-separate">|</span></li>
                        <li><a href="/terms-and-conditions">{{ Lang::get('footer.terms_and_conditions') }}</a><span class="footer-separate">|</span></li>
                        <li><a href="/faq">{{ Lang::get('footer.help') }}</a></li>
                    </ul>

                    <h4 class="col-xs-12 white">{{ Lang::get('footer.join_us') }}</h4>
                    <div class="col-xs-12">
                        <ul class="col-sm-4 col-sm-offset-4 col-xs-8 col-xs-offset-2 list-unstyled">
                            <span class="col-xs-2 col-xs-offset-3 no-padding"><a href="https://www.facebook.com/Loacal/"><img class="rounded inline-block" style="width: 100%;" src="/images/general/facebook-icn.png"></a></span>
                            <span class="col-xs-2 no-padding"><a href="https://www.instagram.com/theloacal/"><img class="rounded inline-block" style="width: 100%;" src="/images/general/instagram-icn.png"></a></span>
                            <span class="col-xs-2 no-padding"><a href="https://twitter.com/theloacal"><img class="rounded inline-block" style="width: 100%;" src="/images/general/twitter-icn.png"></a></span>
                        </ul>
                    </div>
                    <h4 class="col-xs-12 white">© 2017 - Loacal.com</h4>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/loacal.js') }}"></script>
    <script>
        $(document).ready(function($) {
            var lastScrollTop = 0;
            $(window).scroll(function(event) {
                var st = $(this).scrollTop();
                if (st > lastScrollTop) {
                    if (window.scrollY > 0) {
                        $("#header").addClass("on-scroll-down")
                        $("#header").removeClass("on-scroll-up")
                    } else {
                        $("#header").removeClass("on-scroll-up")
                        $("#header").removeClass("on-scroll-down")
                    }
                } else {
                    if (window.scrollY > 0) {
                        $("#header").addClass("on-scroll-up")
                        $("#header").removeClass("on-scroll-down")
                    } else {
                        $("#header").removeClass("on-scroll-up")
                        $("#header").removeClass("on-scroll-down")
                    }
                }
                lastScrollTop = st;
            });
        });

    </script>
</body>

</html>
