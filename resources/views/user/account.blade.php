@extends('user.accountcommon')

@section('accountheader')
    <div id="promotion" class="row container-fluid">
        <div class="container">
        </div>
    </div>

    <div id="overview" class="container">
        <div class="row-fluid text-center">
            <h2>My Upcoming Bookings</h2>
            <ul class="bxslider" id="bxslider-upcomingExperiences">
                <?php
                for($i=1;$i<=10;$i++){
                    print("<li>
                        <div class=\"grid\">

                            <figure class=\"wp-caption\"> <img src=\"http://placehold.it/600x400&text=Experience_$i\" alt=\"\">
                                <figcaption class=\"wp-caption-text-bl\">Loacal Name</figcaption>
                                <figcaption class=\"wp-caption-text-br\">from £15.90</figcaption>
                            </figure>
                        </div>
                    </li>");
                }
                ?>
            </ul>
        </div>

        <div class="row-fluid text-center">
            <h2>My Past Bookings</h2>
            <ul class="bxslider" id="bxslider-pastExperiences">

                <?php
                for($i=1;$i<=10;$i++){
                    print("<li>
                            <div class=\"grid\">

                                <figure class=\"wp-caption\"> <img src=\"http://placehold.it/600x400&text=Experience_$i\" alt=\"\">
                                    <figcaption class=\"wp-caption-text-bl\">Loacal Name</figcaption>
                                    <figcaption class=\"wp-caption-text-br\">from £15.90</figcaption>
                                </figure>
                            </div>
                        </li>");
                }
                ?>
            </ul>
        </div>
    </div>

    <script>
        $(document).ready(function ($) {
            $('#bxslider-pastExperiences, #bxslider-upcomingExperiences').bxSlider({
                minSlides: 1
                , maxSlides: 5
                , slideWidth: 400
                , slideMargin: 10
                , moveSlides: 1
                , adaptiveHeight: true
            });
        });
    </script>

@endsection