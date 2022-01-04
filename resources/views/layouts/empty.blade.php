<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        {{ config('app.name', 'Laravel') }}
    </title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/codemirror.min.js" integrity="sha512-JpMCZgesTWh1iu/8ujURbwkJBgbgFWe3sTNCHdIuEvPwZuuN0nTUr2yawXahpgdEK7FOZUlW254Rp7AyDYJdjg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/codemirror.min.css" integrity="sha512-CCnciBUnVXwa6IQT9q8EmGcarNit9GdKI5nJnj56B1iu0LuD13Qn/GZ+IUkrZROZaBdutN718NK6mIXdUjZGqg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @yield('top')
</head>

<body>
    @yield('main')

    
    @yield('bottom')
</body>

</html>
