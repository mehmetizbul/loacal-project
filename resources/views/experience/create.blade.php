<!--
/**
 * Created by PhpStorm.
 * User: Bugra
 * Date: 23.04.2017
 * Time: 16:08
 */
-->


@extends("layouts.app")

@section("content")

    <div class="container-fluid mt40">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Create a new Experience
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route('experience.store') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{ $auth->id }}">

                        <div class="accordion container">
                            <h4 index="1" class="accordion-toggle">Experience Title: <span></span><i class="fa fa-check unchecked add_experience_row_success fa-pull-right" aria-hidden="true"></i></h4>
                            <div class="accordion-content">
                                <div class="row accord-content">
                                    <div class="form-group">
                                        <div class="col-md-10 col-md-offset-1">
                                            <input name="title" index="1" id="title" type="text" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4 index="2" class="accordion-toggle">Experience Location: <span></span><i class="fa fa-check unchecked add_experience_row_success fa-pull-right" aria-hidden="true"></i></h4>
                            <div class="accordion-content">
                                <div class="locations row accord-content">

                                </div>
                            </div>

                            <h4 index="3" class="accordion-toggle">Experience Description: <span></span><i class="fa fa-check unchecked add_experience_row_success fa-pull-right" aria-hidden="true"></i></h4>
                            <div class="accordion-content">
                                <div class="row accord-content" style="width:100%;">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            {!! Form::textarea('description', null, array('id' => 'description','placeholder' => 'Description','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h4 index="4" class="accordion-toggle">Child-friendly?: <span>No</span><i class="fa fa-check add_experience_row_success fa-pull-right" aria-hidden="true"></i></h4>
                            <div class="accordion-content">
                                <div class="row accord-content">
                                    <div class="form-group col-md-6 col-md-offset-3">
                                        <span class="inline-block">Child Friendly? No</span>
                                        <input name="child_friendly" index="4" type="checkbox" name="toggle" id="toggle" class="inline-block">
                                        <span class="inline-block">Yes</span>
                                    </div>
                                </div>
                            </div>

                            <h4 index="5" class="accordion-toggle">Disabled-friendly?: <span>No</span><i class="fa fa-check add_experience_row_success fa-pull-right" aria-hidden="true"></i></h4>
                            <div class="accordion-content">
                                <div class="row accord-content">
                                    <div class="form-group col-md-6 col-md-offset-3">
                                        <span class="inline-block">Disabled Friendly? No</span>
                                        <input name="disabled_friendly" index="5" type="checkbox" name="toggle" id="toggle" class="inline-block">
                                        <span class="inline-block">Yes</span>
                                    </div>
                                </div>
                            </div>

                            <h4 index="6" class="accordion-toggle">Category: <span></span><i class="fa fa-check unchecked add_experience_row_success fa-pull-right" aria-hidden="true"></i></h4>
                            <div class="accordion-content">
                                <div class="row accord-content" style="width:100%;">
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                            <div class="col-lg-4 text-center" id="cat-unselected">
                                                <h5>Main Categories</h5>
                                                @foreach(\App\Category::whereParent(0)->get() as $oCat)
                                                    <div cat="{{ $oCat->id }}" class="col-lg-12 main-cat">
                                                        <label class="btn" style="">
                                                            <img class='img-thumbnail img-check cat-image' src='{{ $oCat->icon() }}' alt='cat_name' />
                                                            <input type="checkbox" value="{{ $oCat->id }}" class="hidden" autocomplete="off">
                                                            <br />
                                                            {{ $oCat->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="col-lg-4 text-center" id="subcat-unselected">
                                                <h5>Sub Categories</h5>

                                            </div>
                                            <div class="col-lg-4 text-center" id="cat-selected">
                                                <h5>Selected Categories</h5>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h4 index="7" class="accordion-toggle">Duration: <span></span><i class="fa fa-check unchecked add_experience_row_success fa-pull-right" aria-hidden="true"></i></h4>
                            <div class="accordion-content">
                                <div class="row accord-content">
                                    <div class="form-group">
                                        <div class="col-md-10 col-md-offset-1">

                                            <div class="col-md-6 col-xs-6 no-padding">
                                                <input name="duration" type="number" step="0.01" min="0" class="form-control">
                                            </div>
                                            <div class="col-md-6 col-xs-6 no-padding">
                                                <select name="duration_unit" class="form-control"
                                                        onchange="document.getElementById('duration_unit').value = this.value;
                                                        document.getElementById('pm_duration_unit').value = this.value;">
                                                    <option value="hour">Hours</option>
                                                    <option value="minute">Minutes</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h4 index="8" class="accordion-toggle"># of people: <span></span><i class="fa fa-check unchecked add_experience_row_success fa-pull-right" aria-hidden="true"></i></h4>
                            <div class="accordion-content">
                                <div class="row accord-content">
                                    <div class="form-group">
                                        <div class="col-md-12 col-xs-12">
                                            <div class="col-md-12 padding-top-bottom-10">
                                                <div class="col-md-4 col-xs-12">
                                                    <span>Number of Adults: </span>
                                                </div>
                                                <div class="col-md-1 col-xs-4 mt10">
                                                    <span>Min</span>
                                                </div>
                                                <div class="col-md-3 col-xs-8 mt10">
                                                    <input name="min_persons" type="number" min="1" step="1" class="form-control">
                                                </div>
                                                <div class="col-md-1 col-xs-4 mt10">
                                                    <span>Max</span>
                                                </div>
                                                <div class="col-md-3 col-xs-8 mt10">
                                                    <input name="max_persons" type="number" min="1" step="1" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-xs-12 padding-top-bottom-10">
                                                <div class="col-md-4 col-xs-12">
                                                    <span>Number of Children: </span>
                                                </div>
                                                <div class="col-md-1 col-xs-4 mt10">
                                                    <span>Min</span>
                                                </div>
                                                <div class="col-md-3 col-xs-8 mt10">
                                                    <input name="min_children" type="number" min="0" step="1" class="form-control">
                                                </div>
                                                <div class="col-md-1 col-xs-4 mt10">
                                                    <span>Max</span>
                                                </div>
                                                <div class="col-md-3 col-xs-8 mt10">
                                                    <input name="max_children" type="number" min="0" step="1" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h4 index="9" class="accordion-toggle">Price: €<span></span><i class="fa fa-check unchecked add_experience_row_success fa-pull-right" aria-hidden="true"></i></h4>
                            <div class="accordion-content">
                                <div class="row accord-content" style="width: 100%;">
                                    <div class="form-group">
                                        <div class="col-md-12">

                                            <ul class="nav nav-pills">
                                                <li class="active"><a data-toggle="pill" href="#help">Help</a></li>
                                                <li><a data-toggle="pill" href="#fixedPrice">Fixed Price for Experience</a></li>
                                                <li><a data-toggle="pill" href="#pricePP">Price Per Person</a></li>
                                                <li><a data-toggle="pill" href="#resources">Resources</a></li>
                                            </ul>

                                            <div class="tab-content mt20">
                                                <div id="help" class="tab-pane fade in active">
                                                    <p><strong>Fixed price</strong> means when you define a price for an experience. Without depending on the number of people, the price will be fixed.</p>
                                                    <p><strong>Price Per Person</strong> gives you option to define pricing for different number of people.</p>
                                                </div>
                                                <div id="fixedPrice" class="tab-pane fade">
                                                    <h4 style="margin-left: 7%;"># of People - Fixed Price</h4>

                                                    <div class="col-md-12">
                                                        <div class="col-md-4 no-padding">
                                                            <input name="price" type="number" step="0.01" min="0" class="form-control inline-block" placeholder="i.e. €33.5 ">
                                                        </div>
                                                        <div class="col-md-4 centered">
                                                            <div class="form-group">
                                                                <select class="form-control" name="type">
                                                                    <option value="persons">Per Person</option>
                                                                    <option value="total">Total</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4 centered">
                                                            <div class="form-group">
                                                                <select disabled class="form-control" id="duration_unit" name="duration_unit" >
                                                                    <option value="hour">per Hour</option>
                                                                    <option value="minute">per Minute</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="pricePP" class="tab-pane fade">
                                                    <h4 style="margin-left: 7%;"># of People - Price Range</h4>
                                                    <div class="col-md-12 pricePP" index="0">
                                                        <div class="col-md-2 no-padding ">
                                                            <input name="price_models[0][min]" type="number" step="1" min="0" class="form-control inline-block" placeholder="1">
                                                        </div>
                                                        <div class="col-md-1 no-padding centered">
                                                            <span class="inline-block" style="margin-top: 5px;">to</span>
                                                        </div>
                                                        <div class="col-md-2 no-padding">
                                                            <input name="price_models[0][max]" type="number" step="1" min="0" class="form-control inline-block" placeholder="4">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <span class="inline-block" style="margin-top: 5px;">people</span>
                                                        </div>
                                                        <div class="col-md-2 no-padding">
                                                            <input name="price_models[0][base_cost]" type="number" step="0.01" min="0" class="form-control inline-block" placeholder="i.e. €33.5 ">
                                                        </div>
                                                        <div class="col-md-3 centered">
                                                            <div class="form-group">
                                                                <select class="form-control" name="price_models[0][type]">
                                                                    <option value="persons">Per Person</option>
                                                                    <option value="total">Total</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="col-md-9 centered">
                                                        </div>
                                                        <div class="col-md-3 centered">
                                                            <div class="form-group">
                                                                <select disabled class="form-control" id="pm_duration_unit" name="price_models[0][duration_unit]">
                                                                    <option value="hour">Per Hour</option>
                                                                    <option value="minute">Per Minute</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <a href="#" id="addmore_pricePP" class="btn btn-primary  pull-right">Add more</a>
                                                    </div>
                                                </div>
                                                <div id="resources" class="tab-pane fade">
                                                    <div class="col-md-12">
                                                        <div class="col-md-4">
                                                            <span>Select Resource</span>

                                                        </div>
                                                        <div class="col-md-8">
                                                            <div class="dropdown">
                                                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Add Resource
                                                                    <span class="caret"></span></button>
                                                                <ul class="dropdown-menu">
                                                                    <li><a href="#">Resource 1</a></li>
                                                                    <li><a href="#">Resource 2</a></li>
                                                                    <li><a href="#">Resource 3</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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

                            <h4 index="10" class="accordion-toggle">Availability: <span></span><i class="fa fa-check unchecked add_experience_row_success fa-pull-right" aria-hidden="true"></i></h4>
                            <div class="accordion-content">
                                <div class="row accord-content">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <div class="panel panel-default clearfix">
                                                <div class="col-xs-12 toggle-header">
                                                    {{--<div class="col-xs-4">--}}
                                                    {{--</div>--}}
                                                    <div class="col-xs-1 text-center">
                                                        <span class="hidden-xs">{{ Lang::get('experience.monday') }}</span>
                                                        <span class="visible-xs">{{ Lang::get('experience.monday') }}</span>
                                                    </div>
                                                    <div class="col-xs-1 text-center">
                                                        <span class="hidden-xs">{{ Lang::get('experience.tuesday') }}</span>
                                                        <span class="visible-xs">{{ Lang::get('experience.tuesday') }}</span>
                                                    </div>
                                                    <div class="col-xs-1 text-center">
                                                        <span class="hidden-xs">{{ Lang::get('experience.wednesday') }}</span>
                                                        <span class="visible-xs">{{ Lang::get('experience.wednesday') }}</span>
                                                    </div>
                                                    <div class="col-xs-1 text-center">
                                                        <span class="hidden-xs">{{ Lang::get('experience.thursday') }}</span>
                                                        <span class="visible-xs">{{ Lang::get('experience.thursday') }}</span>
                                                    </div>
                                                    <div class="col-xs-1 text-center">
                                                        <span class="hidden-xs">{{ Lang::get('experience.friday') }}</span>
                                                        <span class="visible-xs">{{ Lang::get('experience.friday') }}</span>
                                                    </div>
                                                    <div class="col-xs-1 text-center">
                                                        <span class="hidden-xs">{{ Lang::get('experience.saturday') }}</span>
                                                        <span class="visible-xs">{{ Lang::get('experience.saturday') }}</span>
                                                    </div>
                                                    <div class="col-xs-1 text-center">
                                                        <span class="hidden-xs">{{ Lang::get('experience.sunday') }}</span>
                                                        <span class="visible-xs">{{ Lang::get('experience.sunday') }}</span>
                                                    </div>
                                                </div>

                                                <div id="feature-1" class="collapse in">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            {{--<div class="col-xs-4">--}}
                                                                {{--{{ Lang::get('experience.availability') }}--}}
                                                            {{--</div>--}}
                                                            <div class="col-xs-1 text-center">
                                                                <input name="availability[]" type="checkbox" value="1">
                                                            </div>
                                                            <div class="col-xs-1 text-center">
                                                                <input name="availability[]" type="checkbox" value="2">
                                                            </div>
                                                            <div class="col-xs-1 text-center">
                                                                <input name="availability[]" type="checkbox" value="3">
                                                            </div>
                                                            <div class="col-xs-1 text-center">
                                                                <input name="availability[]" type="checkbox" value="4">
                                                            </div>
                                                            <div class="col-xs-1 text-center">
                                                                <input name="availability[]" type="checkbox" value="5">
                                                            </div>
                                                            <div class="col-xs-1 text-center">
                                                                <input name="availability[]" type="checkbox" value="6">
                                                            </div>
                                                            <div class="col-xs-1 text-center">
                                                                <input name="availability[]" type="checkbox" value="7">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <h4 index="11" class="accordion-toggle">Transportation: <span></span><i class="fa fa-check unchecked add_experience_row_success fa-pull-right" aria-hidden="true"></i></h4>
                            <div class="accordion-content">
                                <div class="row accord-content">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="col-md-6">
                                                    <p class="inline-block mt20">Available upon request (extra fee)</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <span class="inline-block">No</span>
                                                    <input type="radio" name="transportation" value="3" id="toggle" class="inline-block">
                                                    <span class="inline-block">Yes</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12"><div class="col-md-6 mt10">
                                                    <p class="inline-block mt20">Available upon request (free)</p>
                                                </div>
                                                <div class="col-md-6 mt10">
                                                    <span class="inline-block">No</span>
                                                    <input type="radio" name="transportation" value="2" id="toggle" class="inline-block">
                                                    <span class="inline-block">Yes</span>
                                                </div></div>
                                            <div class="col-md-12">
                                                <div class="col-md-6 mt10">
                                                    <p class="inline-block mt20">Included in price</p>
                                                </div>
                                                <div class="col-md-6 mt10">
                                                    <span class="inline-block">No</span>
                                                    <input type="radio" name="transportation" value="1" id="toggle" class="inline-block">
                                                    <span class="inline-block">Yes</span>
                                                </div>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h4 index="12" class="accordion-toggle">Accommodation: <span></span><i class="fa fa-check unchecked add_experience_row_success fa-pull-right" aria-hidden="true"></i></h4>
                            <div class="accordion-content">
                                <div class="row accord-content">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <div class="col-md-6">
                                                    <p class="inline-block mt20">Available upon request (extra fee)</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <span class="inline-block">No</span>
                                                    <input type="radio" name="accommodation" value="1" id="toggle" class="inline-block">
                                                    <span class="inline-block">Yes</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-md-6 mt10">
                                                    <p class="inline-block mt20">Available upon request (free)</p>
                                                </div>
                                                <div class="col-md-6 mt10">
                                                    <span class="inline-block">No</span>
                                                    <input type="radio" name="accommodation" value="1" id="toggle" class="inline-block">
                                                    <span class="inline-block">Yes</span>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-md-6 mt10">
                                                    <p class="inline-block mt20">Included in price</p>
                                                </div>
                                                <div class="col-md-6 mt10">
                                                    <span class="inline-block">No</span>
                                                    <input type="radio" name="accommodation" value="1" id="toggle" class="inline-block">
                                                    <span class="inline-block">Yes</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h4 index="13" class="accordion-toggle">Language: <span></span><i class="fa fa-check unchecked add_experience_row_success fa-pull-right" aria-hidden="true"></i></h4>
                            <div class="accordion-content">
                                <div class="row accord-content" style="width:100%;">
                                    <div class="form-group ">
                                        <div class="col-md-3">
                                        </div>
                                        <div class="col-md-6">
                                            <select style="height:150px;" multiple class="form-control" name="language[]">
                                                @foreach(\App\Language::all() as $lang)
                                                    <option value="{{ $lang->id }}">{{ $lang->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h4 index="14" class="accordion-toggle">Purchase Note: <span></span><i class="fa fa-check unchecked add_experience_row_success fa-pull-right" aria-hidden="true"></i></h4>
                            <div class="accordion-content">
                                <div class="row accord-content" style="width:100%;">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            {!! Form::textarea('purchase_note', null, array('id' => 'purchase_note','placeholder' => 'Purchase Note','class' => 'form-control')) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Show only if the loacal is agent --}}
                            @role(['loacal_agent'])
                            <h4>
                                <div class="checkbox">
                                    <label>
                                        <input required type="checkbox" name="status">I've read the <a href="#" target="_blank">cancellation policy</a>
                                    </label>
                                </div>
                            </h4>
                            @endrole
                        </div>
                        <input type="hidden" name="menu_order" value="">
                        <div class="col-md-12 padding-top-bottom-10">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary pull-left" name="draft">Save As Draft</button>
                            </div>
                        </div>
                        {{-- <button type="submit" class="btn btn-primary pull-right checkbeforesubmit" name="publish">Submit For Approval</button> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="template country form-group">
        <label for="country" class="country">Select Country:
            <br />
            <span class="remove_country remove_location"><i class="fa fa-times" aria-hidden="true"></i></span>
            <select name="location[]" class="country form-control">
                <option value="">Select a Country</option>
                @foreach(\App\Country::whereParent(0)->get() as $country )
                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                @endforeach
            </select>
            <span class="add_country add_location"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add another country</span>
        </label>
    </div>

    <div class="template city form-group" style="display:none;">
        <label for="city" class="city">Select City:
            <br />
            <span class="remove_city remove_location"><i class="fa fa-times" aria-hidden="true"></i></span>
            <select name="location[]" class="city form-control"></select>
            <span class="add_city add_location"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add another city</span>
        </label>
    </div>

    <div class="template area form-group" style="display:none;">
        <label for="area" class="area">Select Area:
            <br />
            <span class="remove_area remove_location"><i class="fa fa-times" aria-hidden="true"></i></span>
            <select name="location[]" class="area form-control"></select>
            <span class="add_area add_location"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add another area</span>
        </label>
    </div>

    {!! Html::script('dist/laravel-ckeditor/ckeditor.js') !!}
    {!! Html::script('dist/laravel-ckeditor/adapters/jquery.js') !!}

    <script type="text/javascript">
        jQuery(document).ready(function($){

/*
            var template_country = $('.template.form-group.country').clone(true,true).removeClass('template');
            var template_city = $('.template.form-group.city').clone(true,true).removeClass('template');
            var template_area = $('.template.form-group.area').clone(true,true).removeClass('template');
            var template_location = $("<div location='' class='location'></div>");

            var locationcontainer = $('.locations');

            var newcountry = template_country.show();
            var newlocation = template_location.clone(true,true).append(newcountry);

            locationcontainer.append(newlocation);

            $(document).off('change','.country').on('change', '.country',function(e)
            {
                e.preventDefault();
                e.stopImmediatePropagation();
                var locIndex = $(this).val();
                var location = $(this).closest('.location');

                if(!locIndex) return;

                location.attr('location', locIndex);
                $('.location').not(location).each(function(){
                    $(this).find('option').each(function(){
                        var self = $(this).closest('.location');
                        if($('.location[location='+$(this).val()+']').not(self).length){
                            $(this).prop('disabled',true);
                        }else{
                            $(this).prop('disabled',false);
                        }
                    });
                });

                var $city = $('.location[location='+locIndex+'] select.city');
                if(!$city.length){
                    var newcity = template_city.clone(true,true).show();
                    newcity.attr('country',$(this).val());

                    location.append(newcity);
                    $city = newcity.find('select');
                }
                var $area = $('.location[location='+locIndex+'] select.area');
                $city.attr('country',$(this).val());

                if(!this.value){
                    $city.find('option').remove().end();
                    $area.find('option').remove().end();
                    $('.location[location='+locIndex+'] .city').hide();
                    $('.location[location='+locIndex+'] .area').hide();
                }else {
                    $.get('/countries/' + this.value + '/cities.json', function (cities) {
                        cities = $.parseJSON(cities);
                        $city.find('option').remove().end();
                        $area.find('option').remove().end();
                        if(!cities.length){
                            $('.location[location='+locIndex+'] .area').hide();
                            $('.location[location='+locIndex+'] .city').hide();
                            return;
                        }
                        $city.append('<option value="">Select a city</option>');
                        $.each(cities, function (index, place) {
                            $city.append('<option value="' + place.id + '">' + place.name + '</option>');
                        });
                        $('.location[location='+locIndex+'] .city').show();
                        $('.location[location='+locIndex+'] .area').hide();
                    });
                }

            });

            $(document).off('change','.city').on('change', '.city',function(e)
            {
                e.preventDefault();
                e.stopImmediatePropagation();

                var location = $(this).closest('.location');
                var locIndex = location.attr('location');
                if(!locIndex) return;

                if(!this.value){
                    $(this).closest('.form-group').next('.form-group.area').remove();
                }else {
                    var $area = $(this).closest('.form-group').next('.form-group.area').find('select.area');

                    if(!$area.length){
                        var newarea = template_area.clone(true,true).show();
                        newarea.attr('city',$(this).val());

                        location.append(newarea);
                        $area = newarea.find('select');
                    }
                    $area.attr('city',$(this).val());

                    $.get('/countries/' + this.value + '/cities.json', function (cities) {
                        cities = $.parseJSON(cities);
                        $area.find('option').remove().end();
                        if(!cities.length){
                            $area.closest('.form-group.area').remove().end();
                            return;
                        }
                        $area.append('<option value="">Select area</option>');
                        $.each(cities, function (index, place) {
                            $area.append('<option value="' + place.id + '">' + place.name + '</option>');
                        });
                    });
                }
            });

            $(document).off('click','.add_country').on('click', '.add_country',function(e)
            {
                e.preventDefault();
                e.stopImmediatePropagation();
                var newcountry = template_country.clone(true,true).show();
                var newlocation = template_location.clone(true,true).append(newcountry);
                $('.location').each(function() {
                    if($(this).attr('location')) {
                        newcountry.find('select option[value=' + $(this).attr('location') + ']').prop('disabled',true);
                    }
                });
                newlocation.find('.remove_location').show();
                locationcontainer.append(newlocation);
            });

            $(document).off('click','.add_city').on('click', '.add_city',function(e)
            {
                e.preventDefault();
                e.stopImmediatePropagation();
                var newcity = $(this).closest('.form-group.city').clone(true,true).show();
                newcity.find('.remove_location').show();
                $(this).closest('.location').append(newcity);

                $('.location').each(function() {
                    if($(this).attr('location')) {
                        newcity.find('select option[value=' + $(this).attr('location') + ']').prop('disabled',true);
                    }
                });
            });

            $(document).off('click','.add_area').on('click', '.add_area',function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                var newarea = $(this).closest('.form-group.area').clone(true,true).show();
                newarea.find('.remove_location').show();
                $(this).closest('.location').append(newarea);

                $('.location').each(function() {
                    if($(this).attr('location')) {
                        newarea.find('select option[value=' + $(this).attr('location') + ']').prop('disabled',true);
                    }
                });
            });
*/
            $(document).off('click','.remove_location').on('click', '.remove_location',function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                if($(this).closest('.form-group').is('.area')){
                    $(this).closest('.form-group.area').remove().end();
                }else if($(this).closest('.form-group').is('.city')){
                    $(this).closest('.form-group.city').next('.form-group.area').remove().end();
                    $(this).closest('.form-group.city').remove().end();
                }else if($(this).closest('.form-group').is('.country')){
                    $(this).closest('.location').remove();
                }
            });


            $('#description').ckeditor();
            $('#purchase_note').ckeditor();

            $(document).off("click","#addmore_pricePP").on("click","#addmore_pricePP",function(){
                var clone = $(".pricePP").last().clone(true,true);
                var index = clone.attr("index");
                var newindex = parseInt(index)+1;

                clone.attr('index',newindex);
                clone.find('input').each(function(){
                    var name = $(this).attr("name");
                    var newname = name.substr(0,name.indexOf('['));
                    newname = newname+"["+newindex+"]";
                    newname = newname+name.substr(name.indexOf(']')+1);
                    $(this).attr("name",newname);
                });
                clone.insertAfter($(".pricePP").last());
            });

            var selecteddiv = $('#cat-selected');
            var unselecteddiv = $('#subcat-unselected');
            $(document).off('click','.main-cat').on('click','.main-cat',function(e){
                e.preventDefault();
                e.stopImmediatePropagation();

                $('.img-check.check').toggleClass("check");
                $(this).find('.img-check').toggleClass("check");
                var self = $(this);
                if($(this).find('.img-check').hasClass("check")) {
                    $.get('/categories/' + $(this).attr('cat') + '/subs.json', function (subs) {
                        subs = $.parseJSON(subs);
                        $('.sub-cat').remove().end();
                        if (!subs.length) {
                            return;
                        }

                        var item = self.clone(true,true).removeClass("main-cat").addClass("sub-cat bold");
                        if (!$('.sub-cat-selected[cat=' + self.attr("cat") + ']').length){
                            item.find('.img-check').removeClass("check");
                            item.find('input[type=checkbox]').prop('checked',false);
                        }
                        item.prependTo(unselecteddiv);

                        $.each(subs, function (index, sub) {
                            var checked = "";
                            if ($('.sub-cat-selected[cat=' + sub.id + ']').length){
                                checked = " check";
                            }
                            unselecteddiv.append("<div parent='"+self.attr("cat")+"' cat='" + sub.id + "' class='col-lg-12 sub-cat'>" +
                                "<label class='btn'>" +
                                "<img class='img-thumbnail img-check cat-image"+checked+"' src='" + sub.icon + "' alt='cat_name' />" +
                                "<input type='checkbox' value='" + sub.id + "' class='hidden' autocomplete='off'>" +
                                "<br />" + sub.name +
                                "</label></div>");
                        });
                    });
                }else{
                    $('.sub-cat').remove().end();
                }
            });

            $(document).off('click','.sub-cat-selected').on('click','.sub-cat-selected',function(e){
                e.preventDefault();
                e.stopImmediatePropagation();
                if(!$(this).attr("parent")){
                    if($(".sub-cat-selected[parent="+$(this).attr("cat")+"]").length){
                        return;
                    }
                }

                if($('.sub-cat[cat='+$(this).attr('cat')+']').length) {
                    $('.sub-cat[cat=' + $(this).attr('cat') + ']').trigger('click');
                }else{
                    $(this).remove().end();
                }
            });

            $(document).off('click','.sub-cat').on('click','.sub-cat',function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
                if(!$(this).attr("parent") && $(this).find('.img-check').hasClass("check")){
                    if($(".sub-cat-selected[parent="+$(this).attr("cat")+"]").length){
                        return;
                    }
                }


                $(this).find('.img-check').toggleClass("check");

                if($(this).find('.img-check').hasClass("check")) {
                    $(this).find('input[type=checkbox]').prop('checked',true);
                    var item = $(this).clone(true,true).removeClass('sub-cat').addClass('sub-cat-selected');
                    item.find('.img-check').removeClass("check");
                    item.find('input[type=checkbox]').prop('checked',true).attr('name','category[]');
                    item.appendTo(selecteddiv);
                    if(!$(".sub-cat[cat="+item.attr("parent")+"]").find(".img-check").hasClass("check")){
                        $(".sub-cat[cat="+item.attr("parent")+"]").trigger("click");
                    }
                }else{
                    $(this).find('input[type=checkbox]').prop('checked',false);
                    $('.sub-cat-selected[cat='+$(this).attr('cat')+']').remove().end();
                }

            });

            $(".accordion-content input[type=text],.accordion-content input[type=number]").change(function(){
                var index = $(this).attr("index");

                if($(this).val() !== ""){
                    $(".accordion-toggle[index="+index+"] span").html($(this).val());
                    $(".accordion-toggle[index="+index+"] .add_experience_row_success").removeClass("unchecked");
                }else{
                    $(".accordion-toggle[index="+index+"] span").html("");
                    $(".accordion-toggle[index="+index+"] .add_experience_row_success").addClass("unchecked");
                }
            });
            $(".accordion-content input[type=checkbox]").change(function(){
                var index = $(this).attr("index");
                if($(this).prop("checked")){
                    $(".accordion-toggle[index="+index+"] span").html("Yes");
                }else{
                    $(".accordion-toggle[index="+index+"] span").html("No");
                }
            });
            $(".accordion-content input").keydown(function(event){
                if(event.key == "Enter"){
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    var index = $(this).attr("index");
                    $(".accordion-toggle[index="+(parseInt(index)+1)+"]").trigger("click");
                    $(".form-control[index="+(parseInt(index)+1)+"]").focus();
                }
            });
            /*$(".checkbeforesubmit").click(function(e){
                if($(".unchecked").length){
                    e.preventDefault();
                    e.stopImmediatePropagation();
                }
            });
            */
            $(".accordion").find(".accordion-toggle").click(function() {
                $(this).next().slideToggle("600");
                $(".accordion-content").not($(this).next()).slideUp("600");
            });
            $(".accordion-toggle").on("click", function() {
                $(this).toggleClass("active").siblings().removeClass("active");
            });
        });



    </script>





@endsection