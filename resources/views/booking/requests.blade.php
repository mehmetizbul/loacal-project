@extends('user.accountcommon')

@section('accountheader')
    @include('booking.partials.flash')
    @each('booking.partials.thread', $threads, 'thread', 'booking.partials.no-threads')
@endsection