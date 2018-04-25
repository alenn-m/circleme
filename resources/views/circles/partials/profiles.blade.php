<div class="row">
    <div class="col-xs-12">
        <h4 class="pull-left">{{ $circle->name }}</h4>

        <div class="pull-right">
            {!! Form::open(["url" => URL::action("CirclesController@destroy", $circle->id), "method" => "delete"]) !!}

                <a class="circle-edit btn btn-warning btn-sm" data-href="{{ URL::action('CirclesController@edit', $circle->id) }}"><i class="fa fa-edit"></i></a>
                <button type="submit" class="btn btn-warning btn-sm"><i class='fa fa-trash'></i></button>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<input type="hidden" id="circle_id" value="{{ $circle->id }}"/>

@if(isset($users))

    @foreach($users as $user)

        <div class="single-profile">
            <div class="row">
                <div class="col-xs-5">
                    <div class="avatar-big">
                        {!! HTML::image("/img/nouser.png", "User", ["width" => "100%"]) !!}
                    </div>
                </div>

                <div class="col-xs-7">
                    <label style="margin:0;">{{ $user->getFullname() }}</label>
                </div>
            </div>

            <div class="exit-circle">
                <button data-url="{{ URL::action('CirclesController@exitCircle', ['user' => $user->id, 'id' => $circle->id]) }}" class="btn btn-link exit-user"><i class="fa fa-times"></i></button>
            </div>
        </div>

    @endforeach

@else

    <h4>{{ trans("front.noUsers") }}</h4>

@endif