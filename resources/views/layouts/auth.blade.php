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
    <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
    <!-- Include Livewire styles -->
    @livewireStyles
</head>
<body class="white-bg">
    <div class="container">
        <section class="vh-100">
            @yield('content')
        </section>
    </div>
    @vite(['resources/js/app.js'])

    @livewireScripts

    <script src="{{ url('js/app.js') }}"></script>

</body>
</html>
