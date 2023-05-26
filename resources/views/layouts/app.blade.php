<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Set the character set and viewport for the page -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Set compatibility mode for Internet Explorer -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Set the title of the page dynamically with the 'yield' directive -->
    <title>@yield('title')</title>
    <!-- Include the styles compiled by Vite, a build tool for modern web development -->
    @vite(['resources/css/app.scss'])
    <!-- Include custom CSS file -->
    <link rel="stylesheet" href="{{ url('css/app.css') }}">


    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.2.min.js"
        integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
    <!-- Include Livewire styles -->
    @livewireStyles
</head>
<body class="app bg-marygrace">
    <!-- Define the application header and include the topbar and sidebar components -->
    <header class="app-header fixed-top">
        @include('livewire.components.topbar')
        @include('livewire.components.sidebar')
    </header>
    <!-- Define the application wrapper -->
    <div class="app-wrapper">
        <!-- Define the application content and include the 'content' section -->
        <div class="app-content pt-3 p-md-3 p-lg-4">
            @yield('content')
            <!-- Define the container-fluid -->
        </div>
        <!-- Include the application footer -->
        <footer class="app-footer">
            <!-- Define the footer container with attribution and copyright information -->
            <div class="container text-center py-3">
                <!-- Add attribution information to keep the template free to use -->
                <small class="copyright">
                    Mary Grace Foods, Inc. Copyright © 2023. All rights reserved.
                </small>
            </div>
        </footer>
    </div>
    <!-- Include the application scripts, including the compiled scripts by Vite and Livewire -->
    @vite(['resources/js/app.js'])
    @livewireScripts
    <script src="{{ url('js/app.js') }}"></script>
    <script src="{{ url('js/alert.js') }}"></script>

</body>

</html>
