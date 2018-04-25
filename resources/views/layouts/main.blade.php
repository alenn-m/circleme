@include('js-localization::head')

<!doctype html>
<html lang="en">
<head>

    @include("layouts.partials.head")

    @yield("meta")

</head>
<body ondrop="return false;">

    @include("layouts.partials.top")

    @include("layouts.partials.categories")

    <div class="container">

        @if(Config::get("settings.ad1"))
            <div class="row">
                <div class="col-xs-12">
                    {!! Config::get("settings.ad1") !!}
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-9 col-xs-12">
                @yield("content")
            </div>

            <div class="col-md-3 col-xs-12">
                <div class="white-box" style="width: 100%;margin-top:0;">
                    <h5>{{ trans("front.popularEvents") }}</h5>
                    <br/>

                    @if(Config::get("settings.ad2"))
                        <div class="row">
                            <div class="col-xs-12">
                                {!! Config::get("settings.ad2") !!}
                            </div>
                        </div>
                    @endif

                    <br/>

                    @if(isset($events))
                        @foreach($events as $event)
                            <a href="{{ URL::action('EventsController@show', ["id" => $event->id, "slug" => $event->slug]) }}">
                                @if($event->getImage())
                                    {!! HTML::image($event->getImage(), $event->name, ["width" => "100%"]) !!}
                                @endif
                                <h6>{{ $event->title }}</h6>
                            </a>
                            <hr/>
                        @endforeach
                    @endif
                </div>

                @include("layouts.partials.footer")
            </div>
        </div>

    </div>




    {!! Minify::javascript(["/js/bootstrap.min.js", "/js/salvattore.js"]) !!}

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

</body>
</html>