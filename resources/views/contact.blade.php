@extends("layouts.wide")

@section("content")

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary" style="margin-top:40px;">
                <div class="panel-body">
                    {!! Form::open(["url" => URL::action("ContactController@contact"), "role" => "form"]) !!}
                    <div class="form-group">
                        {!! Form::text("name", null, ["placeholder" => trans("front.fullName") . "*", "class" => "form-control"]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::text("email", null, ["placeholder" => trans("front.email") . "*", "class" => "form-control"]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::text("subject", null, ["placeholder" => trans("front.subject"), "class" => "form-control"]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::textarea("message", null, ["placeholder" => trans("front.message") . "*", "class" => "form-control", "rows" => 7]) !!}
                    </div>
                    {!! Form::submit(trans("front.send"), ["class" => "btn btn-primary btn-md btn-block"]) !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    @if($errors->any())
        @foreach($errors->all() as $error)
            <div class="row" style="text-align:center;">
                <div class="col-md-6 col-md-offset-3">
                    <div class="alert alert-warning">{{{ $error }}}</div>
                </div>
            </div>
        @endforeach
    @endif

    @if(Session::has("message"))
        <div class="row" style="text-align:center;">
            <div class="col-md-6 col-md-offset-3">
                <div class="alert alert-warning">{{{ Session::get("message") }}}</div>
            </div>
        </div>
    @endif

@endsection