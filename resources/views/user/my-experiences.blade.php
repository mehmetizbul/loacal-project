{{-- Created by PhpStorm.--}}
{{-- User: MustafaBuda--}}
{{-- Date: 13/05/2017--}}
{{-- Time: 15:23--}}

@extends('user.accountcommon')

@section('accountheader')

    <div class="container">
        @if(count($auth->liveExperiences()))
            <h2>Live Experiences</h2>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <!-- Live Experiences Slider -->
                <div class="row-fluid text-center">
                    <ul class="bxslider" id="bxslider-liveExperiences">
                        @foreach($auth->liveExperiences() as $oExp)
                            <li>
                                @if($oExp->thumbnail())
                                    <img class="img-responsive center-block live-experiences" src="/{{ $oExp->thumbnail()->getAttribute('image_file') }}" alt="">
                                @else
                                    <img class="img-responsive center-block wfa-experiences" src="http://placehold.it/600x400" alt="">
                                @endif
                                    <figcaption class="wp-caption-text-tl">{{ $oExp->title }}</figcaption >
                                    <a href="/experience/{{ $oExp->slug }}" type="button" class="btn btn-default">View</a>
                                <a href="/experience/{{ $oExp->id }}/make_editable" type="button" class="btn btn-primary">Edit</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <hr>
        @endif

        @if(count($auth->pendingExperiences()))
            <h2>Waiting For Approval</h2>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <!-- Waiting For Approval Slider -->
                <div class="row-fluid text-center">
                    <ul class="bxslider" id="bxslider-waitingForApproval">
                        @foreach($auth->pendingExperiences() as $oExp)
                            <li>
                                @if($oExp->thumbnail())
                                    <img class="img-responsive center-block live-experiences" src="/{{ $oExp->thumbnail()->getAttribute('image_file') }}" alt="">
                                @else
                                    <img class="img-responsive center-block wfa-experiences" src="http://placehold.it/600x400" alt="">
                                @endif
                                <figcaption class="wp-caption-text-tl">{{ $oExp->title }}</figcaption>
                                <a href="/experience/{{ $oExp->id }}/view" type="button" class="btn btn-primary">View</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <hr>
        @endif

        @if(count($auth->draftExperiences()))
            <h2>Draft Experiences</h2>
            <div class="col-lg-12 col-md-12 col-sm-12">
                <!-- Drafts Slider -->
                <div class="row-fluid text-center">
                    <ul class="bxslider" id="bxslider-draftExperiences">
                        @foreach($auth->draftExperiences() as $oExp)
                            <li>
                                @if($oExp->thumbnail())
                                    <img class="img-responsive center-block live-experiences" src="/{{ $oExp->thumbnail()->getAttribute('image_file') }}" alt="">
                                @else
                                    <img class="img-responsive center-block wfa-experiences" src="http://placehold.it/600x400" alt="">
                                @endif
                                <figcaption class="wp-caption-text-tl">{{ $oExp->title }}</figcaption>
                                <a href="/experience/{{ $oExp->id }}/edit" type="button" class="btn btn-primary">Edit</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

    </div>



    <script>
        $(document).ready(function ($) {
            $('#bxslider-liveExperiences').bxSlider({
                minSlides: 2
                , maxSlides: 6
                , slideWidth: 360
                , slideMargin: 10
                , moveSlides: 1
            });
            $('#bxslider-waitingForApproval').bxSlider({
                minSlides: 2
                , maxSlides: 6
                , slideWidth: 360
                , slideMargin: 10
                , moveSlides: 1
            });
            $('#bxslider-draftExperiences').bxSlider({
                minSlides: 2
                , maxSlides: 6
                , slideWidth: 360
                , slideMargin: 10
                , moveSlides: 1
            });
        });
    </script>

@endsection