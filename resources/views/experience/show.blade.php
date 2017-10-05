<!--
/**
 * Created by PhpStorm.
 * User: Bugra
 * Date: 23.04.2017
 * Time: 18:39
 */

-->

@extends('layouts.app')

@section('content')

    <div class="mobile-pinned-info loacal-blue-dark-bg">

        <div class="col-lg-6 col-md-6 col-xs-6 bottom-rule mt10">
            <span id="before_price" style="color: #FFFFFF;">{{ Lang::get('experience.price_from') }}</span>
            <span id="price" style="color: #FFFFFF;"> €{{ $oExp->display_price() }}</span>
        </div>
        <div class="col-lg-6 col-md-6 col-xs-6 bottom-rule pull-right mt10">
            <button id="request_booking" type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#reqBookingPopup">{{ Lang::get('experience.request_booking') }}</button>
        </div>
    </div>
    <div class="container">


        <div class="col-lg-8 col-md-8 col-xs-12 no-padding">
            <h2>{{ $oExp->title }}</h2>
        </div>

        <div class="col-lg-4 col-md-4 col-xs-12 no-padding">
            @if (isset($auth) && $oExp->admin()->getAttribute('id') == $auth->id)
                <a href="/experience/{{ $oExp->id }}/make_editable" class="mt10 btn btn-primary pull-right" style="margin-right: 4.5%;">Edit this experience</a>
            @else
                @role(['super_admin','admin'])
                <a href="/experience/{{ $oExp->id }}/make_editable" class="mt10 btn btn-primary pull-right" style="margin-right: 4.5%;">Edit this experience</a>
                @endrole
            @endif
            <a href="#"><h2 id="add_to_wishlist" class="fa fa-heart-o pull-right"></h2></a>
        </div>


        <div class="col-lg-8 col-md-8 col-xs-12 no-padding">
            <div id="page" class="col-lg-12 col-md-12 col-xs-12 no-padding">

                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div>
                        <ul class="list-unstyled">
                            @foreach($oExp->countries() as $country=>$cities)
                                <li>
                                    {{ \App\Country::find($country)->name }}
                                    @foreach($cities as $city=>$areas)
                                        , {{ \App\Country::find($city)->name }}
                                        @foreach($areas as $area)
                                                , {{ \App\Country::find($area)->name }}
                                        @endforeach
                                    @endforeach
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class='col-lg-4 col-md-4 col-md-offset-2 col-sm-12 col-xs-12'>
                    <ul class="list-unstyled">
                        {{-- Todo include more details such as +price or included in price so on --}}


                        <li>@if($oExp->transporation != 0) Transportation {{ $oExp->transportation_text() }} @endif</li>
                        <li>@if($oExp->accomodation != 0) Accommodation {{ $oExp->accommodation_text() }} @endif</li>
                    </ul>
                </div>


                <div id="slickSliderGallery" class="col-lg-12 col-md-12 col-sm-12" style="width: 100%; max-height: 400px; overflow: hidden;">
                    <!-- In order to show the images in the same lightbox, we need to make sure the data-lightbox attributes are same  -->
                    @foreach($oExp->images() as $oImg)
                        <div>
                            <a href="/{{ $oImg->getAttribute('image_file') }}" data-lightbox="rhino-lightbox">
                                <img style="width: 100%;" src="/{{ $oImg->getAttribute('image_file') }}" alt="" />

                            </a>
                        </div>
                    @endforeach
                </div>
            </div>


            <p>
                <hr style="padding-left: 15px; padding-right: 15px; margin-top: 10px;" size="30">
            </p>
            <p style="padding-left: 15px; padding-right: 15px;">{!! \App\Functions::nl2br_special($oExp->description) !!}</p>


        </div>
        <div class="col-lg-4 col-md-4 col-xs-12 no-padding">
            <div>
                <div class="col-lg-6 col-md-6 col-xs-6 bottom-rule hide-on-pinned">
                    <span id="before_price">{{ Lang::get('experience.price_from') }}</span>
                    <span id="price"> €{{ $oExp->display_price() }}</span>
                </div>
                <div class="col-lg-6 col-md-6 col-xs-6 bottom-rule pull-right ">
                    <button id="request_booking" type="button" class="btn btn-primary pull-right hide-on-pinned" data-toggle="modal" data-target="#reqBookingPopup">{{ Lang::get('experience.request_booking') }}</button>
                    <!-- Request Booking Popup -->
                    <div id="reqBookingPopup" class="modal fade reqBookingPopup" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Request Booking</h4>
                                </div>
                                <form id="booking_request" action="{{ route('booking.create') }}" method="post">

                                    <div class="modal-body col-md-12 col-xs-12" style="height: auto;">
                                        {{-- Info section --}}
                                        <div class="col-md-12 col-xs-12 mt10">
                                            <h4 class="pull-right mt0" style="margin-right: 3%;">Current Price: <b id="current_price"></b></h4>
                                            <p class="pull-left">Please fill in the sections below to request a booking.

                                        </div>

                                        {{-- Number of people section --}}
                                        {{ csrf_field() }}
                                        <input type="hidden" name="booking[experience_id]" value="{{ $oExp->id }}"/>
                                        <?php
                                            $min = \App\ExperiencePrices::whereExperienceId($oExp->id)->whereType("adults")->min("min");
                                            $max = \App\ExperiencePrices::whereExperienceId($oExp->id)->whereType("adults")->max("max");
                                        ?>
                                        @if($min && $max)
                                            <div class="col-md-12 col-xs-12 mt10">
                                                <div class="col-md-4 col-xs-12">
                                                    <h5>Number of adults</h5>
                                                </div>
                                                <div class="col-md-8 col-xs-12">
                                                    <select required class="form-control" name="booking[adults]">
                                                        <option value="0">-</option>
                                                        @for($i=$min;$i<=$max;$i++)

                                                            <?php $pp = number_format(round(($oExp->calculate_price($i)["adults_price"]/$i) * 2, 0)/2, 2, '.', ''); ?>
                                                            <option value="{{ $i }}">{{ $i }} (€{{ $pp }} pp.)</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                        @elseif($min && !$max)
                                            <div class="col-md-12 col-xs-12 mt10">
                                                <div class="col-md-4 col-xs-12">
                                                    <h5>Number of adults</h5>
                                                </div>
                                                <div class="col-md-8 col-xs-12">
                                                    <input class="form-control" name="booking[adults]" type="number" min="{{ $min }}" step="1"/>
                                                </div>
                                            </div>
                                        @elseif(!$min && $max)
                                            <div class="col-md-12 col-xs-12 mt10">
                                                <div class="col-md-4 col-xs-12">
                                                    <h5>Number of adults</h5>
                                                </div>
                                                <div class="col-md-8 col-xs-12">
                                                    <input required class="form-control" name="booking[adults]" type="number" min=1 max="{{ $min }}" step="1"/>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Number of children section --}}
                                        <?php
                                            $min = \App\ExperiencePrices::whereExperienceId($oExp->id)->whereType("children")->min("min");
                                            $max = \App\ExperiencePrices::whereExperienceId($oExp->id)->whereType("children")->max("max");
                                        ?>

                                        @if($min && $max)
                                            <div class="col-md-12 col-xs-12 mt10">
                                                <div class="col-md-4 col-xs-12">
                                                    <h5>Number of children</h5>
                                                </div>
                                                <div class="col-md-8 col-xs-12">
                                                    <select required class="form-control" name="booking[children]">
                                                        <option value="0">-</option>
                                                        @for($i=$min;$i<=$max;$i++)
                                                            <?php $pp = number_format(round(($oExp->calculate_price(0,$i)["children_price"]/$i) * 2, 0)/2, 2, '.', ''); ?>
                                                            <option value="{{ $i }}">{{ $i }} (€{{ $pp }} pp.)</option>                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                        @elseif($min && !$max)
                                            <div class="col-md-12 col-xs-12 mt10">
                                                <div class="col-md-4 col-x-12">
                                                    <h5>Number of adults</h5>
                                                </div>
                                                <div class="col-md-8 col-xs-12">
                                                    <input required class="form-control" name="booking[children]" type="number" min="{{ $min }}" step="1"/>
                                                </div>
                                            </div>
                                        @elseif(!$min && $max)
                                            <div class="col-md-12 col-xs-12 mt10">
                                                <div class="col-md-4 col-x-12">
                                                    <h5>Number of adults</h5>
                                                </div>
                                                <div class="col-md-8 col-xs-12">
                                                    <input required class="form-control" name="booking[children]" type="number" min=1 max="{{ $min }}" step="1"/>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Extras section --}}
                                        @if(count($oExp->resources()))
                                            <div class="col-md-12 col-xs-12 mt10">
                                                <div class="col-md-4 col-xs-12">
                                                    <h5>Extras</h5>
                                                </div>
                                                <div class="col-md-8 col-xs-12 mt10">
                                                    <ul class="list-group">
                                                        @foreach($oExp->resources() as $oRes)
                                                            <li class="list-group-item">
                                                                <span>{{ $oRes->title }} (+€{{ $oRes->cost }})</span>
                                                                <div class="material-switch pull-right">
                                                                    <input class="extras-toggle" id="extra{{ $oRes->id }}" name="booking[extras][]" value="{{ $oRes->id }}" type="checkbox"/>
                                                                    <label for="extra{{ $oRes->id }}" class="label-primary"></label>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Datepicker section --}}
                                        <div class="col-md-12 col-xs-12" id="preferredDate">
                                            <div class="col-md-4 col-xs-12">
                                                <h5 class="pull-left">Preferred Date</h5>
                                            </div>

                                            <div class="col-md-8 col-xs-12">
                                                <div class="input-group date">
                                                    <input required type="text" name="booking[date_pref]" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- Comment section --}}
                                        {{-- TODO get rid of the inline styles below. --}}
                                        <div class="mt10 col-md-12 col-xs-12">
                                            <textarea style="resize: none; width: 94%; margin-left: auto; margin-right: auto; display: block; border: 1px solid lightgrey;" class="span6" rows="3" name="booking[message]" placeholder="Message to the Loacal"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-default pull-left">Send Booking Request</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 col-xs-12 mt10">
                <div class="panel panel-default clearfix">
                    <div class="col-xs-12 toggle-header">
                        <div class="col-xs-4">
                        </div>
                        <div class="col-xs-1 no-padding text-center">
                            <span class="hidden-xs">{{ Lang::get('experience.monday') }}</span>
                            <span class="visible-xs">{{ Lang::get('experience.monday') }}</span>
                        </div>
                        <div class="col-xs-1 no-padding text-center">
                            <span class="hidden-xs">{{ Lang::get('experience.tuesday') }}</span>
                            <span class="visible-xs">{{ Lang::get('experience.tuesday') }}</span>
                        </div>
                        <div class="col-xs-1 no-padding text-center">
                            <span class="hidden-xs">{{ Lang::get('experience.wednesday') }}</span>
                            <span class="visible-xs">{{ Lang::get('experience.wednesday') }}</span>
                        </div>
                        <div class="col-xs-1 no-padding text-center">
                            <span class="hidden-xs">{{ Lang::get('experience.thursday') }}</span>
                            <span class="visible-xs">{{ Lang::get('experience.thursday') }}</span>
                        </div>
                        <div class="col-xs-1 no-padding text-center">
                            <span class="hidden-xs">{{ Lang::get('experience.friday') }}</span>
                            <span class="visible-xs">{{ Lang::get('experience.friday') }}</span>
                        </div>
                        <div class="col-xs-1 no-padding text-center">
                            <span class="hidden-xs">{{ Lang::get('experience.saturday') }}</span>
                            <span class="visible-xs">{{ Lang::get('experience.saturday') }}</span>
                        </div>
                        <div class="col-xs-1 no-padding text-center">
                            <span class="hidden-xs">{{ Lang::get('experience.sunday') }}</span>
                            <span class="visible-xs">{{ Lang::get('experience.sunday') }}</span>
                        </div>
                    </div>

                    <div id="feature-1" class="collapse in">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-4">
                                    {{ Lang::get('experience.availability') }}
                                </div>
                                @for($i=1;$i<=7;$i++)
                                    @if(in_array($i,$oExp->availability()))
                                        <div class="col-xs-1 text-center no-padding">
                                            <i class="glyphicon glyphicon-ok txt-green"></i>
                                        </div>
                                    @else
                                        <div class="col-xs-1 text-center no-padding">
                                            <i class="glyphicon glyphicon-remove txt-red"></i>
                                        </div>
                                    @endif
                                @endfor
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xs-12 mt10">
                    <h4>Categories</h4>
                    @foreach($oExp->categories() as $oCat)
                        <div class='col-md-3 col-sm-3 col-xs-4 inline-block mt10 no-padding' style="height: 100px;">
                            <img style="width: 70%;" class='cat-image no-padding centered block' src='{{ $oCat->icon() }}' alt='cat_name' data-toggle="tooltip" title="{{ $oCat->name }}"/>
                            <figcaption class="loacal-blue centered">{{ $oCat->name }}</figcaption>
                        </div>
                    @endforeach
            </div>

            <div class="col-md-12 col-xs-12 mt20">
                <h4><a href="/profile/{{ $oExp->admin()->getAttribute('slug') }}">{{ Lang::get('experience.provided_by', ['loacal_name' => $oExp->admin()->getAttribute('name')]) }}</a></h4>
                @if($oExp->admin()->profile())
                    <img class="experience_admin_logo" src="/{{ $oExp->admin()->profile()->logo }}">
                @endif
                {{-- TODO show if any certificate exists --}}
            </div>
            <div class="col-md-12 col-sm-4 col-xs-6 mt10">
                <h4>{{ Lang::get('experience.certificates') }}:</h4>
                @foreach($oExp->admin()->certificates() as $oCert)
                    <img class='cert-image inline' src='{{ $oCert->icon() }}' alt='{{ $oCert->title }}' data-toggle='tooltip' title='{{ $oCert->title }}' />
                @endforeach
            </div>


            <div class='col-md-12 col-sm-4 col-xs-6 mt10'>
                <h4>{{ Lang::get('experience.languages') }}:</h4>
                <div class="f32">
                    @foreach($oExp->languages() as $oLang)
                        @if($oLang->abbreviation)
                            <span class="flag {{ $oLang->abbreviation }}"></span>
                        @else
                            <span class="flag">{{ $oLang->abbreviation }}</span>
                        @endif
                    @endforeach
                </div>
            </div>

            <div class='col-md-12 col-sm-4 col-xs-6 mt10'>
                <h4>{{ Lang::get('experience.preferences') }}:</h4>
                {{-- If its checked, output with icon-green class + mr3, if not output with icon-red + mr6 --}}
                <ul class="list-unstyled">
                    <li><span class="fa fa-check icon-green mr3"></span>Child-Friendly</li>
                    <li><span class="fa fa-times icon-red mr6"></span>Disabled-Friendly</li>
                </ul>
            </div>
        </div>
        <div class="col-md-8 col-xs-12 no-padding">
            <!-- TODO add other tours of the loacal, similar tours, one each, TODO BG , if no other tours of loacal, show similar tours from same cat, if not exist, show any 2 fuckingg tours :D <3 x2-->

            <div class="col-md-6">
                <h4>{{ Lang::get('experience.other_experiences_of_the_loacal') }}</h4>
                <div class="grid">
                    <figure class="wp-caption"> <img src="http://placehold.it/335x250&text=Experience" alt="">
                        <figcaption class="wp-caption-text-bl">Loacal Name</figcaption>
                        <figcaption class="wp-caption-text-br">from €15.90</figcaption>
                    </figure>
                </div>
            </div>
            <div class="col-md-6">
                <h4>{{ Lang::get('experience.similar_experiences') }}</h4>
                <div class="grid">
                    <figure class="wp-caption"> <img src="http://placehold.it/335x250&text=Experience" alt="">
                        <figcaption class="wp-caption-text-bl">Loacal Name</figcaption>
                        <figcaption class="wp-caption-text-br">from €15.90</figcaption>
                    </figure>
                </div>
            </div>
        </div>
    </div>


    <script>
        jQuery(document).ready(function ($) {

            $("form#booking_request").change(function() {
                var data = $(this).serialize();

                $.ajax({
                    type: "POST",
                    url: "{{ route("booking.calculate") }}",
                    data: data,
                    success: function(result){
                        result = $.parseJSON(result);
                        if(result.price){
                            $("#current_price").html(result.price);
                        }
                    },
                    error: function(){
                        console.log("wut?!");
                    }
                });
            });
            $('#slickSliderGallery').slick({
                arrows: false,
                fade: false,
                dots: false
            });

            $("input").keyup(function(){
                $(this).trigger("change");
            });

            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth()+1; //January is 0!
            var yyyy = today.getFullYear();
            var yyyy2 = today.getFullYear();
            yyyy2 = yyyy2 + 1;

            if(dd<10) {
                dd='0'+dd
            }
            if(mm<10) {
                mm='0'+mm
            }

            today = dd+'/'+mm+'/'+yyyy;
            var endYear = dd+'/'+mm+'/'+yyyy2;
            $('#preferredDate .input-group.date').datepicker({
                autoclose: true,
                format: 'dd/mm/yyyy',
                multidate: true,
                autoclose: false,
                daysOfWeekDisabled: [{{ implode(",",array_diff([1,2,3,4,5,6,7],$oExp->availability())) }}],
                weekStart: 1,
                startDate: today,
                endDate: endYear
            });

            $('[data-toggle="tooltip"]').tooltip();
        });

    </script>

@endsection