<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        {{ config('app.name', 'Laravel') }}
    </title>
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    @yield('main')

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
