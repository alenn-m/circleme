@extends("circles.main")

@section("subcontent")

    @include("circles.partials.top")

    <hr style="border-color: #d3d3d3"/>

    {!! Form::open(["url" => URL::action("InvitesController@invite")]) !!}
    <div class="input-group">
        {!! Form::text("email", null, ["placeholder" => trans("front.email"), "class" => "form-control", "style" => "background:white;padding:10px;"]) !!}
        <span class="input-group-btn">
            <select multiple id="circleoption" name="circles[]">
                @if(isset($circles))
                    @foreach($circles as $circle)
                        <option value="{{ $circle->id }}">{{ $circle->name }}</option>
                    @endforeach
                @endif
            </select>
            {!! Form::submit(trans("front.sendInvitation"), ["class" => "btn btn-primary"] ) !!}
        </span>
    </div>
    {!! Form::close() !!}

    @if($errors->any())
        <br/>
        <div class="alert alert-warning" style="text-align: center">
            @foreach($errors->all() as $error)
                {{ $error }} <br/>
            @endforeach
        </div>

    @endif

    @if(Session::has("message"))

        <br/>
        <div class="alert alert-success" style="text-align: center">
            {{ Session::get("message") }}
        </div>

    @endif

    @if($invites and count($invites) > 0)
        <br/>

        <table class="table table-striped table-hover">
            <tr>
                <th>{{ trans("front.email") }}</th>
                <th>{{ trans("front.circles") }}</th>
                <th>{{ trans("front.joined") }}?</th>
            </tr>

            @foreach($invites as $invite)
                <tr>
                    <td>{{ $invite->email }}</td>
                    <td>{{ $invite->getCircles() }}</td>
                    <td>{{ $invite->registered ? trans("front.yes") : trans("front.no") }}</td>
                </tr>
            @endforeach
        </table>
    @else

        <h3><small>{{ trans("front.noInvitedUsers") }}</small></h3>

    @endif

    <script>
        $('#circleoption').multiselect({
            buttonText : function(options, select){
                return "<i class='fa fa-user-plus'></i> {{ trans('front.addToCircle') }}";
            },
            enableHTML: true,
            buttonClass: "btn btn-default",
            disableIfEmpty: true
        });
    </script>

@endsection