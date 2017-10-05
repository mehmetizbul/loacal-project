<div country="{{ $country }}" style="display:block;" class="city form-group">
    <label for="city" class="city">Select City:
        <br/>
        @if($key>0)
            <span style='display:inline-block;' class="remove_city remove_location"><i class="fa fa-times" aria-hidden="true"></i></span>
        @endif
        @if(\App\Country::whereParent($country)->get())
            <select country="{{ $country }}" name="location[city][]"
                    class="city form-control">
                <option value="">Select a City</option>
                @foreach(\App\Country::whereParent($country)->get() as $tmp )
                    <option {{ isset($disable) && in_array($tmp->id,$disable) ? "disabled" : "" }} {{ isset($city) && $tmp->id == $city ? "selected" : "" }} value="{{ $tmp->id }}">{{ $tmp->name }}</option>
                @endforeach
            </select>
        @endif
        @if(!isset($view))
            <span class="add_city add_location"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add another city</span>
        @endif
    </label>
</div>