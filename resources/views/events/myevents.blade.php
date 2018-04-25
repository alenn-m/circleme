@extends("layouts.main")

@section("content")


    <div class="row">
        <div class="col-xs-12">
            <h3>{{ trans("front.myEvents") }}</h3>
        </div>
    </div>

    @include("layouts.partials.loadEvents")


@endsection