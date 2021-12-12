<!doctype html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
        {{ $invoice->partner->name }} 様
        請求書
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
        }

        /* ヘッダー */
        .header {
            text-align: center;
            width: auto;
            margin-bottom: 10px;
        }

        /* パートナー情報 */
        .left1 {
            height: 130px;
            width: 370px;
            line-height: 16px;
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
            right: 100px;
        }

        /* 弊社情報 */
        .right {
            height: 200px;
            width: 280px;
            position: absolute;
            top: 72px;
            right: 0px;
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
    @component('components.invoice', [
        'invoice' => $invoice,
        'monthly_details' => $monthly_details,
        'monthly_carts' => $monthly_carts,
    ])@endcomponent
</body>

</html>
