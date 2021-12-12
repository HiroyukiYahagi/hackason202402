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
    {{-- 注文内容 --}}
    <div>
        <p class="text-bold">
            ■ご注文内容
        </p>
        <hr>
        <span class="text-bold">
            ・商品・数量
        </span><br>
        @foreach ($order->carts as $cart)
            {{ $cart->product_name }}：{{ $cart->size }}袋 <br>
        @endforeach
        <br>
        <span class="text-bold">
            ・到着予定日
        </span><br>
        {{ $order->arrival_date->format('Y年m月d日') }} <br>
        時間指定：{{ $order->arrival_time }} <br>
        <br>
        <span class="text-bold">
            ・お支払い方法
        </span><br>
        @if ($order->shipping_method == config('const.TRANSFER'))
            口座振込 <br>
        @elseif($order->shipping_method == config('const.CREDIT'))
            クレジットカード<br>
        @endif
        <br>
        <span class="text-bold">
            ・ご請求金額
        </span><br>
        {{ $order->total_sales }}円（税・送料込) <br>
        <br>
        <a class="tr" href="{{ my_page_path('orders', $order->id) }}">その他詳細・金額の内訳はこちら</a><br>
        <br>
    </div>
    <br>
    {{-- パートナーの情報 --}}
    <div>
        <p class="text-bold">
            ■パートナー様情報
        </p>
        <hr>
        <span class="text-bold">
            ・店舗名
        </span><br>
        {{ $order->partner->name }} <br>
        <br>
        <span class="text-bold">
            ・ご担当者名
        </span><br>
        {{ $order->partner->staff_name }}<br>
        <br>
        <span class="text-bold">
            ・ご連絡先
        </span><br>
        {{ $order->partner->email }} <br>
        {{ $order->partner->tel }} <br>
        <br>
        <span class="text-bold">
            ・ご住所
        </span><br>
        〒{{ $order->partner->post_code }} <br>
        {{ $order->partner->prefecture . $order->partner->address }} <br>
        {{ $order->partner->address_detail }} <br>
        <br>
        <span class="text-bold">
            ・{{ $order->partner->name }}様専用ページ
        </span><br>
        <a href="{{ my_page_path('home') }}">{{ my_page_path('home') }}</a> <br>
        <br>
        <span class="text-bold">
            ・お支払い期日
        </span><br>
        {{ $order->payment_due_date->format('Y年n月d日') }} <br>
        ({{ $order->billing_date->format('n月d日') }}以降にメールにて請求書を送付いたします。) <br>
    </div>
    <br>
    {{-- 請求先の情報 --}}
    <div>
        <p class="text-bold">
            ■ご請求先情報
        </p>
        <hr>
        @if ($order->partner->billingInformation)
            <span class="text-bold">
                ・会社名
            </span><br>
            {{ $order->partner->billingInformation->name }} <br>
            <br>
            <span class="text-bold">
                ・ご担当者名
            </span><br>
            {{ $order->partner->billingInformation->staff_name }} <br>
            <br>
            <span class="text-bold">
                ・ご連絡先
            </span><br>
            {{ $order->partner->billingInformation->email }} <br>
            <br>
            <span class="text-bold">
                ・ご住所
            </span><br>
            〒{{ $order->partner->billingInformation->post_code }} <br>
            {{ $order->partner->billingInformation->prefecture . $order->partner->billingInformation->address }} <br>
            {{ $order->partner->billingInformation->address_detail }} <br>
        @else
            店舗情報と同じ<br>
        @endif
    </div>
    <br>
    {{-- 支払いについて --}}
    <div>
        <p class="text-bold">
            【お支払いについて】
        </p>
        <p>
            弊社指定銀行口座にて、お振込をお願いしております。<br>
            <br>
            {{ $order->billing_date->format('n月d日') }}以降に1ヶ月分のご注文内容をまとめました請求書を、<br>
            経理部より別途メールにて送付いたしますので、<br>
            指定の銀行口座にお振り込みをお願いいたします。<br>
            <br>
            また、締日・お支払い日につきましては弊社規定に則らせていただきますのであらかじめご了承ください。<br>
            （今後クレジットカード払いも導入予定です。<br>
            詳細は専用ページにて追ってお知らせさせていただきます。）
        </p>
    </div>
    <br>
    {{-- 注文内容変更について --}}
    <div>
        <p class="text-bold">
            【ご注文内容の変更について】
        </p>
        <p>
            ご注文内容の変更を希望の場合は、大変お手数ですが変更内容を記載の上<br>
            このメールにご返信をお願いいたします。<br>
            ※商品の準備状況によっては変更を承れない場合もございますので、<br>
            変更の際はお早めにご連絡ください。<br>
        </p>
    </div>
    <br>
    {{-- 締めの文章 --}}
    <div>
        その他、ご不明な点などがございましたら、お気軽にご連絡ください。<br>
        <br>
        今後ともCoCo Gourmet（ココグルメ）をどうぞよろしくお願いいたします。
        <br>
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
