
<div class="list-comments">
    @if(count($post->comments) > 0)

        @foreach($post->comments as $comment)

            @include("events.partials.singleComment")

        @endforeach

    @endif

</div>