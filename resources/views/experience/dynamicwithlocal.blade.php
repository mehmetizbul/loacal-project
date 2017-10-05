<ul class="bxslider" id="bxslider-withalocal">
    @foreach ($loacalExperiences as $oTopExperience)
    <li class="laocal-slider-image-item">
        <a href="/experience/{{ $oTopExperience->slug }}">
            <div class="grid">
                @if($oTopExperience->thumbnail() && \Illuminate\Support\Facades\File::exists(utf8_decode($oTopExperience->thumbnail()->getAttribute('image_file'))))
                <figure class="text-center wp-caption"><img src="/{{utf8_decode($oTopExperience->thumbnail()->getAttribute('image_file'))}}" alt=""> @else
                    <figure class="wp-caption"> <img src="http://placehold.it/600x400&text=Experience_$i" alt=""> @endif
                        <figcaption class="wp-caption-text-tl">{{ $oTopExperience->title }}</figcaption>
                        {{-- showing location of the experience instead of the loacal name --}}
                        <figcaption class="wp-caption-text-bl">
                            @foreach($oTopExperience->countries() as $country=>$cities)
                            <li>
                                @foreach($cities as $city=>$areas) @if(count($cities)
                                < 2 && count($oTopExperience->countries())
                                < 2) {{ \App\Country::find($city)->name }}, @endif @endforeach {{ \App\Country::find($country)->name }}
                            </li>
                            @endforeach
                        </figcaption>
                        <figcaption class="wp-caption-text-br">from £{{ $oTopExperience->display_price() }}</figcaption>
                    </figure>
            </div>
        </a>
    </li>
    @endforeach
</ul>