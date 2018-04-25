@extends("layouts.wide")

@section("content")

{!! Minify::javascript(["/js/masonry.js", "/js/imagesloaded.js"]) !!}

<div class="event-basic-info">
    <h4 style="display:inline-block">
        {{ $event->title }}
    </h4>

    <div class="pull-right">
        <a style="margin-top:5px;" class="btn btn-primary" href="{{ URL::action('EventsController@show', $event->id) }}">{{ trans("front.goBack") }}</a>
    </div>
</div>

<br/>

<div class="grid">
    @foreach($images as $image)
        <div class="image-selector grid-sizer">
            <a href="{{ URL::action('ImagesController@show', $image->id) }}">
                {!! HTML::image($image->getImage(), "Image") !!}
            </a>
        </div>
    @endforeach
</div>

<script>
    $(document).ready(function(){

        var $grid = $('.grid').masonry({
            itemSelector: '.image-selector',
            columnWidth: '.grid-sizer',
            percentPosition: true
        });

        $grid.imagesLoaded().progress( function() {
            $grid.masonry('layout');
        });
    });
</script>

@endsection