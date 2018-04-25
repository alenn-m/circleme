{!! Form::open(["url" => URL::action("CirclesController@update", $circle->id), "method" => "PUT"]) !!}
<div class="modal-body">
    <div class="form-group">
        {!! Form::text("name", $circle->name, ["placeholder" => trans("front.circleName"), "class" => "form-control"]) !!}
    </div>

    <div class="form-group">
        {!! Form::textarea("description",$circle->description, ["rows" => "3", "placeholder" => trans("front.circleDescription") . " ( " . trans("front.optional") . " )", "class" => "form-control"]) !!}
    </div>
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary">{{ trans("front.update") }}</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans("front.close") }}</button>
</div>

{!! Form::close() !!}