<div style="display:block;" class="country form-group">
    <label for="country" class="country">Select Country:
        <br/>
        @if($key>1)
            <span style='display:inline-block !important;' class="remove_country remove_location"><i class="fa fa-times" aria-hidden="true"></i></span>
        @endif
        <select name="location[country][]" class="country form-control">
            <option value="">Select a Country</option>
            @foreach(\App\Country::whereParent(0)->get() as $tmp )
                <option {{ isset($disable) && in_array($tmp->id,$disable) ? "disabled" : "" }} {{ isset($country) && $tmp->id == $country ? "selected" : "" }} value="{{ $tmp->id }}">{{ $tmp->name }}</option>
            @endforeach
        </select>
        @if(!isset($view))
            <span class="add_country add_location"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add another country</span>
        @endif
    </label>
</div>