<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>LA RIFA PERU</title>

    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    {{-- <link href="{{ mix('/css/rtl.css') }}" rel="stylesheet"> --}}
    <!-- Global css content -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <!-- End of global css content-->

    <!-- Specific css content placeholder -->
    @stack('css')
    <!-- End of specific css content placeholder -->
</head>
