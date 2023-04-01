<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @vite(['resources/css/app.scss'])
    <link rel="stylesheet" href="{{ url('css/app.css') }}">
    @livewireStyles
</head>

<body class="app bg-marygrace">

    <header class="app-header fixed-top">
        @include('components.topbar')
        @include('components.sidebar')
    </header>
    <!--//app-header-->

    <div class="app-wrapper">
        <div class="app-content pt-3 p-md-3 p-lg-4">
            @yield('content')
            <!--//container-fluid-->
        </div>
        <!--//app-content-->

        <footer class="app-footer">
            <div class="container text-center py-3">
                <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
                <small class="copyright">
                    Mary Grace Foods, Inc.   Copyright © 2023. All rights reserved.
                </small>

            </div>
        </footer>
        <!--//app-footer-->

    </div>

    <script src="{{ url('js/app.js') }}"></script>
    @livewireScripts
    @vite(['resources/js/app.js'])
</body>

</html>
