    {{-- ヘッダー --}}
    <div class="header">
        <h1>請求書</h1>
    </div>

    {{-- パートナー情報 --}}
    <div class="left1">
        @if (isset($invoice->partner->billingInformation))
            <h2 class="underline">
                {{ $invoice->partner->billingInformation->name }} 御中
            </h2>
            <span class="mg-left">
                〒 {{ $invoice->partner->billingInformation->post_code }}
            </span> <br>
            <span class="mg-left">
                {{ $invoice->partner->billingInformation->prefecture . $invoice->partner->billingInformation->address }}
            </span> <br>
            <span class="mg-left">
                {{ $invoice->partner->billingInformation->address_detail }}
            </span> <br>
            <span class="mg-left">
                {{ $invoice->partner->billingInformation->staff_name }}様
            </span>
        @else
            <h2 class="underline">
                {{ $invoice->partner->name }} 御中
            </h2>
            <span class="mg-left">
                〒 {{ $invoice->partner->post_code }}
            </span> <br>
            <span class="mg-left">
                {{ $invoice->partner->prefecture . $invoice->partner->address }}
            </span> <br>
            <span class="mg-left">
                {{ $invoice->partner->address_detail }}
            </span> <br>
            <span class="mg-left">
                {{ $invoice->partner->staff_name }}様
            </span>
        @endif
        <p>下記の通りご請求申し上げます。</p>
    </div>
    {{-- 金額 --}}
    <table class="left2" border="2">
        <tbody>
            <tr>
                <td class="border ta-c lh-30">小計</td>
                <td class="ta-c lh-30">消費税</td>
                <td class="ta-c lh-30">紹介割引</td>
                <td class="ta-c lh-30" style="font-size: 18px;">合計金額</td>
            </tr>
            <tr>
                <td class="ta-r lh-30 pd-r">
                    {{ number_format($monthly_details['sub_total']) }} 円
                </td>
                <td class="ta-r lh-30 pd-r">
                    {{ number_format(floor($monthly_details['total_tax'])) }} 円
                </td>
                <td class="ta-r lh-30 pd-r">
                    -{{ $monthly_details['discount'] }}円
                </td>
                <td class="ta-r lh-30 pd-r" style="font-size: 18px;">
                    {{ number_format($monthly_details['request_amount']) }} 円
                </td>
            </tr>
        </tbody>
    </table>

    {{-- 振込先 --}}
    <table class="left3" border="2">
        <tbody>
            <tr>
                <td class="lh-20">
                    <span class="mg-left">振込期日</span>
                </td>
                <td class="lh-20">
                    <span class="mg-left">
                        {{ $invoice->closing_date->addMonthsNoOverflow()->format('Y年n月d日') }}
                    </span>
                </td>
            </tr>
            <tr>
                <td style="height: 90px;">
                    <span class="mg-left">振込先</span>
                </td>
                <td style="height: 90px;">
                    @foreach (config('const.TRANSFER_ACCOUNT') as $item)
                        <span class="mg-left">{{ $item }}</span> <br>
                    @endforeach
                </td>
            </tr>
        </tbody>
    </table>

    {{-- 社判 --}}
    <img class="stamp" src="images/stamp.png" height="80" width="80" alt="社判">

    {{-- 弊社情報 --}}
    <div class="right">
        <div style="height: 25px;">
            <span>日付 :</span>
            <span style="float: right;">
                {{ $invoice->closing_date->format('Y年n月d日') }}
            </span>
        </div>
        <div style="text-align: justify; text-justify: inter-ideograph;">
            <span>請求書番号 :</span>
            <span style="float: right;">
                {{ $invoice->id }}
            </span>
        </div>
        <div style="line-height: 20px; margin-top: 10px;">
            <span style="font-size: 16px;">{{ config('const.COMPANY_INFO.NAME') }}</span> <br>
            <span>〒{{ config('const.COMPANY_INFO.POST_CODE') }}</span> <br>
            <span>{{ config('const.COMPANY_INFO.ADDRESS') }}</span> <br>
            <span>{{ config('const.COMPANY_INFO.ADDRESS_DETAIL') }}</span> <br>
            <span>電話:{{ config('const.COMPANY_INFO.TELL') }}</span> <br>
            <span>FAX:{{ config('const.COMPANY_INFO.FAX') }}</span>
        </div>
    </div>

    {{-- 請求情報詳細 --}}
    <table class='main' border="2">
        <thead>
            <tr>
                <td class="ta-c">詳細</td>
                <td class="ta-c">数量</td>
                <td class="ta-c">単価</td>
                <td class="ta-c">金額</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($monthly_carts as $cart)
                <tr>
                    <td class="pd-left">
                        {{ $cart['product_name'] }}
                    </td>
                    <td class="ta-r pd-r">
                        {{ number_format($cart['total_sizes']) }}袋
                    </td>
                    <td class="ta-r pd-r">
                        {{ number_format($cart['price'])}}
                    </td>
                    <td class="ta-r pd-r">
                        {{ number_format($cart['total_sales']) }}円
                    </td>
                </tr>
            @endforeach
            <tr>
                <td class="pd-left">送料(税抜)</td>
                <td></td>
                <td></td>
                <td class="ta-r pd-r">
                    {{ number_format($monthly_details['total_shipping']) }}円
                </td>
            </tr>
            <tr>
                <td class="pd-left">消費税</td>
                <td></td>
                <td></td>
                <td class="ta-r pd-r">
                    {{ number_format($monthly_details['total_tax']) }}円
                </td>
            </tr>
            <tr>
                <td class="pd-left">紹介件数</td>
                <td class="ta-r pd-r">
                    {{ $invoice->referral_count }}件
                </td>
                <td class="ta-r pd-r">
                    -{{ config('const.REFERRAL_DISCOUNT') }}円
                </td>
                <td class="ta-r pd-r">
                    -{{ config('const.REFERRAL_DISCOUNT') * $invoice->referral_count }}円
                </td>
            </tr>
        </tbody>
    </table>
    {{-- 備考欄 --}}
    <div class="footer">
        @foreach (config('const.INVOICE_REMARKS') as $item)
            <span>・{{ $item }}</span> <br>
        @endforeach
    </div>
