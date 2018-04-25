@include('js-localization::head')

<!doctype html>
<html lang="en">
<head>

    @include("layouts.partials.head")

</head>

<body ondrop="return false;">

@include("layouts.partials.top")

@include("layouts.partials.categories")

<div class="container">

    <div class="row">
        <div class="col-xs-12">
            @yield("content")
        </div>
    </div>

</div>


{!! HTML::script("/js/bootstrap.min.js") !!}
{!! HTML::script("/js/salvattore.js") !!}

<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

</body>
</html>