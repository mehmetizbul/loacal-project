@extends("layouts.app")

@section("content")

    <div class="row centered" style="background-color: #00A699 !important; opacity: 0.8;">
        <h1 class="white">{{ $title }}</h1>
        {{--<h1 class="white">What is a loacal?</h1>--}}
    </div>

    <div class="container-fluid mt20" style="background-color: white;">
        <div class="col-lg-2 col-md-4 col-sm-4 col-xs-12">
            <div class="nav-side-menu centered">
                    <a class="brand white col-md-12 btn btn-primary toggle-btn" data-toggle="collapse" data-target="#menu-content">
                        <span class="">Menu</span>
                        <i class="fa fa-bars fa-2x" ></i>
                    </a>
                <div class="menu-list">
                    <ul id="menu-content" class="menu-content out collapse pull-left help-pages-links">
                        <a type="button" id="faq-menu" class="col-md-12 col-xs-12 mt10" href="/faq"><span class="pull-left loacal-blue">FAQ</span></a>
                        <a type="button" id="how-it-works-menu" class="col-md-12 col-xs-12 mt10" href="/how-it-works"><span class="pull-left loacal-blue">How it Works?</span></a>
                        <a type="button" id="what-is-a-loacal-menu" class="col-md-12 col-xs-12 mt10" href="/what-is-a-loacal"><span class="pull-left loacal-blue">What is a Loacal?</span></a>
                        <a type="button" id="terms-and-conditions-menu" class="col-md-12 col-xs-12 mt10" href="/terms-and-conditions"><span class="pull-left loacal-blue">Terms & Conditions</span></a>
                        <a type="button" id="cancellation-menu" class="col-md-12 col-xs-12 mt10" href="/cancellation"><span class="pull-left loacal-blue">Cancellation & Refunds</span></a>
                        <a type="button" id="feedback-menu" class="col-md-12 col-xs-12 mt10" href="/feedback"><span class="pull-left loacal-blue">Give Feedback</span></a>
                        <a type="button" id="contact-us-menu" class="col-md-12 col-xs-12 mt10" href="/contact-us"><span class="pull-left loacal-blue">Contact Us</span></a>
                        <a type="button" id="about-us-menu" class="col-md-12 col-xs-12 mt10" href="/about-us"><span class="pull-left loacal-blue">About Us</span></a>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-10 col-md-8 col-sm-8 col-xs-12 no-padding">
        @yield("loacalContent")
        </div>
    </div>



@endsection



<style>
    body {
        background-color: #FFFFFF !important;
    }
</style>

