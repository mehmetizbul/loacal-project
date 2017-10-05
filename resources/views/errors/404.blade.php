@extends('layouts.app')

@section('content')
    <style>
        .error-template {padding: 40px 15px;text-align: center;}
        .error-actions {margin-top:15px;margin-bottom:15px;}
        .error-actions .btn { margin-right:10px; }
    </style>


    <div class="container mt30">
        <div class="centered">
            <div class="col-md-12">
                <div class="error-template">
                    <div class="col-md-4">
                        <img style="width:100%;" src="{{ URL::to('/') }}/images/general/ice-cream-buddy.png">
                    </div>
                    <div class="col-md-8" style="margin-top: 10%;">
                        <h2>Oops! :(</h2>
                        <h2>Buddy, I'm busy with my ice cream</h2>
                        <div class="error-details loacal-blue">
                            I cannot find the requested page. Please choose from the options below
                        </div>
                        <div class="error-actions mt10">
                            <a href="/" class="btn btn-success btn-lg">
                                <span class="fa fa-search"></span>
                                Explore
                            </a>
                        </div>
                        <div class="error-actions mt10">
                            <a href="/" class="btn btn-primary btn-lg mt10">
                                <span class="glyphicon glyphicon-home"></span>
                                Take Me Home
                            </a>
                            <a href="/" class="btn btn-default btn-lg mt10">
                                <span class="glyphicon glyphicon-envelope"></span>
                                Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection