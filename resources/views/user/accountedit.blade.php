<!--
/**
 * Created by PhpStorm.
 * User: bugra
 * Date: 24.04.17
 * Time: 09:57
 */
-->
@extends('user.accountcommon')

@section('accountheader')

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::model($auth, ['files'=>true,'method' => 'PATCH','route' => ['users.update', $auth->id]]) !!}
    <div class="container mt20">
        <div class="col-md-3 no-padding" id="edit-account-sidemenu">
            <div class="fixedElement" style="max-width: 235px;">
                <a type="button" class="btn btn-primary col-md-12 mt10 scroll" target="generalInfo">General Info</a>
                <a type="button" class="btn btn-primary col-md-12 mt10 scroll" target="contactDetails">Contact Details</a>
                <a type="button" class="btn btn-primary col-md-12 mt10 scroll" target="social">Social</a>
                <a type="button" class="btn btn-primary col-md-12 mt10 scroll" target="badges">Badges</a>
            </div>
        </div>
        <div class="col-md-9 col-xs-12 no-padding">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h2 id="generalInfo" style="margin-top: 7px;">General Info</h2>
            </div>
            {{-- General Info --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Name:</strong>
                    {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Url Name:</strong>
                    {!! Form::text('slug', null, array('placeholder' => 'Url Name','class' => 'form-control')) !!}
                    <span style="opacity: 0.5;"><em>Example: loacal.com/profile/charlie_chaplin</em></span>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                {{-- Todo link the following to the db --}}
                <div class="form-group">
                    <strong>Languages:</strong>
                    <div clas="col-md-12">
                    <select class="selectpicker" data-width="100%" title="Choose the languages you know" multiple>
                        <option>English</option>
                        <option>Turkish</option>
                        <option>Greek</option>
                    </select>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong class="block">Gender</strong>
                    <label class="radio-inline"><input type="radio" name="gender">Male</label>
                    <label class="radio-inline"><input type="radio" name="gender">Female</label>
                    <label class="radio-inline"><input type="radio" name="gender">Prefer Not To Say</label>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Email:</strong>
                    {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Password:</strong>
                    {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Confirm Password:</strong>
                    {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}
                </div>
            </div>
            {{-- Contact Details --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h2 id="contactDetails">Contact Details</h2>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Phone Number:</strong>
                    <input placeholder="Phone" name="" type="text" value="" class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Birthday:</strong>
                    <div id="birthday">
                        <div class="input-group date">
                            <input type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Address:</strong>
                    <textarea class="form-control" rows="2" id="address"></textarea>
                </div>
            </div>
            {{-- Social --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h2 id="social">Social</h2>
            </div>
            {{-- How are we going to these socials ?  --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Facebook</strong>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Twitter</strong>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Logo:</strong>
                    {!! Form::file('logo') !!}
                </div>
            </div>

            {{-- Badges --}}
            <div class="col-xs-12 col-sm-12 col-md-12">
                <h2 id="badges">Badges</h2>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Roles:</strong>
                    <ul>
                        @foreach($auth->roles as $oRole)
                            <li>{{ $oRole->display_name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6">
                <div class="form-group">
                    <strong>Certificates:</strong>
                    <ul>
                        @foreach($auth->certificates() as $oCert)
                            <li>{{ $oCert->title }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <input type="hidden" name="selfedit" value="1">
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button style="width: 110px;" type="submit" class="btn btn-primary">Save</button>
        </div>
    </div>
    {!! Form::close() !!}


    <style>
        .fixedElement {
            background-color: #c0c0c0;
            position:fixed;
            top:0;
            width:100%;
            z-index:100;
        }
    </style>

    <script>
        jQuery(document).ready(function ($) {

            $('.scroll').click(function() {
                $('body').animate({
                    scrollTop: eval($('#' + $(this).attr('target')).offset().top - 70)
                }, 1000);
            });

            $(window).scroll(function(e){
                var $el = $('.fixedElement');
                var isPositionFixed = ($el.css('position') == 'fixed');
                if ($(this).scrollTop() > 200 && !isPositionFixed){
                    $('.fixedElement').css({'position': 'fixed', 'top': '50px'});
                }
                if ($(this).scrollTop() < 200 && isPositionFixed)
                {
                    $('.fixedElement').css({'position': 'static', 'top': '0px'});
                }
            });

            $('#birthday .input-group.date').datepicker({
                autoclose: true,
                format: 'dd/mm/yyyy',
                weekStart: 1
            });
        });
    </script>
@endsection