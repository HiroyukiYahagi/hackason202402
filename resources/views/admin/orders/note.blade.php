<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
        納品書兼明細書
    </title>
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
    </style>

</head>

<body>
    <div style="text-align: center;">
        <div style="display: inline-block;min-width: 720px;text-align: left;">
            <table style="border:0px;width: 100%;margin: 20px 0px;">
                <tbody>
                    <tr>
                        <td style="width: 200px;vertical-align:top;">
                        </td>
                        <td style="vertical-align:top;">
                            <h1 class="uk-text-bold" style="text-align: center; letter-spacing: 2px;">
                                納品書兼明細書
                            </h1>
                        </td>
                        <td style="width: 200px;vertical-align:top;color:#666666;font-size: 12px;text-align: right;">
                            発行日: {{ now()->format('Y年m月d日') }}<br />
                            注文番号: {{ $order->id }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <table style="border:0px;width: 100%;margin: 20px 0px;">
                <tbody>
                    <tr>
                        <td style="width: 150px;vertical-align:top;">
                            ■注文日 <br />
                            {{ $order->created_at->format('Y年m月d日') }} <br />
                            ■注文者<br />
                            {{ $order->partner_name }}様<br />
                            <br />
                            ■送付先<br />
                            {{ $order->partner_name }} 様
                        </td>
                        <td style="vertical-align:top;">
                            この度はココグルメをご注文いただきまして、ありがとうございます。<br />
                            商品到着後速やかに商品内容をご確認・ご検品いただけますようお願い致します。<br />
                            <br />
                            万が一商品に間違いがあった場合はご連絡ください。
                        </td>
                        <td style="width: 150px;vertical-align:top;">
                            <img style="width: 100%" src="https://coco-gourmet.com/images/logo/all_b.svg" />
                        </td>
                    </tr>
                </tbody>
            </table>
            <table style="border:1px solid black;width: 100%;margin: 20px 0px;border-spacing: inherit;">
                <tbody>
                    <tr>
                        <td
                            style="width: 200px;vertical-align:top; text-align: center;border:1px solid black;font-weight: bold;padding: 4px;">
                            商品名
                        </td>
                        <td
                            style="width: 100px;vertical-align:top; text-align: center;border:1px solid black;font-weight: bold;padding: 4px;">
                            単価
                        </td>
                        <td
                            style="width: 50px;vertical-align:top; text-align: center;border:1px solid black;font-weight: bold;padding: 4px;">
                            数量
                        </td>
                        <td
                            style="width: 100px;vertical-align:top; text-align: center;border:1px solid black;font-weight: bold;padding: 4px;">
                            金額
                        </td>
                    </tr>
    
                    @foreach ($order->carts as $cart)
                        <tr>
                            <td style="width: 150px;vertical-align:top; border:1px solid black;padding: 4px;">
                                {{ $cart->product_name }}
                            </td>
                            <td
                                style="width: 100px;vertical-align: top;border:1px solid black;padding: 4px;text-align: right;">
                                {{ $cart->price }}円
                            </td>
                            <td
                                style="width: 50px;vertical-align: top;border:1px solid black;padding: 4px;text-align: right;">
                                {{ $cart->size }}
                            </td>
                            <td
                                style="width: 100px;vertical-align: top;border:1px solid black;padding: 4px;text-align: right;">
                                {{ number_format($cart->price * $cart->size) }}円
                            </td>
                        </tr>
                    @endforeach
    
                    <tr>
                        <td style="vertical-align:top; border:1px solid black;padding: 4px;text-align: right;font-weight: bold;"
                            colspan="3">
                            送料
                        </td>
                        <td
                            style="width: 100px;vertical-align: top;border:1px solid black;padding: 4px;text-align: right;font-weight: bold;">
                            {{ number_format($order->shipping_fee) }}円
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top; border:1px solid black;padding: 4px;text-align: right;font-weight: bold;"
                            colspan="3">
                            消費税(10%)
                        </td>
                        <td
                            style="width: 100px;vertical-align: top;border:1px solid black;padding: 4px;text-align: right;font-weight: bold;">
                            {{ number_format($order->tax) }}円
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top; border:2px solid black;padding: 4px;text-align: right;font-weight: bold;"
                            colspan="3">
                            ご請求金額
                        </td>
                        <td
                            style="width: 100px;vertical-align: top;border:2px solid black;padding: 4px;text-align: right;font-weight: bold;">
                            {{ number_format($order->total_sales) }}円
                        </td>
                    </tr>
                </tbody>
            </table>
    
            <div style="border:1px solid black;width: 100%;margin: 32px 0px;">
                <div style="padding:16px;">
                    株式会社バイオフィリア<br />
                    〒141-0022 東京都品川区東五反田5丁目22-7-302<br />
                    {{ config('const.SALES_ADDRESS') }}
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
