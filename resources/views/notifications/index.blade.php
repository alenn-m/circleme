@extends("layouts.main")

@section("content")

    <div class="row">
        <div class="col-xs-12">
            <h2 style="margin-top: 0;">
                <small>
                    {{ trans("front.notifications") }}
                </small>
            </h2>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 notifications-wrap">
            <table class="table table-bordered table-striped table-hover">
                @foreach($notifications as $notification)

                    @if($notification->type == "invite")
                        @include("notifications.partials.invite")
                    @endif

                    @if($notification->type == "registered")
                        @include("notifications.partials.registered")
                    @endif

                    @if($notification->type == "massmessage")
                        @include("notifications.partials.massMessage")
                    @endif

                @endforeach
            </table>
        </div>
    </div>

@endsection