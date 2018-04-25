<meta charset="UTF-8">
<title>{{ Config::get("settings.title") }}</title>

@yield('js-localization.head')

<meta name="keywords" content="{{ Config::get('settings.keywords') }}" />
<meta name="description" content="{{ Config::get('settings.description') }}" />

{!! Config::get("settings.tracking_code") !!}

<meta name="csrf-token" content="{{ csrf_token() }}" />

{!! Minify::stylesheet([
    "/datepicker/css/bootstrap-datepicker.min.css",
    "/css/bootstrap.min.css",
    "/css/theme.css",
    "/css/main.css",
    "/css/bootstrap-multiselect.css",
    "/css/jquery-ui.css"
]) !!}

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

{!! Minify::javascript([
    "/js/jquery.js",
    "/js/locationpicker.jquery.js",
    "/js/script.js",
    "/js/jquery.form.js",
    "/js/bootstrap-multiselect.js",
    "/js/jquery.infinitescroll.min.js",
    "/js/jquery-ui.js",
    "/js/readmore.js"
]) !!}

