<div id="loacal-filters" class="col-md-12 no-padding">
    <form>
        <div class="col-md-6 col-xs-12 no-padding left-area">
            <div class="col-md-4 col-xs-12 filter-item">
                <span>Between Dates</span>
                <input type="text" nameattr="filter[date_from]" {{ isset($meta["date_from"]) ? "name='filter[date_from]'" : "" }} value="{{ isset($meta["date_from"]) ? $meta["date_from"] : "" }}" class="filter-field input-1-2 datepicker" placeholder="Date Start">
                <input type="text" nameattr="filter[date_to]" {{ isset($meta["date_to"]) ? "name='filter[date_to]'" : "" }}value="{{ isset($meta["date_to"]) ? $meta["date_to"] : "" }}" class="filter-field input-1-2 datepicker" placeholder="Date Start">
            </div>
            <div class="col-md-3 col-xs-4 filter-item">
                <span># of People</span>
                <input nameattr="filter[no_of_people]" {{ isset($meta["no_of_people"]) ? "name='filter[no_of_people]'" : "" }} value="{{ isset($meta["no_of_people"]) ? intval($meta["no_of_people"]) : "" }}" class="filter-field" type="number" min="1" step=1 value="{{ Lang::get('experience.number_of_people') }}">
            </div>
            <div class="col-md-5 col-xs-8 filter-item">
                <span>Price per Person</span>
                <input id="priceSlider" nameattr="filter[price_range]" {{ isset($meta["price_range"]) ? "name='filter[price_range]'" : "" }} class="filter-field" type="text" value="" data-slider-min="{{ $meta["filter_range_from"] }}" data-slider-max="{{ $meta["filter_range_to"] }}" data-slider-step="50" data-slider-value="[{{ $meta["price_range_from"] }},{{ $meta["price_range_to"] }}]" />

            </div>
            <div class="col-md-12 col-xs-12 filter-item">
                <span class="activities-head">Activities</span>
                <ul id="bxslider-filter">
                    @foreach(\App\Category::whereParent(0)->get() as $oCat)
                        <li>
                            <input class="filter-field" nameattr="filter[categories][]" name="filter[categories][]" {{ isset($meta["categories"]) ? in_array($oCat->id,$meta["categories"]) ? "checked" : "" : "" }} value="{{ $oCat->id }}" type="checkbox" id="{{ $oCat->name }}">
                            <label for="{{ $oCat->name }}"><img src="{{ $oCat->icon() }}"><span>{{ $oCat->name }}</span></label>
                        </li>
                    @endforeach

                </ul>
            </div>

            <div class="clearfix"></div>
            <div class="loacal-extra-filters" style="display:none;">
                <div class="col-md-4">
                    <span>{{ Lang::get('experience.lang_of_the_exp') }}</span>
                    <select name="filter[languages][]" id="loacal-language" multiple class="filter-field form-control">
                        @foreach(\App\ExperienceLanguage::distinct_languages() as $oLang)
                            <option value="{{ $oLang->id }}">{{ $oLang->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <span>{{ Lang::get('experience.transport') }}</span>
                    <input type="radio" nameattr="filter[loacal-transport]" class="filter-field" value="1" id="loacal-transport-option-1">
                    <label for="loacal-transport-option-1" onclick="$('#loacal-transport-option-1').is(':checked') ? $('#loacal-transport-option-1').checked = false : ''">Included</label>
                    <input type="radio" nameattr="filter[loacal-transport]" class="filter-field" value="2" id="loacal-transport-option-2">
                    <label for="loacal-transport-option-2" onclick="$('#loacal-transport-option-2').is(':checked') ? $('#loacal-transport-option-2').checked = false : ''">Available upon request (free)</label>
                    <input type="radio" nameattr="filter[loacal-transport]" class="filter-field" value="3" id="loacal-transport-option-3">
                    <label for="loacal-transport-option-3" onclick="$('#loacal-transport-option-3').is(':checked') ? $('#loacal-transport-option-3').checked = false : ''">Extra fee</label>
                    <div class="clearfix"></div>

                    <span>{{ Lang::get('experience.accommodation') }}</span>
                    <input type="radio" nameattr="filter[loacal-accommodation]" class="filter-field" value="1" id="loacal-accommodation-option-1">
                    <label for="loacal-accommodation-option-1" class="col-md-3" onclick="$('#loacal-accommodation-option-1').is(':checked') ? $('#loacal-accommodation-option-1').checked = false : ''">Included</label>
                    <input type="radio" nameattr="filter[loacal-accommodation]" class="filter-field" value="2" id="loacal-accommodation-option-2">
                    <label for="loacal-accommodation-option-2" class="col-md-6" onclick="$('#loacal-accommodation-option-2').is(':checked') ? $('#loacal-accommodation-option-2').checked = false : ''">Available upon request (free)</label>
                    <input type="radio" nameattr="filter[loacal-accommodation]" class="filter-field" value="3" id="loacal-accommodation-option-3">
                    <label for="loacal-accommodation-option-3" class="col-md-3" onclick="$('#loacal-accommodation-option-3').is(':checked') ? $('#loacal-accommodation-option-3').checked = false : ''">Extra fee</label>
                </div>
                <div class="col-md-4">
                    <span>Other Filters</span>
                    <input type="checkbox" name="filter[child_friendly]" value=true id="loacal-extra-filters-1">
                    <label for="loacal-extra-filters-1">Travelling with kids?</label>
                    <input type="checkbox" name="filter[disabled_friendly]" value=true id="loacal-extra-filters-2">
                    <label for="loacal-extra-filters-2">Travelling with a disabled person?</label>
                    <input type="checkbox" name="filter[free_experience]" value=true id="loacal-extra-filters-3">
                    <label for="loacal-extra-filters-3">Are you looking for a free activity?</label>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="col-md-4 col-md-offset-4">
                <button class="loacal-filter-button togglefilter"><span>+ More Filters</span></button>
                <button style="display:none;" class="loacal-filter-button togglefilter"><span>- Less Filters</span></button>
                <button class="btn btn-default" type="submit"><span>Apply Filter</span></button>
                <button class="loacal-filter-button" id="filter-reset" type="submit"><span>Reset</span></button>
            </div>
        </div>
        <div class="col-md-6 hidden-xs no-padding right-area">
            <span>Choose Your Destination</span>
            <div class="col-md-4 no-padding">
                @foreach(\App\Country::countries() as $oCountry)
                    <button class="location-main-buttons" location-name="{{ $oCountry->name }}">{{ $oCountry->name }} ({{ $oCountry->experience_country()->count() }})</button>
                    <div class="sub-locations" style="display:none">
                        @foreach(\App\Country::cities($oCountry->id) as $oCity)
                            <button value="{{$oCity->id}}" location-name="{{ $oCity->name }}">{{ $oCity->name }} ({{ $oCity->experience_country()->count() }})</button>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div id="mapholderparent" class=" col-md-8">
                <div id="mapholder"></div>
            </div>
        </div>
    </form>
</div>

<div class="filter-buttons only-on-mobile">
    <button>Map</button>
    <button onclick="$('#loacal-filters').show()">Filter</button>
</div>

<script type="text/javascript">
    var map;
    var mapoverlays = [];
     jQuery(document).ready(function($) {
         var selectedLocations = [];
        $('.togglefilter').on('click',function(e){
            e.preventDefault();
            e.stopImmediatePropagation();
            $(".loacal-extra-filters").toggle();
            $(".togglefilter").toggle();
        });

        $('#filter-reset').on('click',function(e){
            e.preventDefault();
            $('.filter-field').val('').trigger('change');
            $(this).parents($('form')).submit();
        });

        $('.filter-field').on('change',function(){
            if($(this).val() != ''){
                $(this).attr('name',$(this).attr('nameattr'));
            }else{
                $(this).attr('name','');
            }
        });

        $('#loacal-language').SumoSelect();
        $('#bxslider-filter').bxSlider({
            minSlides: 1.5,
            maxSlides: 10,
            slideWidth: 150,
            slideMargin: 10,
            moveSlides: 1,
            infiniteLoop:false
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
        
        $(".sub-locations button").on("click", function(e) {
            e.preventDefault();
            var locationName = $(this).attr("location-name");
            if ($(this).hasClass("active")) {

                $(this).removeClass("active")
                document.getElementById($(this).val()).remove();

                mapoverlays.forEach(function(item, index) {
                    if (item.lat == locationList[locationName].coordinates.lat && item.lng == locationList[locationName].coordinates.ln) {
                        mapoverlays.splice(index, 1);
                    }
                })
                map.removeOverlays();
                selectedLocations.forEach(function(item, index) {
                    if (item == locationName) {
                        selectedLocations.splice(index, 1);
                    }
                })
                if(selectedLocations.length > 2){
                    map.setZoom(locationList[selectedLocations[0]].zoom);
                    map.setCenter(locationList[selectedLocations[0]].coordinates.lat, locationList[selectedLocations[0]].coordinates.ln);
                    map.drawOverlay(mapoverlays[0])
                }else{
                    map.setZoom(locationList[locationName].zoom);
                    map.setCenter(locationList[locationName].coordinates.lat, locationList[locationName].coordinates.ln);
                    map.drawOverlay(mapoverlays[mapoverlays.length - 1])
                }
                
            } else {


                $(this).append('<input class="cities" type="hidden" nameattr="filter[cities][]" name="filter[cities][]" value="'+$(this).val()+'" id="'+$(this).val()+'">');


                $(this).addClass("active")
                selectedLocations.push(locationName);
                console.log(selectedLocations)
                if(selectedLocations.length > 2){
                    map.setZoom(locationList[selectedLocations[0]].zoom);
                    map.setCenter(locationList[selectedLocations[0]].coordinates.lat, locationList[selectedLocations[0]].coordinates.ln);
                }else{
                    map.setZoom(locationList[locationName].zoom);
                    map.setCenter(locationList[locationName].coordinates.lat, locationList[locationName].coordinates.ln);
                }
                mapoverlays.push({
                    lat: locationList[locationName].coordinates.lat,
                    lng: locationList[locationName].coordinates.ln,
                    content: '<div class="overlay">' + locationName + '</div>'
                });
                map.removeOverlays();
                mapoverlays.forEach(function(item, index) {
                    if(selectedLocations.length > 2){
                        if(index !== 0){
                            map.drawOverlay(item)
                        }
                    }else{
                        map.drawOverlay(item)
                    }
                })
            }
        });
        
        $(".location-main-buttons").on('click',function(e){
            e.preventDefault();
            $('.sub-locations').hide();
            $(this).next().toggle();
            var locationName = $(this).attr("location-name");
            selectedLocations.push(locationName);
            map.setZoom(locationList[locationName].zoom);
            map.setCenter(locationList[locationName].coordinates.lat, locationList[locationName].coordinates.ln);
            if ($(this).hasClass("active")) {
                $(".active").removeClass("active")
                mapoverlays = [];
                map.removeOverlays();
            } else {
                $(".active").removeClass("active")
                $(this).addClass("active")
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
</script>

