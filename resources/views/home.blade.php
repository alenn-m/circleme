@extends("layouts.main")

@section("content")

    @if(Session::has("errorMessage"))
        <div class="row">
            <div class="col-xs-12">
                <div class="alert alert-danger" style="text-align: center;">
                    {{ Session::get("errorMessage") }}
                </div>
            </div>
        </div>
    @endif

    @if(isset($title))
        <div class="row">
            <div class="col-xs-12">
                <h3>{{ $title }}</h3>
            </div>
        </div>
    @endif

    @if(!isset($title))

        <div class="row">
            <div class="col-xs-12">
                <div id="cal1"></div>
            </div>
        </div>

    @endif

    @include("layouts.partials.loadEvents")


@endsection