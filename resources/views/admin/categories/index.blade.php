@extends("admin.layouts.main")

@section("content")

    <div class="row">
        <div class="col-xs-12">
            <h2 class="top-heading">{{ trans("admin.categories") }}</h2>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-xs-12">
            <a href="{{ URL::action('Admin\CategoriesController@create') }}" class="btn btn-primary btn-sm">{{ trans("admin.newCategory") }}</a>
        </div>
    </div>
    <br/>

    <div class="row">
        <div class="col-xs-12">
            <table class="table table-striped table-hover table-condensed">
                <tr>
                    <th>{{ trans("admin.name") }}</th>
                    <th>{{ trans("admin.created") }}</th>
                    <th></th>
                </tr>

                @if(count($categories) > 0)
                    @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ localDate($category->created_at) }}</td>
                            <td>
                                {!! Form::open(["url" => URL::action("Admin\CategoriesController@destroy", $category->id), "method" => "delete"]) !!}
                                <a href="{{ URL::action('Admin\CategoriesController@edit', $category->id) }}" class="btn btn-warning btn-sm  ">{{ trans("admin.edit") }}</a>
                                {!! Form::submit(trans("admin.delete"), ["class" => "btn btn-danger btn-sm"]) !!}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>

            {!! $categories->render() !!}
        </div>
    </div>

@endsection