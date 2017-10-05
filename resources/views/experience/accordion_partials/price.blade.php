<h4 index="{{ $index }}" class="accordion-toggle">Price: €<span></span><i
            class="fa fa-check unchecked add_experience_row_success fa-pull-right"
            aria-hidden="true"></i></h4>
<div class="accordion-content">
    <div class="row accord-content" style="width: 100%;">
        <div class="form-group">
            <div class="col-md-12">

                @if (Session::has('prices'))
                @foreach(Session::get('prices') as $key=>$price)
                <div class="col-md-12 prices_container" index="{{ $key }}">
                    <div class="col-md-2">
                        <span class="inline-block" style="margin-top: 5px;">Min</span>
                        <input name="prices[{{ $key }}][min]" type="number"
                               step="1" min="0"
                               class="form-control inline-block"
                               placeholder="1" value="{{ $price["min"] }}">
                    </div>
                    <div class="col-md-2">
                        <span class="inline-block" style="margin-top: 5px;">Max</span>
                        <input name="prices[{{ $key }}][max]" type="number"
                               step="1" min="0"
                               class="form-control inline-block"
                               placeholder="4" value="{{ $price["max"] }}">
                    </div>
                    <div class="col-md-2">
                                                <span class="inline-block">
                                                    <span class="inline-block" style="margin-top: 5px;"><br/></span>
                                                    <select name="prices[{{ $key }}][type]" class="form-control">
                                                        <option value="adults" {{ $price["type"] == "adults" ? "selected" : "" }}>Adults</option>
                                                        <option value="children" {{ $price["type"] == "children" ? "selected" : "" }}>Children</option>
                                                    </select>
                                                </span>
                    </div>
                    <div class="col-md-2 no-padding">
                        <span class="inline-block" style="margin-top: 5px;">Price (€)</span>
                        <input name="prices[{{ $key }}][price]"
                               type="number" step="0.01" min="0"
                               class="form-control inline-block"
                               placeholder="i.e. 33.5 "
                               value="{{ $price["price"] }}">
                    </div>
                    <div class="col-md-3 centered">
                        <div class="form-group">
                                                                        <span class="inline-block"
                                                                              style="margin-top: 5px;"><br/></span>
                            <select class="form-control"
                                    name="prices[{{ $key }}][price_type]">
                                <option value="persons" {{ $price["price_type"] == "persons" ? "selected" : "" }}>
                                Per Person
                                </option>
                                <option value="total" {{ $price["price_type"] == "total" ? "selected" : "" }}>
                                Total
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 centered">
                        <span class="inline-block" style="margin-top: 5px;"><br/></span>
                        @if(!isset($view))
                                    <span remove="{{ $key }}"
                                          style="{{ $key>0 ? "display:inline-block;" : "" }}"
                        class="remove_price fa fa-times"><i
                            aria-hidden="true"></i></span>
                        @endif
                    </div>
                </div>
                @endforeach
                @elseif(isset($oExp) && count($oExp->prices()))
                @foreach($oExp->prices() as $key=>$price)
                <div class="col-md-12 prices_container" index="{{ $key }}">
                    <div class="col-md-2">
                        <span class="inline-block" style="margin-top: 5px;">Min</span>
                        <input name="prices[{{ $key }}][min]" type="number"
                               step="1" min="0"
                               class="form-control inline-block"
                               placeholder="1" value="{{ $price["min"] }}">
                    </div>
                    <div class="col-md-2">
                        <span class="inline-block" style="margin-top: 5px;">Max</span>
                        <input name="prices[{{ $key }}][max]" type="number"
                               step="1" min="0"
                               class="form-control inline-block"
                               placeholder="4" value="{{ $price["max"] }}">
                    </div>
                    <div class="col-md-2">
                                                <span class="inline-block">
                                                    <span class="inline-block" style="margin-top: 5px;"><br/></span>
                                                    <select name="prices[{{ $key }}][type]" class="form-control">
                                                        <option value="adults" {{ $price["type"] == "adults" ? "selected" : "" }}>Adults</option>
                                                        <option value="children" {{ $price["type"] == "children" ? "selected" : "" }}>Children</option>
                                                    </select>
                                                </span>
                    </div>
                    <div class="col-md-2 no-padding">
                        <span class="inline-block" style="margin-top: 5px;">Price (€)</span>
                        <input name="prices[{{ $key }}][price]"
                               type="number" step="0.01" min="0"
                               class="form-control inline-block"
                               placeholder="i.e. 33.5 "
                               value="{{ $price["price"] }}">
                    </div>
                    <div class="col-md-3 centered">
                        <div class="form-group">
                                                                        <span class="inline-block"
                                                                              style="margin-top: 5px;"><br/></span>
                            <select class="form-control"
                                    name="prices[{{ $key }}][price_type]">
                                <option value="persons" {{ $price["price_type"] == "persons" ? "selected" : "" }}>
                                Per Person
                                </option>
                                <option value="total" {{ $price["price_type"] == "total" ? "selected" : "" }}>
                                Total
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 centered">
                        <span class="inline-block" style="margin-top: 5px;"><br/></span>
                        @if(!isset($view))
                                    <span remove="{{ $key }}"
                                          style="{{ $key>0 ? "display:inline-block;" : "" }}"
                        class="remove_price fa fa-times"><i
                            aria-hidden="true"></i></span>
                        @endif
                    </div>
                </div>
                @endforeach
                @else
                <div class="col-md-12 prices_container" index="0">
                    <div class="col-md-2">
                                                                <span class="inline-block"
                                                                      style="margin-top: 5px;">Min</span>
                        <input name="prices[0][min]" type="number" step="1"
                               min="0" class="form-control inline-block"
                               placeholder="1">
                    </div>
                    <div class="col-md-2">
                                                                <span class="inline-block"
                                                                      style="margin-top: 5px;">Max</span>
                        <input name="prices[0][max]" type="number" step="1"
                               min="0" class="form-control inline-block"
                               placeholder="4">
                    </div>
                    <div class="col-md-2">
                                                <span class="inline-block">
                                                    <span class="inline-block" style="margin-top: 5px;"><br/></span>
                                                    <select name="prices[0][type]" class="form-control">
                                                        <option value="adults" selected>Adults</option>
                                                        <option value="children">Children</option>
                                                    </select>
                                                </span>
                    </div>
                    <div class="col-md-2 no-padding">
                        <span class="inline-block" style="margin-top: 5px;">Price (€)</span>
                        <input name="prices[0][price]" type="number" step="0.01"
                               min="0" class="form-control inline-block"
                               placeholder="i.e. 33.5 ">
                    </div>
                    <div class="col-md-3 centered">
                        <div class="form-group">
                            <span class="inline-block" style="margin-top: 5px;"><br/></span>
                            <select class="form-control"
                                    name="prices[0][price_type]">
                                <option value="persons">Per Person</option>
                                <option value="total">Total</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1 centered">
                                                                <span class="inline-block"
                                                                      style="margin-top: 5px;"><br/></span>
                        @if(!isset($view))
                                <span remove="0" class="remove_price fa fa-times"><i
                                        aria-hidden="true"></i></span>
                        @endif
                    </div>
                </div>
                @endif


                <div class="col-md-12">
                    @if(!isset($view))
                        <a href="#" id="addmore_prices_container"
                           class="btn btn-primary  pull-right">Add more</a>
                    @endif
                </div>
            </div>
            <div class="col-md-12 mt10">
                <div class="alert alert-info">
                    Prices should include 14% loacal commission!
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($){
        $(document).off("click", ".remove_price").on("click", ".remove_price", function () {
            if ($('.remove_price').length > 1) {
                $(".prices_container[index=" + $(this).attr("remove") + "]").remove().end();
            }
        });

        $(document).off("click", "#addmore_prices_container").on("click", "#addmore_prices_container", function () {
            var clone = $(".prices_container").last().clone(true, true);
            var index = clone.attr("index");
            var newindex = parseInt(index) + 1;

            clone.attr('index', newindex);
            clone.find('input,select').each(function () {
                var name = $(this).attr("name");
                var newname = name.substr(0, name.indexOf('['));
                newname = newname + "[" + newindex + "]";
                newname = newname + name.substr(name.indexOf(']') + 1);
                $(this).attr("name", newname);
            });
            clone.find('.remove_price').attr('remove', newindex).show();
            clone.insertAfter($(".prices_container").last());
        });
    });
</script>