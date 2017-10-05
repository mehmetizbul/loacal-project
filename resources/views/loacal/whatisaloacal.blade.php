@extends('loacal.loacalcommon', ['title' => 'What is a Loacal?'])
@section('loacalContent')


    <div class="container-fluid">
        <h4 class="col-md-offset-1 col-xs-offset-1">Loacal.com concept has two sides to explore :</h4>
        <div class="col-md-6 col-xs-12 loacal-blue">
            <div class="col-md-12 col-xs-12 no-padding">
                <h3>1- Be a Traveler - Experience with Loacals</h3>
                <ul style="font-size: 18px;">
                    <li><strong>Cheaper</strong> than private guide tours</li>
                    <li>Tailored to your specific <strong>interests</strong></li>
                    <li>No rigorous plans, the experience is fully <strong>customizable</strong></li>
                    <li>Less formal and <strong>more friendly</strong> than a tour guide</li>
                    <li>Option to <strong>choose</strong> your loacal <strong>friend</strong></li>
                    <li>Explore the <strong>new culture with a Loacal</strong></li>
                    <li>Flexibility to <strong>choose the language</strong> (depending on availability)</li>
                </ul>
            </div>
            <div class="col-md-12 col-xs-12 centered no-padding">
                <img class="img-responsive centered" style="width: 30%;" src="{{ asset('images/general/traveler-medium-right.png') }}">
            </div>
        </div>
        <div class="col-md-6 col-xs-12 loacal-blue">
            <div class="col-md-12  col-xs-12 no-padding">
                <h3>2- Be a Loacal - Share your culture</h3>
                <ul style="font-size: 18px;">
                    <li><strong>Make some money</strong> doing what you love</li>
                    <li><strong>Meet with new people</strong> who has similar interests</li>
                    <li>Enjoy accompany of friends with <strong>similar interests</strong></li>
                    <li>Learn <strong>new cultures</strong></li>
                    <li>Potentially <strong>utilise your free time</strong> for something useful to both sites</li>
                    <li>For guides, <strong>no strict plans</strong> or nervous moments with travelers</li>
                </ul>
            </div>

            <div class="col-md-12 col-xs-12 centered no-padding">
                <img class="img-responsive centered" style="width: 23%;" src="{{ asset('images/general/loacal-medium-left.png') }}">
            </div>
        </div>



        <div class="col-md-12 col-xs-12">
            <h3 class="loacal-blue centered">Now, regardless of being a traveler or Loacal click to <strong><a href="/register">My Account</a></strong> and create an account.</h3>
            <h2 class="centered">Pause your life and enjoy new experiences!</h2>
        </div>
    </div>
@endsection