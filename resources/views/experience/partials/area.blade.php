@if(count(\App\Country::whereParent($city)->get()))

    <div style="display:block;" city="{{ $city }}"
         class="area form-group" style="display:none;">
        <label for="area" class="area">Select Area:
            <br/>
            @if($key>0)
                <span style='display:inline-block;' class="remove_area remove_location"><i class="fa fa-times" aria-hidden="true"></i></span>
            @endif
            <select city="{{ $city }}" name="location[area][]"
                    class="area form-control">
                <option value="">Select an Area</option>
                @foreach(\App\Country::whereParent($city)->get() as $tmp )
                    <option {{ isset($disable) && in_array($tmp->id,$disable) ? "disabled" : "" }} {{ isset($area) && $tmp->id == $area ? "selected" : "" }} value="{{ $tmp->id }}">{{ $tmp->name }}</option>
                @endforeach
            </select>
            @if(!isset($view))
                <span class="add_area add_location"><i
                            class="fa fa-plus-circle" aria-hidden="true"></i> Add another area</span>
            @endif
        </label>
    </div>
@endif
