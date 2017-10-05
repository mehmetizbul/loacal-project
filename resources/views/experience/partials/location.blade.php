<div location="{{ $key }}" class='location'>
    <?php
        $ret = ['key'];
        if(isset($country)){
            $ret[] = 'country';
        }

        if(isset($disable)){
            $ret[] = 'disable';
        }
    ?>
    @include('experience.partials.country',$ret)
        <?php $c =0;?>

    @if(isset($cities))
        @foreach($cities as $city=>$areas)
            @include('experience.partials.city',['country','city','key'=>$c])
            @if(isset($areas))
                    <?php $a =0;?>
                @foreach($areas as $area)
                    @include('experience.partials.area',['country','city','area','key'=>$a])
                            <?php $a++; ?>

                        @endforeach
            @endif
                <?php $c++; ?>
            @endforeach
    @endif
</div>