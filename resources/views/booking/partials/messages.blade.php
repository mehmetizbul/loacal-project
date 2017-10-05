@if(isset($message))
    <?php $id=$message->id; $class = $message->user_id == $message->thread()->first()->creator()->id ? "creator-message" : "vendor-message"; ?>

    @if($id == $latest)
        <div class="media last-media {{ $class }}" last-media="{{ $latest }}">
            @else
                <div class="media {{ $class }}">
                    @endif
                    <div class="media-body">
                        <h5 class="media-heading">{{ $message->user->name }}</h5>
                        <p>{!! nl2br(e($message->body)) !!}</p>
                        <div class="text-muted">
                            <small>Posted {{ $message->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
                @elseif(isset($messages))
                    @foreach($messages as $key=>$message)
                        <?php $id=$message->id; $class = $message->user_id == $message->thread()->first()->creator()->id ? "creator-message" : "vendor-message"; ?>
                        @if($id == $latest)
                            <div class="media last-media {{ $class }}" last-media="{{ $latest }}">
                        @else
                            <div class="media {{ $class }}">
                        @endif
                                <div class="media-body">
                                    <h5 class="media-heading">{{ $message->user->name }}</h5>
                                    <p>{!! nl2br(e($message->body)) !!}</p>
                                    <div class="text-muted">
                                        <small>Posted {{ $message->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
        @endforeach
    @endif