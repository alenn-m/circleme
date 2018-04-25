<div class="usersGrid">
    <div class="row">
        @if(isset($users))
            @foreach($users as $user)
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="singleInviteUser" data-id="{{ $user->id }}">
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
                    </div>
                </div>
            @endforeach
        @else
            <h4>{{ trans("front.noUsers") }}</h4>
        @endif
    </div>
</div>