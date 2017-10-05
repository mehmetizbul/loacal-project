<!--
/**
 * Created by PhpStorm.
 * User: Bugra
 * Date: 23.04.2017
 * Time: 03:52
 */
-->
@extends("layouts.app")

@section("content")

    <div id="my-account-header" class="container-fluid">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        @if (session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif
        <div class="container">
            {{--@if($auth->profile()->logo)--}}
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-center">
                    <a href="#">
                        @if(isset($auth->profile()->logo) && $auth->profile()->logo)
                            <img id="profile_picture" src="/{{ $auth->profile()->logo }}">
                        @else
                            <img id="profile_picture" src="http://placehold.it/300x200">
                        @endif
                    </a>
                </div>
            {{--@endif--}}
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 center-on-mobile">
                <h3 id="" class="mt10">Hi {{ $auth->name }}</h3>
                <br>
                <div id="notification"></div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 text-center">
                @if(!\Entrust::hasRole(['loacal_person','loacal_agent']))
                    <h4 class="mt45">Do you want to offer an experience?</h4>
                    <a href="/tour-guide-registration"><button type="button" class="btn btn-primary">Become a Loacal</button></a>
                @else
                    {{-- We are not going to show anything yet if the user is already a loacal --}}
                    {{--<a href="{{ route('experience.create') }}"><button type="button" class="btn btn-primary">Submit an Experience</button></a>--}}
                @endif
            </div>
        </div>

        <div class="row navbar-default mt10">
            <div id="my-account-menu" class="container text-center">
                <div class="pull-left mt10">
                    <div class="no-padding inline-block account-menuitem">
                        <a href="/my-account"><button type="button" class="btn btn-primary">My Account</button></a>
                    </div>
                    <div class="no-padding inline-block account-menuitem">
                        <a href="/my-account/edit"><button type="button" class="btn btn-primary">Edit Account Details</button></a>
                    </div>
                    {{-- We are merging edit profile + edit account details --}}
                    {{--<div class="no-padding inline-block account-menuitem">--}}
                        {{--<a href="/my-account/"><button type="button" class="btn btn-primary">Edit Public Profile</button></a>--}}
                    {{--</div>--}}
                    {{--<div class="no-padding inline-block account-menuitem">--}}
                        {{--<a href="/my-account/"><button type="button" class="btn btn-primary">Message Box</button></a>--}}
                    {{--</div>--}}
                </div>

                <div class="col-sm-3"></div>
                <div class="col-sm-3"></div>
                <div class="pull-right mt10">
                    @role(['super_admin','admin', 'loacal_agent', 'loacal_person',])
                        <div class="no-padding inline-block account-menuitem">
                            {{--<li class="btn btn-primary">--}}
                                {{--<a style="color: white;" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">--}}
                                    {{--Loacal Section--}}
                                {{--</a>--}}
                            {{--</li>--}}
                            <div class="no-padding inline-block account-menuitem">
                                <a href="/profile/{{ $auth->slug }}"><button type="button" class="btn btn-primary">My Profile</button></a>
                            </div>
                            <div class="no-padding inline-block account-menuitem">
                                <a href="/my-account/my-experiences"><button type="button" class="btn btn-primary">My Experiences</button></a>
                            </div>
                            <div class="no-padding inline-block account-menuitem">
                                <a href="/experience/create"><button type="button" class="btn btn-primary">Add An Experience</button></a>
                            </div>
                            <div class="no-padding inline-block account-menuitem">
                                <a href="{{ route('booking') }}"><button type="button" class="btn btn-primary">Booking Requests
                                        @include('booking.unread-count')
                                    </button></a>
                            </div>
                        </div>
                    @endrole
                </div>
            </div>
        </div>

    </div>
    @yield("accountheader")
@endsection
