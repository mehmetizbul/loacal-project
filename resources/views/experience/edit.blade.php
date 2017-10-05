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
    <div class="row">

        <div class="container mt40">
            <div class="panel panel-default">
                <div class="pull-right" style="top: 30px; right: 15px; position: relative;">
                    <a href="/my-account" class="btn btn-primary">My Account</a>
                </div>
                <div class="panel-heading">

                    @if(!isset($view))
                        <h1 class="loacal-blue" style="font-size: 30px;">Add/Edit Experience</h1>
                    @else
                        <a class="pull-left" href="{{ URL::previous() }}">
                            <button type="button" class="btn btn-default">Go Back</button>
                        </a><br/><br/>
                        <h1 class="loacal-blue" style="font-size: 30px;">View Experience</h1>
                    @endif


                </div>
                <div class="panel-body">
                    @if(!isset($view))
                        @if(isset($oExp))
                            {!! Form::model($oExp, ['method' => 'PATCH','route' => ['experience.update', $oExp->id]]) !!}
                        @else
                            <form method="POST" action="{{ route('experience.store') }}">
                                <input type="hidden" name="user_id" value="{{ $auth->id }}">
                                <input type="hidden" name="slug" value="">
                        @endif
                                {{ csrf_field() }}
                    @else
                        <div class="disable-container"></div>
                    @endif
                                <div class="accordion container">
                                    <?php $index=0;?>
                                    @include('experience.accordion_partials.title',['index'=>++$index,'oExp','view'])
                                    @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif

                                    @include('experience.accordion_partials.location',['index'=>++$index,'oExp','view'])
                                    @if ($errors->has('location.country'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('location.country') }}</strong>
                                    </span>
                                    @endif
                                    @if ($errors->has('location.city'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('location.city') }}</strong>
                                    </span>
                                    @endif

                                    @include('experience.accordion_partials.description',['index'=>++$index,'oExp','view'])
                                    @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif

                                    @include('experience.accordion_partials.child',['index'=>++$index,'oExp','view'])
                                    @include('experience.accordion_partials.disabled',['index'=>++$index,'oExp','view'])
                                    @include('experience.accordion_partials.categories',['index'=>++$index,'oExp','view'])

                                    @if ($errors->has('category'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('category') }}</strong>
                                    </span>
                                    @endif

                                    @include('experience.accordion_partials.duration',['index'=>++$index,'oExp','view'])
                                    @if ($errors->has('duration'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('duration') }}</strong>
                                    </span>
                                    @endif

                                    @include('experience.accordion_partials.price',['index'=>++$index,'oExp','view'])
                                    @if ($errors->has('prices.*.min'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('prices.*.min') }}</strong>
                                    </span>
                                    @endif
                                    @if ($errors->has('prices.*.max'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('prices.*.max') }}</strong>
                                    </span>
                                    @endif
                                    @if ($errors->has('prices.*.price'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('prices.*.price') }}</strong>
                                    </span>
                                    @endif

                                    @include('experience.accordion_partials.extras',['index'=>++$index,'oExp','view'])


                                    @include('experience.accordion_partials.availability',['index'=>++$index,'oExp','view'])
                                    @if ($errors->has('availability'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('availability') }}</strong>
                                    </span>
                                    @endif


                                    @include('experience.accordion_partials.transportation',['index'=>++$index,'oExp','view'])
                                    @include('experience.accordion_partials.accommodation',['index'=>++$index,'oExp','view'])
                                    @include('experience.accordion_partials.language',['index'=>++$index,'oExp','view'])

                                    @if ($errors->has('language'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('language') }}</strong>
                                    </span>
                                    @endif

                                    @include('experience.accordion_partials.note',['index'=>++$index,'oExp','view'])

                                    @role(['loacal_agent'])
                                    {{-- Show only if the loacal is agent --}}
                                    @include('experience.accordion_partials.policy',['index'=>++$index,'oExp','view'])
                                    @endrole

                                    @include('experience.accordion_partials.experienceowner',['index'=>++$index,'oExp','view'])
                                    @include('experience.accordion_partials.our_policy',['index'=>++$index,'oExp','view'])



                                </div>
                                @if(!isset($view))
                                    <input type="hidden" name="menu_order" value="">

                                    <div class="col-md-12 padding-top-bottom-10">
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary pull-left" name="draft">Save As
                                                Draft
                                            </button>
                                        </div>
                                        @if(isset($oExp))
                                            <input type="hidden" name="id" value="{{ $oExp->id }}">
                                            <div class="center-block col-md-4">
                                                @role(['super_admin','admin'])
                                                <button type="submit" class="btn btn-success inline-block"
                                                        name="publish_admin">Publish
                                                </button>
                                                @endrole
                                                <button type="submit" class="btn btn-primary inline-block"
                                                        name="publish">Send For Approval
                                                </button>
                                            </div>

                                            <div class="col-md-4">
                                                <a id="gotoimages" class="pull-right"
                                                   href="/experience/{{ $oExp->id }}/edit/images">
                                                    <button type="button" class="btn btn-primary">Manage Images</button>
                                                </a>
                                            </div>
                                        @endif

                                    </div>
                            {!! Form::close() !!}
                        @endif
                </div>
            </div>
        </div>
    </div>
    {!! Html::script('dist/laravel-ckeditor/ckeditor.js') !!}
    {!! Html::script('dist/laravel-ckeditor/adapters/jquery.js') !!}

    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            @if(isset($view))
                $(".accordion-toggle").addClass("active");
            $(".accordion-content").show();
            @endif
            $(".accordion-content input[type=text],.accordion-content input[type=number]").keyup(function () {
                $("#gotoimages").attr("href", "");
                $("#gotoimages button").prop("disabled", true);
                var index = $(this).attr("index");
                if ($(this).val() !== "") {
                    $(".accordion-toggle[index=" + index + "] span").html($(this).val());
                    $(".accordion-toggle[index=" + index + "] .add_experience_row_success").removeClass("unchecked");
                } else {
                    $(".accordion-toggle[index=" + index + "] span").html("");
                    $(".accordion-toggle[index=" + index + "] .add_experience_row_success").addClass("unchecked");
                }

            });
            $(".accordion-content input[type=checkbox]").change(function () {
                var index = $(this).attr("index");
                if ($(this).prop("checked")) {
                    $(".accordion-toggle[index=" + index + "] span").html("Yes");
                } else {
                    $(".accordion-toggle[index=" + index + "] span").html("No");
                }
            });
            $(".accordion-content input").keydown(function (event) {
                if (event.key == "Enter") {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    var index = $(this).attr("index");
                    $(".accordion-toggle[index=" + (parseInt(index) + 1) + "]").trigger("click");
                    $(".form-control[index=" + (parseInt(index) + 1) + "]").focus();
                }
            });
            $(".accordion").find(".accordion-toggle").click(function () {
                $(this).next().slideToggle("600");
                $(".accordion-content").not($(this).next()).slideUp("600");
            });
            $(".accordion-toggle").on("click", function () {
                $(this).toggleClass("active").siblings().removeClass("active");
            });
        });
    </script>
@endsection