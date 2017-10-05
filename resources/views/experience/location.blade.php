<?php $i = 0;$j = 0;?>
@if(isset($oExp))
    @foreach($oExp->countries() as $parent=>$tmp)
        <div location="{{ $parent }}" class='location'>
            <div style="display:block;" class="country form-group">
                <label for="country" class="country">Select Country:
                    <br/>
                    <span {!! ++$i>0 ? "style='display:inline-block !important;'" : "" !!} class="remove_country remove_location"><i
                                class="fa fa-times" aria-hidden="true"></i></span>
                    <select name="location[]" class="country form-control">
                        <option value="">Select a Country</option>
                        @foreach(\App\Country::whereParent(0)->get() as $country )
                            <option {{ $country->id == $parent ? "selected" : "" }} value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                    @if(!isset($view))
                        <span class="add_country add_location"><i
                                    class="fa fa-plus-circle"
                                    aria-hidden="true"></i> Add another country</span>
                    @endif
                </label>
            </div>
            @foreach($tmp as $parent2=>$tmp2)
                <div country="{{ $parent }}" style="display:block;"
                     class="city form-group" style="display:none;">
                    <label for="city" class="city">Select City:
                        <br/>
                        <span {!! ++$j>0 ? "style='display:inline-block;'" : "" !!} class="remove_city remove_location"><i
                                    class="fa fa-times"
                                    aria-hidden="true"></i></span>
                        <select country="{{ $parent }}" name="location[]"
                                class="city form-control">
                            <option value="">Select a City</option>
                            @foreach(\App\Country::whereParent($parent)->get() as $city )
                                <option {{ $city->id == $parent2 ? "selected" : "" }} value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                        @if(!isset($view))
                            <span class="add_city add_location"><i
                                        class="fa fa-plus-circle"
                                        aria-hidden="true"></i> Add another city</span>
                        @endif
                    </label>
                </div>
                @foreach($tmp2 as $key=>$child)
                    <div style="display:block;" city="{{ $parent2 }}"
                         class="area form-group" style="display:none;">
                        <label for="area" class="area">Select Area:
                            <br/>
                            <span {!! $key>0 ? "style='display:inline-block;'" : "" !!} class="remove_area remove_location"><i
                                        class="fa fa-times"
                                        aria-hidden="true"></i></span>
                            <select city="{{ $parent2 }}" name="location[]"
                                    class="area form-control">
                                <option value="">Select a City</option>
                                @foreach(\App\Country::whereParent($parent2)->get() as $area )
                                    <option {{ $area->id == $child ? "selected" : "" }} value="{{ $area->id }}">{{ $area->name }}</option>
                                @endforeach
                            </select>
                            @if(!isset($view))
                                <span class="add_area add_location"><i
                                            class="fa fa-plus-circle"
                                            aria-hidden="true"></i> Add another area</span>
                            @endif
                        </label>
                    </div>
                @endforeach
                <?php $j++; ?>
            @endforeach
        </div>
    @endforeach
@endif
