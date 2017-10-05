@extends('layouts.app')

@section('content')

    <div class='container-fluid centered shop-page'>
        @include('experience.partials.filter')

        <div class="col-md-12 col-xs-12 no-padding">
            <div class="col-md-12 col-xs-12 no-padding"><strong class="center-block result-count">Showing {{ $aExp->total() }} experiences</strong>
<?php $lastpage = $aExp->lastPage();?>
            </div>
            <div class="col-xs-12 no-padding infinite-scroll">
                @foreach ($aExp as $Exp)
                    <div class="shop-experience-item">
                        <div id="figure-container">
                            <a href="/experience/{{ $Exp->slug }}">
                                @if($Exp->thumbnail() && \Illuminate\Support\Facades\File::exists(utf8_decode($Exp->thumbnail()->getAttribute('image_file'))))
                                    <figure class="text-center wp-caption"><img src="/{{ utf8_decode($Exp->thumbnail()->getAttribute('image_file')) }}" alt="">
                                        @else
                                            <figure class="wp-caption-explore-only text-center wp-caption">
                                                <img src="http://placehold.it/335x250&text=Experience" alt="">
                                                @endif
                                                <figcaption class="wp-caption-text-tl">{{ $Exp->title }}</figcaption >
                                                {{-- todo output as much as stars depending on the users rating --}}
                                                {{--<figcaption class="wp-caption-text-bl">by--}}
                                                    {{--<b>{{ $Exp->admin()->getAttribute('name') }}--}}
                                                        {{--<i class="fa fa-star experience_box_rating" aria-hidden="true"></i>--}}
                                                        {{--<i class="fa fa-star experience_box_rating" aria-hidden="true"></i>--}}
                                                        {{--<i class="fa fa-star experience_box_rating" aria-hidden="true"></i>--}}
                                                        {{--<i class="fa fa-star experience_box_rating" aria-hidden="true"></i>--}}
                                                        {{--<i class="fa fa-star experience_box_rating" aria-hidden="true"></i>--}}
                                                    {{--</b>--}}
                                                {{--</figcaption >--}}
                                                <figcaption class="wp-caption-text-bl">
                                                    @foreach($Exp->countries() as $country=>$cities)
                                                            @foreach($cities as $city=>$areas)
                                                                @if(count($cities) < 2 && count($Exp->countries()) < 2)
                                                                {{ \App\Country::find($city)->name }},

                                                                @endif
                                                            @endforeach
                                                            {{ \App\Country::find($country)->name }}
                                                    @endforeach
                                                </figcaption >
                                                <figcaption class="wp-caption-text-br">{{ Lang::get('experience.price_from') }} € {{ $Exp->display_price() }}</figcaption >
                                            </figure>
                            </a>
                        </div>
                    </div>
                @endforeach
                {{ $aExp->links() }}
            </div>
        </div>
    </div>

    {{-- Big Map - Countries --}}
    <script type="text/javascript" src="https://www.google.com/jsapi?.js"></script>

    <script src="../dist/jquery/jscroll.js"></script>

    <script type="text/javascript">
        var last = 1;
        jQuery(document).ready(function ($) {
            $('ul.pagination').hide();
            $('.infinite-scroll').jscroll({
                autoTrigger: true,
                padding: 0,
                nextSelector: '.pagination li.active + li a',
                contentSelector: 'div.infinite-scroll',
                callback: function() {
                    $('ul.pagination').remove();
                    ++last;
                    if(last>={{ $lastpage }}){
                        $('.infinite-scroll').jscroll.destroy();
                    }
                }
            });
        });


    </script>


@endsection
