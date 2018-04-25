@extends("layouts.wide")

@section("content")

    <div class="modal fade" id="newCircle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans("front.newCircle") }}</h4>
                </div>
                {!! Form::open(["url" => URL::action("CirclesController@store"), "class" => "new-circle-form"]) !!}

                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::text("name", null, ["placeholder" => trans("front.circleName"), "class" => "form-control"]) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::textarea("description",null, ["rows" => "3", "placeholder" => trans("front.circleDescription") . " ( " . trans("front.optional") . " )", "class" => "form-control"]) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">{{ trans("front.create") }}</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans("front.close") }}</button>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="modal fade" id="editCircle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans("front.editCircle") }}</h4>
                </div>

                <div class="editCircleContent"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-xs-12">
            <div class="white-box" style="height:500px;margin-top:0;">
                <h3 style="margin-top:0;"><small>{{ trans("front.circles") }}</small></h3>

                <div class="row">
                    <div class="col-xs-6" style="text-align: center;font-size:150%;">
                        <button data-toggle="modal" data-target="#newCircle" class="btn btn-default btn-circle btn-lg"><i class="fa fa-plus"></i></button>
                    </div>

                    @if(isset($circles))

                        @foreach($circles as $circle)
                            <div class="col-xs-6 singleCircleLarge" style="text-align: center">
                                <button id="{{ $circle->id }}" data-circle_id = "{{ $circle->id }}" class="btn btn-primary btn-circle btn-lg circle" data-add_url="{{ URL::action('CirclesController@addUser') }}" data-url="{{ URL::action('CirclesController@show', $circle->id) }}">
                                    {{ $circle->name }} <br/>
                                    <label class="circleNumber">{{ count($circle->users) }}</label>
                                </button>
                            </div>
                        @endforeach

                    @endif

                </div>
            </div>
        </div>

        <div class="col-md-9 col-xs-12">
            @yield("subcontent")
        </div>
    </div>

@endsection