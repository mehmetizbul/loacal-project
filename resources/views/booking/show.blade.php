@extends('layouts.app')

@section('content')
    <div class="row" style="padding: 40px;" >
        <div class="col-md-6">
            <h1>Booking Details</h1>
            @include('booking.partials.form-booking',['oBooking'])
        </div>
        <div class="col-md-1">
        </div>
        <div class="col-md-4">
            <h1>{{ $thread->subject }}</h1>
            <div id="messages" class="padding-top-bottom-10">
                @foreach($thread->messages as $message)
                        @include('booking.partials.messages',[
                            'message','latest'
                        ])
                    @endforeach
            </div>
            @include('booking.partials.form-message')
        </div>
        <div class="col-md-1">
        </div>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function($){
            var latest ='{{ $latest }}';
            setInterval(function(){
                $.ajax({
                    url: '/bookingrequest/messages/{{ $oBooking->id }}',
                    type: 'get',
                    data: {
                        booking:{!! json_encode($thread->booking_request()) !!},
                    },
                    success: function(response) {
                        response = $.parseJSON(response);
                        var msg = response.view;
                        var reload = response.reload;
                        if(reload) location.reload();
                        latest = $($(msg)[$(msg).length-1]).attr("last-media");

                        if(latest === '' || !$(".last-media").attr("last-media") || latest != $(".last-media").attr("last-media")) {
                            $("#messages").html(msg);
                            $("#messages").animate({scrollTop: $('#messages').prop("scrollHeight")});
                        }
                    }
                });
            },1000);
        });
    </script>
@stop

