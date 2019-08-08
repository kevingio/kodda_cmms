<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Integrated Resource Management by Jetech</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="Themesbrand" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">
    </head>

    <body>

        <div id="wrapper">

            @include('layouts.top-bar')

            @include('layouts.left-sidebar')
            @yield('content')

        </div>

        <script src="{{ mix('js/app.js') }}"></script>

    </body>

</html>
