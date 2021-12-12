<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <style>
        .text-bold {
            font-weight: bold,
        }

        .tr {
            text-align: right
        }

    </style>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    {{-- 宛名 --}}
    <p class="text-bold">{{ $order->partner_name }}様</p>
    <br>
    {{-- 冒頭の案内文 --}}
    <div>
        <p>
            CoCo Gourmet(ココグルメ)のご注文をいただきまして誠にありがとうございます。<br>
            下記ご注文内容にお間違いがないかご確認ください。<br>
            <br>
            【注文番号】{{ $order->id }}
        </p>
    </div>
    <br>

    <div>
      納品書兼明細書をお送りいたします。よろしくお願いいたします。
    </div>
    <br>
    <p> ------------------------------------------</p>
    <div>
        株式会社バイオフィリア <br>
        卸売店舗サポートチーム<br>
        03-5422-3057 <br>
        <a href="mailto:{{ config('const.SALES_ADDRESS') }}">{{ config('const.SALES_ADDRESS') }}</a><br>
        <br>
        営業時間 10:00 ~ 18:00 (土日祝を除く) <br>
        ※新型コロナウィルスの影響におきまして、短縮営業とさせていただいております。 <br>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
