<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @if( config('app.env') == "production" )
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-KNKS7DN');</script>
    <!-- End Google Tag Manager -->
    @endif

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        {{ isset($title) ? $title : config('app.name', 'Laravel') }}
    </title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/codemirror.min.js" integrity="sha512-JpMCZgesTWh1iu/8ujURbwkJBgbgFWe3sTNCHdIuEvPwZuuN0nTUr2yawXahpgdEK7FOZUlW254Rp7AyDYJdjg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.0/codemirror.min.css" integrity="sha512-CCnciBUnVXwa6IQT9q8EmGcarNit9GdKI5nJnj56B1iu0LuD13Qn/GZ+IUkrZROZaBdutN718NK6mIXdUjZGqg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @yield('top')
</head>

<body>
    @if( config('app.env') == "production" )
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KNKS7DN"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    @endif

    @yield('main')

    @yield('bottom')
</body>

</html>
