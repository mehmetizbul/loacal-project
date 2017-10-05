<div id="loacal-filters" class="col-md-12 no-padding">
    <div class="col-md-6 no-padding left-area">
        <div class="col-md-4">
            <span>Between Dates</span>
            <input type="text" name="filter[date_from]" class="input-1-2 datepicker" placeholder="Date Start">
            <input type="text" name="filter[date_to]" class="input-1-2 datepicker" placeholder="Date End">
        </div>
        <div class="col-md-2">
            <span># of People</span>
            <input name="filter[no_of_people]" type="number" min="1" step=1 value="{{ Lang::get('experience.number_of_people') }}">
        </div>
        <div class="col-md-6">
            <span>Price</span>
            <input id="priceSlider" name="filter[price_range]" type="text" value="" data-slider-min="15" data-slider-max="1799" data-slider-step="50" data-slider-value="[250,450]" />
        </div>
        <div class="col-md-12">
            <span class="activities-head">Activities</span>
            <ul id="bxslider-filter">
                @foreach(\App\Category::whereParent(0)->get() as $oCat)
                <li>
                    <input type="checkbox" id="{{ $oCat->name }}">
                    <label for="{{ $oCat->name }}"><img src="{{ $oCat->icon() }}"><span>{{ $oCat->name }}</span></label>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-4 col-md-offset-4">
            <button id="showextrasbutton" class="loacal-filter-button" onclick="$('.loacal-extra-filters').show(); $(this).hide()"><span>+ More Filters</span></button>
        </div>
        <div class="clearfix"></div>
        <div class="loacal-extra-filters" style="display:none;">
            <div class="col-md-4">
                <span>{{ Lang::get('experience.lang_of_the_exp') }}</span>
                <select name="filter[languages]" id="loacal-language" multiple class="form-control">
                    @foreach($filter["languages"] as $oLang)
                    <option value="{{ $oLang->id }}">{{ $oLang->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <span>{{ Lang::get('experience.transport') }}</span>
                <input type="radio" name="loacal-transport" id="loacal-transport-option-1">
                <label for="loacal-transport-option-1" onclick="$('#loacal-transport-option-1').is(':checked') ? $('#loacal-transport-option-1').checked = false : ''">Included</label>
                <input type="radio" name="loacal-transport" id="loacal-transport-option-2">
                <label for="loacal-transport-option-2" onclick="$('#loacal-transport-option-2').is(':checked') ? $('#loacal-transport-option-2').checked = false : ''">Extra fee</label>
                <input type="radio" name="loacal-transport" id="loacal-transport-option-3">
                <label for="loacal-transport-option-3" onclick="$('#loacal-transport-option-3').is(':checked') ? $('#loacal-transport-option-3').checked = false : ''">Available upon request (free)</label>
            </div>
            <div class="col-md-4">
                <span>Other Filters</span>
                <input type="checkbox" name="child_friendly" value="" id="loacal-extra-filters-1">
                <label for="loacal-extra-filters-1">Travelling with kids?</label>
                <input type="checkbox" name="disabled_friendly" value="" id="loacal-extra-filters-2">
                <label for="loacal-extra-filters-2">Travelling with a disabled person?</label>
                <input type="checkbox" name="free_experience" value="" id="loacal-extra-filters-3">
                <label for="loacal-extra-filters-3">Are you looking for a free activity?</label>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-4 col-md-offset-4">
                <button class="loacal-filter-button" onclick="$('.loacal-extra-filters').hide(); $('#showextrasbutton').show()"><span>- Less Filters</span></button>
            </div>
        </div>
    </div>
    <div class="col-md-6 no-padding right-area">
        <span>Choose Your Destination</span>
        <div class="col-md-4 no-padding">
            <button class="location-main-buttons" location-name="Turkey" onclick="mainLocationButtonAction(this)">Turkey (192)</button>
            <div class="sub-locations" style="display:none">
                <button location-name="Istanbul">Istanbul(83)</button>
                <button location-name="Antalya">Antalya(83)</button>
                <button location-name="Fethiye">Fethiye & Oludeniz(83)</button>
                <button location-name="Mugla">Mugla(83)</button>
                <button location-name="Taurus">Taurus Mountains(83)</button>
                <button location-name="Burdur">Burdur(83)</button>
                <button location-name="Isparta">Isparta(83)</button>
                <button location-name="Marmaris">Marmaris(83)</button>
                <button location-name="Lycian">Lycian Way (Likya Yolu)(83)</button>
                <button location-name="Izmir">Izmir(83)</button>
                <button location-name="Ankara">Ankara(83)</button>
                <button location-name="Pamukkale">Pamukkale(83)</button>
                <button location-name="Nevsehir">Nevşehir(83)</button>
                <button location-name="Cappadocia">Cappadocia(83)</button>
                <button location-name="Konya">Konya(83)</button>
                <button location-name="Canakkale">Canakkale(83)</button>
                <button location-name="Bursa">Bursa(83)</button>
                <button location-name="Ephesus">Ephesus(83)</button>
                <button location-name="Pergama">Pergama(83)</button>
            </div>
            <button class="location-main-buttons" location-name="Greece" onclick="mainLocationButtonAction(this)">Greece (192)</button>
            <div class="sub-locations" style="display:none">
                <button location-name="Rhodes">Rhodes Island(2)</button>
                <button location-name="Symi">Symi Island(1)</button>
            </div>
            <button class="location-main-buttons" location-name="Cyprus" onclick="mainLocationButtonAction(this)">Cyprus (192)</button>
            <div class="sub-locations" style="display:none">
                <button location-name="Nicosia">Nicosia(1)</button>
                <button location-name="Kyrenia">Kyrenia(1)</button>
                <button location-name="Famagusta">Famagusta(1)</button>
                <button location-name="Morphou">Morphou(1)</button>
                <button location-name="Karpaz">Karpaz(1)</button>
                <button location-name="Larnaca">Larnaca(1)</button>
                <button location-name="Paphos">Paphos(1)</button>
                <button location-name="Ayia">Ayia Napa(1)</button>
                <button location-name="Limassol">Limassol</button>
            </div>
        </div>
        <div id="mapholderparent" class=" col-md-8">
            <div id="mapholder"></div>
        </div>
    </div>


</div>

<script>
    var map;
    var mapoverlays = [];
    jQuery(document).ready(function($) {
        $('#loacal-language').SumoSelect();
        $('#bxslider-filter').bxSlider({
            minSlides: 1.5,
            maxSlides: 10,
            slideWidth: 150,
            slideMargin: 10,
            moveSlides: 1,
            pager: false,
            adaptiveHeight: true
        });
        $("#priceSlider").slider();
        $(".datepicker").datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            weekStart: 1,
            startDate: new Date()
        });
        map = new GMaps({
            div: '#mapholder',
            lat: 37.9547371,
            lng: 33.3229544,
            zoom: 5,
            draggable: false,
            scrollwheel: false,
            navigationControl: false,
            mapTypeControl: false,
            scaleControl: false,
            disableDoubleClickZoom: true,
            disableDefaultUI: true,
            styles: [{
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [{
                    "color": "#f2f2f2"
                }]
            }, {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "road",
                "elementType": "all",
                "stylers": [{
                    "saturation": -100
                }, {
                    "lightness": 45
                }]
            }, {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [{
                    "visibility": "simplified"
                }]
            }, {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [{
                    "visibility": "simplified"
                }]
            }, {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "water",
                "elementType": "all",
                "stylers": [{
                    "color": "#46bcec"
                }, {
                    "visibility": "on"
                }]
            }]
        });
        $(".sub-locations button").on("click", function() {
            var locationName = $(this).attr("location-name");
            map.setZoom(locationList[locationName].zoom);
            map.setCenter(locationList[locationName].coordinates.lat, locationList[locationName].coordinates.ln);
            if ($(this).hasClass("active")) {
                $(this).toggleClass("active")
                mapoverlays.forEach(function(item, index) {
                    if (item.lat == locationList[locationName].coordinates.lat && item.lng == locationList[locationName].coordinates.ln) {
                        mapoverlays.splice(index, 1);
                    }
                })
                map.removeOverlays();
                mapoverlays.forEach(function(item) {
                    map.drawOverlay(item)
                })
            } else {
                $(this).toggleClass("active")
                mapoverlays.push({
                    lat: locationList[locationName].coordinates.lat,
                    lng: locationList[locationName].coordinates.ln,
                    content: '<div class="overlay">' + locationName + '</div>'
                });
                map.removeOverlays();
                mapoverlays.forEach(function(item) {
                    map.drawOverlay(item)
                })
            }
        });

    });



    function mainLocationButtonAction(element) {
        $('.sub-locations').hide();
        $(element).next().toggle();
        var locationName = $(element).attr("location-name");
        map.setZoom(locationList[locationName].zoom);
        map.setCenter(locationList[locationName].coordinates.lat, locationList[locationName].coordinates.ln);
        if ($(element).hasClass("active")) {
            $(".active").removeClass("active")
            mapoverlays = [];
            map.removeOverlays();
        } else {
            $(".active").removeClass("active")
            $(element).addClass("active")
            mapoverlays.push({
                lat: locationList[locationName].coordinates.lat,
                lng: locationList[locationName].coordinates.ln,
                content: '<div class="overlay">' + locationName + '</div>'
            });
            map.removeOverlays();
            mapoverlays.forEach(function(item) {
                map.drawOverlay(item)
            })
        }
    }

</script>



<!--
<div id="loacal-filters" class="row">
    <div class="col-md-12 loacal-main-filters">
        <div id="loacal-filter-area" class="col-md-6">
            <div class="loacal-range-date loacal-filter-item col-md-4">
                <span>Between Dates</span>
                <input type="text" name="filter[date_from]" placeholder="date start">
                <input type="text" name="filter[date_to]" placeholder="date end">
            </div>
            <div class="col-md-6 no-padding">
                <div class="loacal-number-of-people loacal-filter-item col-md-3 no-padding">
                    <span># of People</span>
                    <input name="filter[no_of_people]" type="number" min="1" step=1 value="{{ Lang::get('experience.number_of_people') }}">
                </div>
                <div class="laocal-price-slider loacal-filter-item col-md-9">
                    <span>Price</span>
                    <input id="priceSlider" name="filter[price_range]" type="text" value="" data-slider-min="15" data-slider-max="1799" data-slider-step="50" data-slider-value="[250,450]" />
                </div>
            </div>
            <div class="loacal-activities loacal-filter-item col-md-10">
                <span>Activities</span>
                <ul id="bxslider-filter">
                    <li>
                        <input type="checkbox" id="id1">
                        <label for="id1"><img class="inline centered" src="../images/categories/self-guide_tour_icon-04.png"><span>Self-Guided Tour</span></label>
                    </li>
                    <li>
                        <input type="checkbox" id="id2">
                        <label for="id2"><img class="inline centered" src="../images/categories/multi-day_tour_icon-03.png"><span>Multi-Day</span></label>
                    </li>
                    <li>
                        <input type="checkbox" id="id3">
                        <label for="id3"><img class="inline centered" src="../images/categories/Bus-Tour.png"><span>Interpreter & Transport</span></label>
                    </li>
                    <li>
                        <input type="checkbox" id="id4">
                        <label for="id4"><img class="inline centered" src="../images/categories/Yoga-Pilates-and-Nature.png"><span>Well being</span></label>
                    </li>
                    <li>
                        <input type="checkbox" id="id5">
                        <label for="id5"><img class="inline centered" src="../images/categories/Sportive.png"><span>Sport & Extreme</span></label>
                    </li>
                    <li>
                        <input type="checkbox" id="id6">
                        <label for="id6"><img class="inline centered" src="../images/categories/Show-concert.png"><span>Events & Festivals</span></label>
                    </li>
                    <li>
                        <input type="checkbox" id="id7">
                        <label for="id7"><img class="inline centered" src="../images/categories/Creative-Workshop.png"><span>Workshops</span></label>
                    </li>
                    <li>
                        <input type="checkbox" id="id8">
                        <label for="id8"><img class="inline centered" src="../images/categories/Heritage-and-Architecture.png"><span>Heritage & Architecture</span></label>
                    </li>
                    <li>
                        <input type="checkbox" id="id9">
                        <label for="id9"><img class="inline centered" src="../images/categories/Photographer.png"><span>Photography</span></label>
                    </li>
                    <li>
                        <input type="checkbox" id="id10">
                        <label for="id10"><img class="inline centered" src="../images/categories/City-Tour.png"><span>Sightseeing</span></label>
                    </li>
                    <li>
                        <input type="checkbox" id="id11">
                        <label for="id11"><img class="inline centered" src="../images/categories/Foody.png"><span>Gastronomy</span></label>
                    </li>
                    <li>
                        <input type="checkbox" id="id12">
                        <label for="id12"><img class="inline centered" src="../images/categories/Cultural-Tour.png"><span>Art, Painting & Design</span></label>
                    </li>
                    <li>
                        <input type="checkbox" id="id13">
                        <label for="id13"><img class="inline centered" src="../images/categories/Naturist.png"><span>Nature</span></label>
                    </li>
                    <li>
                        <input type="checkbox" id="id14">
                        <label for="id14"><img class="inline centered" src="../images/categories/show_around_icon2_.png"><span>With a local</span></label>
                    </li>
                    @foreach(\App\Category::whereParent(0)->get() as $oCat)

                    <li>
                        <input type="checkbox" id="{{ $oCat->name }}">
                        <label for="{{ $oCat->name }}"><img class="inline centered" src="{{ $oCat->icon() }}"><br><span>{{ $oCat->name }}</span></label>
                    </li>
                    @endforeach
                </ul>

            </div>
            <div id="loacal-show-extra-filters-holder" class="loacal-more-filters col-md-12 no-padding">
                <button class="loacal-filter-button" onclick="handleExtraFilters()"><span>+ More Filters</span></button>
            </div>
            <div id="loacal-extra-filters" class="col-md-12 no-padding" style="display:none">
                <div class="col-md-4 loacal-filter-item">
                    <span>{{ Lang::get('experience.lang_of_the_exp') }}</span>
                    <select name="filter[languages]" id="loacal-language" multiple class="form-control">
                                @foreach($filter["languages"] as $oLang)
                                    <option value="{{ $oLang->id }}">{{ $oLang->name }}</option>
                                @endforeach
                            </select>
                </div>
                <div class="col-md-6 loacal-filter-item no-padding">
                    <span>{{ Lang::get('experience.transport') }}</span>
                    <input type="radio" name="loacal-transport" id="loacal-transport-option-1"><label for="loacal-transport-option-1" class="col-md-3" onclick="$('#loacal-transport-option-1').is(':checked') ? $('#loacal-transport-option-1').checked = false : ''">Included</label>
                    <input type="radio" name="loacal-transport" id="loacal-transport-option-2"><label for="loacal-transport-option-2" class="col-md-3" onclick="$('#loacal-transport-option-2').is(':checked') ? $('#loacal-transport-option-2').checked = false : ''">Extra fee</label>
                    <input type="radio" name="loacal-transport" id="loacal-transport-option-3"><label for="loacal-transport-option-3" class="col-md-6" onclick="$('#loacal-transport-option-3').is(':checked') ? $('#loacal-transport-option-3').checked = false : ''">Available upon request (free)</label>
                </div>
                <div class="clearfix"></div>
                <div id="extra-filters-line-2" class="col-md-12 no-padding">
                    <div class="col-md-4 loacal-filter-item">
                        <span>{{ Lang::get('experience.accommodation') }}</span>
                        <input type="radio" name="loacal-accommodation" id="loacal-accommodation-option-1"><label for="loacal-accommodation-option-1" onclick="$('#loacal-accommodation-option-1').is(':checked') ? $('#loacal-accommodation-option-1').checked = false : ''">Option-1</label>
                        <input type="radio" name="loacal-accommodation" id="loacal-accommodation-option-2"><label for="loacal-accommodation-option-2" onclick="$('#loacal-accommodation-option-2').is(':checked') ? $('#loacal-accommodation-option-2').checked = false : ''">Option-2</label>
                        <input type="radio" name="loacal-accommodation" id="loacal-accommodation-option-3"><label for="loacal-accommodation-option-3" onclick="$('#loacal-accommodation-option-3').is(':checked') ? $('#loacal-accommodation-option-3').checked = false : ''">Option-3</label>
                    </div>
                    <div class="col-md-6 no-padding">
                        <div class="col-md-12 loacal-filter-item no-padding">
                            <input type="checkbox" name="child_friendly" value="" id="travelling-with-kids">
                            <label for="travelling-with-kids">Travelling with kids?</label>
                        </div>
                        <div class="col-md-12 loacal-filter-item no-padding">
                            <input type="checkbox" name="disabled_friendly" value="" id="travelling-with-disabled">
                            <label for="travelling-with-disabled">Travelling with a disabled person?</label>
                        </div>
                        <div class="col-md-12 loacal-filter-item no-padding">
                            <input type="checkbox" name="free_experience" value="" id="free-activity">
                            <label for="free-activity">Are you looking for a free activity?</label>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                    <div id="loacal-hide-extra-filters-holder" class="loacal-more-filters col-md-12">
                        <button class="loacal-filter-button" onclick="handleExtraFilters()"><span>- Less Filters</span></button>
                    </div>
                </div>
            </div>
        </div>
        <div id="loacal-map-area" class="col-lg-6">
            <span class="loacal-map-header">Choose your destination</span>
            <div class="loacal-map-flex">
                <div class="loacal-map-left">
                    <div class="loacal-map-select">
                        <button class="loacal-map-item" location-name="Turkey">Turkey (192)</button>
                        <div class="loacal-map-sub-item">
                            <button location-name="Istanbul">Istanbul(83)</button>
                            <button location-name="Antalya">Antalya(83)</button>
                            <button location-name="Fethiye">Fethiye & Oludeniz(83)</button>
                            <button location-name="Mugla">Mugla(83)</button>
                            <button location-name="Taurus">Taurus Mountains(83)</button>
                            <button location-name="Burdur">Burdur(83)</button>
                            <button location-name="Isparta">Isparta(83)</button>
                            <button location-name="Marmaris">Marmaris(83)</button>
                            <button location-name="Lycian">Lycian Way (Likya Yolu)(83)</button>
                            <button location-name="Izmir">Izmir(83)</button>
                            <button location-name="Ankara">Ankara(83)</button>
                            <button location-name="Pamukkale">Pamukkale(83)</button>
                            <button location-name="Nevsehir">Nevşehir(83)</button>
                            <button location-name="Cappadocia">Cappadocia(83)</button>
                            <button location-name="Konya">Konya(83)</button>
                            <button location-name="Canakkale">Canakkale(83)</button>
                            <button location-name="Bursa">Bursa(83)</button>
                            <button location-name="Ephesus">Ephesus(83)</button>
                            <button location-name="Pergama">Pergama(83)</button>
                        </div>
                    </div>
                    <div class="loacal-map-select">
                        <button class="loacal-map-item" location-name="Greece">Greece (3)</button>
                        <div class="loacal-map-sub-item">
                            <button location-name="Rhodes">Rhodes Island(2)</button>
                            <button location-name="Symi">Symi Island(1)</button>
                        </div>
                    </div>
                    <div class="loacal-map-select">
                        <button class="loacal-map-item" location-name="Cyprus">Cyprus (172)</button>
                        <div class="loacal-map-sub-item">
                            <button location-name="Nicosia">Nicosia(1)</button>
                            <button location-name="Kyrenia">Kyrenia(1)</button>
                            <button location-name="Famagusta">Famagusta(1)</button>
                            <button location-name="Morphou">Morphou(1)</button>
                            <button location-name="Karpaz">Karpaz(1)</button>
                            <button location-name="Larnaca">Larnaca(1)</button>
                            <button location-name="Paphos">Paphos(1)</button>
                            <button location-name="Ayia">Ayia Napa(1)</button>
                            <button location-name="Limassol">Limassol</button>
                        </div>
                    </div>
                </div>
                <div class="loacal-map-right">
                    <div class="laocal-map-holder">
                        <div id="maphold"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
-->

<!--
<input id="pac-input" class="controls" type="text" placeholder="Search Box" value="Miami, Florida">
<div id="map-canvas"></div>
<button id="trigger-search">Trigger search</button>

<style>
    html,
    body,
    #map-canvas {
        height: 400px;
        margin: 0px;
        padding: 0px
    }

    .controls {
        margin-top: 16px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    #pac-input {
        background-color: #fff;
        padding: 0 11px 0 13px;
        width: 400px;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        text-overflow: ellipsis;
    }

    #pac-input:focus {
        border-color: #4d90fe;
        margin-left: -1px;
        padding-left: 14px;
        /* Regular padding-left + 1. */
        width: 401px;
    }

    .pac-container {
        font-family: Roboto;
    }

    #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
    }

    #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }

    #trigger-search {
        border: 1px solid black;
        margin: 10px;
        background: yellow;
    }
</style>
-->

<!--
<script type="text/javascript">
    jQuery(document).ready(function($) {

        $('#loacal-language').SumoSelect();

        var map = new GMaps({
            div: '#maphold',
            lat: 38.9547371,
            lng: 37.3229544,
            zoom: 5,
            draggable: false,
            scrollwheel: false,
            navigationControl: false,
            mapTypeControl: false,
            scaleControl: false,
            disableDoubleClickZoom: true,
            disableDefaultUI: true,
            styles: [{
                "featureType": "landscape",
                "elementType": "all",
                "stylers": [{
                    "color": "#fff"
                }]
            }, {
                "featureType": "poi",
                "elementType": "all",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "road",
                "elementType": "all",
                "stylers": [{
                    "saturation": -100
                }, {
                    "lightness": 45
                }]
            }, {
                "featureType": "road.highway",
                "elementType": "all",
                "stylers": [{
                    "visibility": "simplified"
                }]
            }, {
                "featureType": "road.arterial",
                "elementType": "labels.icon",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "transit",
                "elementType": "all",
                "stylers": [{
                    "visibility": "off"
                }]
            }, {
                "featureType": "water",
                "elementType": "all",
                "stylers": [{
                    "color": "#46bcec"
                }, {
                    "visibility": "on"
                }]
            }, {
                featureType: "all",
                elementType: "labels",
                stylers: [{
                    visibility: "off"
                }]
            }]
        });

        $('#bxslider-filter').bxSlider({
            minSlides: 6,
            maxSlides: 6,
            slideWidth: 360,
            slideMargin: 10
        });

        $(document).off("click", ".togglefilter").on("click", ".togglefilter", function() {
            if ($(this).hasClass("hidefilter")) {
                $(".filter").hide();
                $(this).removeClass("hidefilter").addClass("showfilter");
            } else if ($(this).hasClass("showfilter")) {
                $(".filter").show();
                $(this).removeClass("showfilter").addClass("hidefilter");
            }
        });

        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        var yyyy2 = today.getFullYear();
        yyyy2 = yyyy2 + 1;
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        today = dd + '/' + mm + '/' + yyyy;
        var endYear = dd + '/' + mm + '/' + yyyy2;

        $('.loacal-range-date input').each(function() {
            $(this).datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                weekStart: 1,
                startDate: today,
                endDate: endYear
            });
        });

        // With JQuery
        $("#priceSlider").slider({});


        $('#activitiesSlider').slick({
            dots: false,
            arrows: false,
            infinite: false,
            speed: 300,
            slidesToShow: 15,
            slidesToScroll: 3,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        $('#activitiesSubCatSlider').slick({
            dots: false,
            arrows: false,
            infinite: false,
            speed: 300,
            slidesToShow: 15,
            slidesToScroll: 3,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                }
            ]
        });

        $(".loacal-map-item, .loacal-map-sub-item button").on("click", function() {
            var locationName = $(this).attr("location-name");

            map.addLayer()
            if ($(this).hasClass("loacal-map-item")) {
                $(this).next().toggle()
            }
            if ($(this).hasClass("active")) {
                $(this).removeClass("active") map.setZoom(5);
                map.setCenter(38.9547371, 37.3229544);
            } else {
                $(this).addClass("active") map.setZoom(locationList[locationName].zoom);
                map.setCenter(locationList[locationName].coordinates.lat, locationList[locationName].coordinates.ln);
            };
        });
    })
</script>
-->

<script>
    // function initialize() { // // var markers = []; // var map = new google.maps.Map(document.getElementById('map-canvas'), { // mapTypeId: google.maps.MapTypeId.ROADMAP // }); // // var defaultBounds = new google.maps.LatLngBounds( // new google.maps.LatLng(-33.8902, 151.1759), // new google.maps.LatLng(-33.8474, 151.2631)); // map.fitBounds(defaultBounds); // // // Create the search box and link it to the UI element. // var input = /** @type {HTMLInputElement} */ // ( // document.getElementById('pac-input')); // map.controls[google.maps.ControlPosition.TOP_LEFT].push(input); // // var searchBox = new google.maps.places.SearchBox( // /** @type {HTMLInputElement} */ // (input)); // // // [START region_getplaces] // // Listen for the event fired when the user selects an item from the // // pick list. Retrieve the matching places for that item. // google.maps.event.addListener(searchBox, 'places_changed', function() { // var places = searchBox.getPlaces(); // // if (places.length == 0) { // return; // } // for (var i = 0, marker; marker = markers[i]; i++) { // marker.setMap(null); // } // // // For each place, get the icon, place name, and location. // markers = []; // var bounds = new google.maps.LatLngBounds(); // for (var i = 0, place; place = places[i]; i++) { // var image = { // url: place.icon, // size: new google.maps.Size(71, 71), // origin: new google.maps.Point(0, 0), // anchor: new google.maps.Point(17, 34), // scaledSize: new google.maps.Size(25, 25) // }; // // // Create a marker for each place. // var marker = new google.maps.Marker({ // map: map, // icon: image, // title: place.name, // position: place.geometry.location // }); // // markers.push(marker); // // bounds.extend(place.geometry.location); // } // // map.fitBounds(bounds); // }); // // [END region_getplaces] // // // Bias the SearchBox results towards places that are within the bounds of the // // current map's viewport. // google.maps.event.addListener(map, 'bounds_changed', function() { // var bounds = map.getBounds(); // searchBox.setBounds(bounds); // }); // // // Trigger search on button click // document.getElementById('trigger-search').onclick = function() { // // var input = document.getElementById('pac-input'); // // google.maps.event.trigger(input, 'focus') // google.maps.event.trigger(input, 'keydown', { // keyCode: 13 // }); // }; // } // // google.maps.event.addDomListener(window, 'load', initialize);

</script>