<!--
/**
 * Created by PhpStorm.
 * User: Bugra
 * Date: 27.04.2017
 * Time: 23:29
 */
-->
@extends('layouts.app')
@section('content')

    <div class='container-fluid centered'>

        <!-- TODO need to add js to toggle this div and also we need to somehow link experiences to this map as pinpoints. -->
        <!-- TODO Add more margin to top, make borders -->
        <div id="map-container" style='max-width: 100%;'>
            <iframe style="width: 100%;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13018.521767146654!2d33.27704071998595!3d35.33999747354058!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xf550e072c0bf7ebe!2sLemar+Cineplex!5e0!3m2!1sen!2sus!4v1491478124269" width="1200" height="250" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>

        <!-- TODO add the filters section here -->

        @for ($y = 0; $y < 4; $y++)
        <div class="row">
            @for ($i = 0; $i < 4; $i++)
            <div class="col-lg-4 col-md-12 col-sm-12 no-padding" style="margin-top: 10px;">
                <div style='width: 90%; margin-left: auto; margin-right: auto;'>
                    <figure class="wp - caption"> <img style="width: 100%;" src="http://placehold.it/400x200&text=Experience_$i" alt="">
                        <figcaption class="wp-caption-text-bl"> Loacal Name </figcaption >
                        <figcaption class="wp-caption-text-br"> from £15.90 </figcaption >
                    </figure >
                </div>
            </div>
            @endfor
        </div>
        @endfor
        <!--
         TODO Need to load more results with the JS below this section when user clicks on the button
         TODO need to clean up the inline css rules
        -->
        <div class="col-md-12 text-center" style='margin-top: 30px;'>
            <button type='button' class='btn btn-primary'>Load More</button>
        </div>
    </div>

    
@endsection
