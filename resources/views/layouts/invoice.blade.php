<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        請求書
    </title>
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        @font-face {
            font-family: ipag;
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path('fonts/ipag.ttf') }}');
        }

        @font-face {
            font-family: ipag;
            font-style: bold;
            font-weight: bold;
            src: url('{{ storage_path('fonts/ipag.ttf') }}');
        }

        body {
            font-family: ipag;
            font-size: 13px;
            text-align: center;
        }

        /* ヘッダー */
        .header {
            text-align: center;
            width: auto;
            margin-bottom: 10px;
            margin-top: 50px;
        }

        /* パートナー情報 */
        .left1 {
            height: 130px;
            width: 370px;
            line-height: 16px;
            margin-bottom: 30px;
        }

        /* 金額 */
        .left2 {
            width: 370px;
            border: 3px;
            border-collapse: collapse;
            border-color: black;
            margin-bottom: 10px;
        }

        /* 振込先 */
        .left3 {
            width: 370px;
            border: 3px;
            border-collapse: collapse;
            border-color: black;
            margin-bottom: 10px;
        }

        /* 社判 */
        .stamp {
            position: absolute;
            top: 135px;
            right: 500px;
        }

        /* 弊社情報 */
        .right {
            height: 200px;
            width: 280px;
            position: absolute;
            top: 72px;
            right: 400px;
        }

        /* 請求情報詳細 */
        .main {
            width: 100%;
            border: 3px;
            line-height: 25px;
            border-collapse: collapse;
            border-color: black;
            margin-bottom: 10px;
        }

        /* 備考欄 */
        .footer {
            height: 130px;
            width: 100%;
            border: 1px solid;
            padding: 5px;
        }

        .mg-left {
            margin-left: 10px;
        }

        .border {
            border: 1px solid;
        }

        .ta-r {
            text-align: right;
        }

        .ta-c {
            text-align: center;
        }

        .lh-30 {
            line-height: 35px;
        }

        .lh-20 {
            line-height: 20px;
        }

        .underline {
            text-decoration: underline;
        }

        .pd-left {
            padding-left: 10px;
        }

        .pd-r {
            padding-right: 5px;
        }

    </style>

</head>

<body>
    @yield('main')

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
