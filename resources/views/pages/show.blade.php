@extends("layouts.main")

@section("content")

    <div class="white-box" style="margin-top: 0;">
        <h2 style="margin-top: 0;"><small>{{ $page->title }}</small></h2>
        <br/>
        {!! $page->body !!}
    </div>


@endsection