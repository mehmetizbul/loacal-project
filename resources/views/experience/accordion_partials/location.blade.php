<h4 index="{{ $index }}" class="accordion-toggle">Experience Location<span></span><i
            class="fa fa-check unchecked add_experience_row_success fa-pull-right"
            aria-hidden="true"></i></h4>
<div class="accordion-content">
    <div class="locations row accord-content">
        <?php $key=0; ?>
        @if(isset($oExp))
            <?php $countries = $oExp->countries();?>
            @foreach($countries as $country=>$cities)
                <?php $key++; ?>
                @include('experience.partials.location',['country','cities','key'])
            @endforeach
        @else
            <?php $key++; ?>
            @include('experience.partials.location',['key'])
        @endif
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($){
        $(document).off('change', '.country').on('change', '.country', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var location = $(this).closest("div.location").attr("location");
            var self = this;
            disable=[];
            $("select.city").each(function(){
                disable.push($(this).val());
            });
            $.ajax({
                type: "GET",
                url: "{{ route("location.city") }}",
                data: {
                    country:$(this).val(),
                    key:location,
                    disable:disable
                },
                success: function(city){
                    $(".location[location="+location+"] div.city,.location[location="+location+"] div.area").remove().end();
                    $(city).insertAfter(self.closest('div.country'));
                },
                error: function(){
                    console.log("wut?!");
                }
            });
        });

        $(document).off('change', '.city').on('change', '.city', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var location = $(this).closest("div.location").attr("location");
            var self = $(this);
            disable=[];
            $("select.city").each(function(){
                disable.push($(this).val());
            });

            $.ajax({
                type: "GET",
                url: "{{ route("location.area") }}",
                data: {
                    city:$(this).val(),
                    key:location,
                    disable:disable
                },
                success: function(area){
                    self.closest("div.city").next("div.area").remove().end();
                    //$(".location[location="+location+"] div.area").remove().end();
                    $(area).insertAfter(self.closest('div.city'));
                },
                error: function(){
                    console.log("wut?!");
                }
            });
        });

        $(document).off('click', '.add_country').on('click', '.add_country', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var key = $("div.location").length;
            var disable = [];
            $("select.country").each(function(){
                disable.push($(this).val());
            });
            var self = this;
            $.ajax({
                type: "GET",
                url: "{{ route("location.country") }}",
                data: {
                    key:key+1,
                    disable:disable
                },
                success: function(location){
                    $(location).insertAfter(self.closest('div.location'));
                },
                error: function(){
                    console.log("wut?!");
                }
            });
        });

        $(document).off('click', '.add_city').on('click', '.add_city', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var key = $("div.city").length;
            var country = $(this).closest("div.city").attr("country");
            var disable = [];
            $("select.city").each(function(){
                disable.push($(this).val());
            });
            var self = $(this);
            $.ajax({
                type: "GET",
                url: "{{ route("location.city") }}",
                data: {
                    key:key+1,
                    country:country,
                    disable:disable
                },
                success: function(city){
                    $(city).appendTo(self.closest("div.location"));
                },
                error: function(){
                    console.log("wut?!");
                }
            });

        });

        $(document).off('click', '.add_area').on('click', '.add_area', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            var key = $("div.area").length;
            var city = $(this).closest("div.area").attr("city");
            console.log(city);
            var disable = [];
            $("select.area").each(function(){
                disable.push($(this).val());
            });
            var self = $(this);
            $.ajax({
                type: "GET",
                url: "{{ route("location.area") }}",
                data: {
                    key:key+1,
                    city:city,
                    disable:disable
                },
                success: function(area){
                    $(area).insertAfter(self.closest('div.area'));
                },
                error: function(){
                    console.log("wut?!");
                }
            });

        });

        $(document).off('click', '.remove_location').on('click', '.remove_location', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();
            if ($(this).closest('.form-group').is('.area')) {
                $(this).closest('.form-group.area').remove().end();
            } else if ($(this).closest('.form-group').is('.city')) {
                $(this).closest('.form-group.city').next('.form-group.area').remove().end();
                $(this).closest('.form-group.city').remove().end();
            } else if ($(this).closest('.form-group').is('.country')) {
                $(this).closest('.location').remove();
            }
        });    });
</script>