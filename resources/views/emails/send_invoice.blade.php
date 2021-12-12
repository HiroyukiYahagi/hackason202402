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
    @if ($partner->billingInformation)
        <p class="text-bold">{{ $partner->billingInformation->name }}</p>
        {{ $partner->billingInformation->staff_name }}様<br>
    @else
        <p class="text-bold">{{ $partner->name }}</p>
        {{ $partner->staff_name }}様<br>
    @endif
    <br>
    {{-- 冒頭の案内文 --}}
    <div>
        <p>
            いつもお世話になっております。<br>
            バイオフィリア経理部でございます。<br>
            こちらのメールに請求書を添付にてお送りいたします。<br>
            内容をご確認いただきまして、お手続きをお願いいたします。<br>
            <br>
            何かご不明な点がございましたら、お気軽にご連絡くださいませ。<br>
            よろしくお願い申し上げます。<br>
        </p>
    </div>
    {{-- 締めの文章 --}}
    <div>
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
    </div>
    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>
