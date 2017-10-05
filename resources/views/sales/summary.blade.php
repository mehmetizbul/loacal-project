@extends('layouts.app')

@section('content')


    <div class="container-fluid text-center">
        <h2>We have received your booking request.</h2>
    </div>

    <div class="container">
        <div style="margin-bottom: 3%;">
            <h2 class="inline">Experience Name</h2>
            <span class="fa fa-star inline loacal-blue"></span>
            <span class="fa fa-star inline loacal-blue"></span>
            <span class="fa fa-star inline loacal-blue"></span>
        </div>
        <div class="col-md-8">
            <div class="col-md-6 mt10">
                <span class="fa fa-calendar inline fa-2x loacal-blue"><h4 class="inline loacal-blue"> 12 Jan 2015 - Morning</h4></span>
            </div>
            <div class="col-md-6 mt10">
                <span class="fa fa-user inline fa-2x loacal-blue"><h4 class="inline loacal-blue"> 13 Adult & 0 Child</h4></span>
            </div>
            <div class="col-md-6 mt20">
                <span class="fa fa-money inline fa-2x loacal-blue"><h4 class="inline loacal-blue"> €13.90</h4></span>
            </div>
            {{-- Show only if its included --}}
            <div class="col-md-6 mt20">
                <span class="fa fa-check inline fa-2x loacal-blue"><h4 class="inline loacal-blue"> Including; </h4></span>
                <ul style="list-style: none;">
                    <li><span class="fa fa-cab inline fa-1x loacal-blue"><h5 class="inline loacal-blue"> Transportation </h5></span></li>
                    <li><span class="fa fa-home inline fa-1x loacal-blue"><h5 class="inline loacal-blue"> Accommodation </h5></span></li>
                </ul>
            </div>
        </div>
        <div class="col-md-4" style="border-style: solid; border-color: #008cd1;">
            <h4>Cancellation Policy</h4>
            <p>Lorem ipsum mustafa is the guy, bg is the the guy</p>
            <h4>Your Note</h4>
            <p>I want to book holiday, yay</p>
        </div>
    </div>

@endsection




