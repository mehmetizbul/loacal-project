@extends('layouts.app')
@section('content')
    <!-- Main Container -->
    <div class="container">
        <div class="">
            <h1>{{ $oUser->name }}</h1>
            <span class="rating">
                    <span class="star "></span>
                    <span class="star "></span>
                    <span class="star"></span>
                    <span class="star filled"></span>
                    <span class="star filled"></span>
            </span>
            <div class=''>
                <!-- Left Column -->
                <div class="col-md-4 col-xs-12">

                    <!-- TODO Get rid of the inline css rules below -->
                    @if($oUser->profile()->getAttribute('logo'))
                        <img class='img-responsive' src='/{{ $oUser->profile()->getAttribute('logo') }}' alt='Loacal Image' style='border-radius: 5%;'>
                    @endif
                    <!-- Certificate Images Section -->
                    <div class="">
                        <h2>Certificates</h2>
                        <div id="small-img" class="pull-left col-xs-12 col-sm-12 col-md-12 col-lg-12 center">
                            @foreach($oUser->certificates() as $oCert)
                                @if($oCert->icon())
                                    <img src="{{ $oCert->icon() }}" class="cert-image" alt="certificate image">
                                @else
                                    <strong class="cert-image">{{ $oCert->title }}</strong>&#9672;
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- Right Column -->
                <div class="col-md-8 col-xs-12">

                    <!-- TODO Need to get rid of inline css rules -->
                    <!-- TODO if no reviews available, do not show. -->
                    <!-- TODO get rid of the for loop and fill it with the actual data from the backoffice -->
                    <div class='col-md-12 col-sm-12 col-xs-12'>
                        <h2 class="mt0">Experiences of the Loacal</h2>
                        @if (!is_null($oUser->liveExperiences()))
                            @foreach($oUser->liveExperiences() as $oExp)
                                <div class="col-sm-12 mt10">
                                    <div style='width: 100%; margin-left: auto; margin-right: auto;'>
                                        <a href="/experience/{{ $oExp->slug }}">
                                            <figure class="wp-caption">@if(!is_null($oExp->thumbnail()))<img src="/{{ $oExp->thumbnail()->getAttribute('image_file') }}" alt="">@endif
                                                <figcaption class="wp-caption-text-tl" style="font-size: 14px; left: 0;">{{ $oExp->getAttribute('title') }}</figcaption>
                                                <figcaption class="wp-caption-text-br">from £ {{$oExp->display_price()}} </figcaption>
                                            </figure>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Calling the bx slider for the reviews -->
    <script>
        $(document).ready(function () {
            $('#bxslider-topExperiences').bxSlider({
                minSlides: 1
                , maxSlides: 1
                , slideWidth: 400
                , slideMargin: 10
                , moveSlides: 1
                , adaptiveHeight: true
            });
        });
    </script>

@endsection
