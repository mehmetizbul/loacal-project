<!--
-/**
- * Created by PhpStorm.
- * User: Bugra
- * Date: 22.04.2017
- * Time: 23:56
- */
--->

@extends('layouts.app') @section('content')

<div class="container-fluid home-page">
    <!-- Big Video Widget -->
    <div class="row">
        <div class="thumbnail text-center no-padding loacal-blue-bg">
            <img class="img-responsive img-center" src="images/general/homepage-video-image.jpg" alt="">
            <div class="homepage-header-container">
                <h1 class="h1-header">
<!--                   <strong>Loacal</strong>-->
                    <br><span><span class="hide-on-mobile">"</span>The home for activities in Mediterranean.</span><br>
                    <span class="hide-on-mobile">Experience the Loacal way."</span>
                </h1>
                <div class="whereToHomePage">
                    <form action="/experiences" role="search" class="input-group col-xs-12">
                        <input type="text" name="search" id="srch-term" class="form-control" placeholder="{{ Lang::get('home.where_to') }}">
                        <span class="input-group-btn">
                            <button class="search-button" type="submit">{{ Lang::get('home.search') }}!</button>
                        </span>
                    </form>
                    <a class="only-on-mobile" href="{{ route('experience.index') }}">
                        <span class="view-all-experiences">or click here to view all experiences</span>
                    </a>
                </div>
                <a href="/how-it-works" class="how-it-works">
                    <strong style="font-size: 18px;">How it works?</strong>
                </a>
            </div>
        </div>
    </div>
    <!-- Top Experiences Slider-->
    <div class="row-fluid home-page-element text-center">
        <span class="homepage-header">
            {{Lang::get('home.top_experiences')}}
            <span style="color: #008cd1">
                in
                <select id="location" name="location" class="custom-select">
                    @foreach($countries as $tmp )
                        <option value="{{ $tmp->id }}">{{ $tmp->name }}</option>
                    @endforeach
                </select>
            </span>

        </span>

        <div id="ajax">
            <ul class="bxslider" id="bxslider-topExperiences">
                @foreach ($aTopExperiences as $oTopExperience)
                <li class="laocal-slider-image-item">
                    <a href="/experience/{{ $oTopExperience->slug }}">
                        <div class="grid">
                            @if($oTopExperience->thumbnail() && \Illuminate\Support\Facades\File::exists(utf8_decode($oTopExperience->thumbnail()->getAttribute('image_file'))))
                            <figure class="text-center wp-caption"><img src="/{{utf8_decode($oTopExperience->thumbnail()->getAttribute('image_file'))}}" alt=""> @else
                                <figure class="wp-caption"> <img src="http://placehold.it/600x400&text=Experience_$i" alt=""> @endif
                                    <figcaption class="wp-caption-text-tl">{{ $oTopExperience->title }}</figcaption>
                                    {{-- showing location of the experience instead of the loacal name --}}
                                    <figcaption class="wp-caption-text-bl">
                                        @foreach($oTopExperience->countries() as $country=>$cities)
                                        <li>
                                            @foreach($cities as $city=>$areas) @if(count($cities)
                                            < 2 && count($oTopExperience->countries())
                                            < 2) {{ \App\Country::find($city)->name }}, @endif @endforeach {{ \App\Country::find($country)->name }}
                                        </li>
                                        @endforeach
                                    </figcaption>
                                    <figcaption class="wp-caption-text-br">from £{{ $oTopExperience->display_price() }}</figcaption>
                                </figure>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>


    <!-- Top Categories Slider -->
    <div id="top-categories" class="row-fluid home-page-element text-center">
        <span class="homepage-header">{{ Lang::get('home.top_categories') }}</span> {{-- todo Just for the event putting some static categories there, get rid of them later --}}
        <ul class="bxslider" id="bxslider-topCategories">
            <li>
                <a href="/experiences?filter[categories][0]=500"><img class="img-responsive center-block" src="http://demo.loacal.com/images/categories/expWithLoacal.png" alt="">
                <h4>Experience The City With a Local</h4> <a href="/experiences?filter[categories][0]=500" type="button" class="btn btn-default">{{ Lang::get('home.explore') }}</a> </li>
            <li> <a href="/experiences?filter[categories][0]=27"><img class="img-responsive center-block" src="http://demo.loacal.com/images/categories/photographyTour.png" alt="">
                <h4 id="expBt">Photography Tours</h4> <a href="/experiences?filter[categories][0]=27" type="button" class="btn btn-default">{{ Lang::get('home.explore') }}</a> </li>
            <li> <a href="/experiences?filter[categories][0]=25"><img class="img-responsive center-block" src="http://demo.loacal.com/images/categories/gastronomy.png" alt="">
                <h4>Local Gastronomy Workshops</h4> <a href="/experiences?filter[categories][0]=25" type="button" class="btn btn-default">{{ Lang::get('home.explore') }}</a> </li>
            <li> <a href="/experiences?filter[categories][0]=481"><img class="img-responsive center-block" src="http://demo.loacal.com/images/categories/multidayCulture.png" alt="">
                <h4>Multi-Day Cultural Tour</h4> <a href="/experiences?filter[categories][0]=481" type="button" class="btn btn-default">{{ Lang::get('home.explore') }}</a> </li>
        </ul>
    </div>


    <!-- Explore with a Loacal Slider-->
    <div class="row-fluid home-page-element text-center">
        <span class="homepage-header">Experience the city with a local

         <span style="color: #008cd1">
                in
                <select id="locationLocal" name="locationLocal" class="custom-select">
                    @foreach($countries as $tmp )
                    <option value="{{ $tmp->id }}">{{ $tmp->name }}</option>
                    @endforeach
                </select>
            </span>


        </span>
    <div id="ajaxLocal">
        <ul class="bxslider" id="bxslider-withalocal">
            @foreach ($loacalExperiences as $oTopExperience)
            <li class="laocal-slider-image-item">
                <a href="/experience/{{ $oTopExperience->slug }}">
                    <div class="grid">
                        @if($oTopExperience->thumbnail() && \Illuminate\Support\Facades\File::exists(utf8_decode($oTopExperience->thumbnail()->getAttribute('image_file'))))
                        <figure class="text-center wp-caption"><img src="/{{utf8_decode($oTopExperience->thumbnail()->getAttribute('image_file'))}}" alt=""> @else
                            <figure class="wp-caption"> <img src="http://placehold.it/600x400&text=Experience_$i" alt=""> @endif
                                <figcaption class="wp-caption-text-tl">{{ $oTopExperience->title }}</figcaption>
                                {{-- showing location of the experience instead of the loacal name --}}
                                <figcaption class="wp-caption-text-bl">
                                    @foreach($oTopExperience->countries() as $country=>$cities)
                                    <li>
                                        @foreach($cities as $city=>$areas) @if(count($cities)
                                        < 2 && count($oTopExperience->countries())
                                            < 2) {{ \App\Country::find($city)->name }}, @endif @endforeach {{ \App\Country::find($country)->name }}
                                    </li>
                                    @endforeach
                                </figcaption>
                                <figcaption class="wp-caption-text-br">from £{{ $oTopExperience->display_price() }}</figcaption>
                            </figure>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    </div>

</div>


<script>

    $(document).ready(function($) {
        $('body').on('change','#location',function(){
        var countryID = this.value;
        $.ajax({
            type: "GET",
            url: "{{ route("experience.dynamictopexperience") }}",
            data: {
            country:countryID
        },
        success: function(data){
            $('#ajax').html("");
            $('#ajax').append(data);
            $('#bxslider-topExperiences').bxSlider({
                minSlides: 1.5,
                maxSlides: 6,
                slideWidth: 400,
                slideMargin: 10,
                moveSlides: 1,
                adaptiveHeight: true,
                pager: false
            });
        }
    })
    });


    $('body').on('change','#locationLocal',function(){
        var countryID = this.value;
        $.ajax({
            type: "GET",
            url: "{{ route("experience.dynamicwithlocal") }}",
            data: {
            country:countryID
        },
        success: function(data){
            $('#ajaxLocal').html("");
            $('#ajaxLocal').append(data);
            $('#bxslider-withalocal').bxSlider({
                minSlides: 1.5,
                maxSlides: 6,
                slideWidth: 400,
                slideMargin: 10,
                moveSlides: 1,
                adaptiveHeight: true,
                pager: false
            });
        }
    })
    });


        $('#bxslider-topExperiences').bxSlider({
            minSlides: 1.5,
            maxSlides: 6,
            slideWidth: 400,
            slideMargin: 10,
            moveSlides: 1,
            adaptiveHeight: true,
            pager: false
        });

        if($(window).width() < 1200)
        {
            $('#bxslider-topCategories').bxSlider({
                infiniteLoop: false,
                maxSlides: 4,
                slideWidth: 150,
                slideMargin: 10,
                moveSlides: 1,
                pager: false
            });
        }
        else
        {
            $('#bxslider-topCategories').bxSlider({
                infiniteLoop: false,
                maxSlides: 4,
                slideWidth: 245,
                slideMargin: 10,
                moveSlides: 1,
                controls:false,
                pager: false
            });
        }
        $('#bxslider-withalocal').bxSlider({
            minSlides: 1.5,
            maxSlides: 6,
            slideWidth: 400,
            slideMargin: 10,
            moveSlides: 1,
            adaptiveHeight: true,
            pager: false
        });

    });
</script>
@endsection
