@extends("admin.layouts.main")

@section("content")

    <div class="row">
        <div class="col-xs-12">
            <h2 class="top-heading">{{ trans("admin.pages") }}</h2>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-xs-12">
            <a href="{{ URL::action('Admin\PagesController@create') }}" class="btn btn-primary btn-sm">{{ trans("admin.newPage") }}</a>
            @if(count(App\Http\Models\Page::onlyTrashed()->get()) > 0)
                <a href="{{ URL::action('Admin\PagesController@trash') }}" class="btn btn-danger btn-sm pull-right"><i class="fa fa-trash-o"></i> {{ trans("admin.trash") }}</a>
            @endif
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-striped table-hover table-condensed">
                <tr>
                    <th>{{ trans("admin.shortTitle") }}</th>
                    <th>{{ trans("admin.title") }}</th>
                    <th>{{ trans("admin.created") }}</th>
                    <th></th>
                </tr>

                @if(count($pages) > 0)
                    @foreach($pages as $page)
                        <tr>
                            <td><a target="_blank" href="{{ URL::action('PagesController@show', $page->id) }}">{{ $page->short_title }}</a></td>
                            <td>{{ $page->title }}</td>
                            <td>{{ localDate($page->created_at) }}</td>
                            <td>
                                {!! Form::open(["url" => URL::action("Admin\PagesController@destroy", $page->id), "method" => "delete"]) !!}
                                <a href="{{ URL::action('Admin\PagesController@edit', $page->id) }}" class="btn btn-warning btn-sm  ">{{ trans("admin.edit") }}</a>
                                {!! Form::submit(trans("admin.delete"), ["class" => "btn btn-danger btn-sm"]) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>

            {!! $pages->render() !!}
        </div>
    </div>

@endsection