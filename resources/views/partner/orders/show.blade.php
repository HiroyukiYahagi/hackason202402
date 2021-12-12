@extends('layouts.partner')
@section('content')
    <h1 class="uk-text-bold uk-text-center">
        注文詳細
    </h1>
    <table class="uk-margin uk-table uk-table-middle uk-table-responsive uk-table-divider uk-table-form">
        <tbody>
            <tr>
                <!--注文日-->
                <td class="uk-width-small@s uk-text-bold td-left">
                    注文日時<br />
                </td>
                <td>
                    {{ $order->created_at->format('Y/m/d H:i') }}
                </td>
            </tr>
            <tr>
                <td class="uk-width-small@s uk-text-bold td-left">到着予定日</td>
                <td>
                    <div>
                        {{ $order->arrival_date->format('Y/m/d') }}
                    </div>
                    <div>
                        {{ $order->arrival_time }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="uk-width-small@s uk-text-bold td-left">出荷状況</td>
                <td>
                    @if ($order->registered == 0)
                        <label class="uk-label uk-label-warning">
                            出荷準備中
                        </label><br>
                        <small
                            class="uk-text-danger">※注文変更をご希望の場合はご連絡ください。<br>(準備状況によって変更を承れない場合もございますので、あらかじめご了承ください。)</small>
                    @elseif($order->registered == 1)
                        <label class="uk-label uk-label-primary">
                            出荷済み
                        </label>
                    @endif
                </td>
            </tr>
            <tr>
                <!--注文詳細-->
                <td class="uk-width-small@s uk-text-bold td-left">請求金額</td>
                <td>
                    @if ($order->temporary == true)
                        <span class="uk-text-danger">※金額が確定していません。</span>
                    @elseif($order->temporary == false)
                        <table class="uk-margin-small uk-table uk-table-small uk-table-striped uk-table-middle">
                            <tbody>
                                <tr>
                                    <td>
                                        @foreach ($order->carts as $cart)
                                            @if ($cart->product)
                                                <div>
                                                    {{ $cart->product_name }}
                                                </div>
                                                <div class="uk-hidden@m uk-text-right">
                                                    {{ $cart->price }}円
                                                </div>
                                                <div class="uk-hidden@m uk-margin-bottom uk-text-right">
                                                    {{ $cart->size }}個
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="uk-text-right uk-visible@m">
                                        @foreach ($order->carts as $cart)
                                            @if ($cart->product)
                                                <div>
                                                    {{ number_format($cart->price) }}円
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="uk-text-right uk-visible@m">
                                        @foreach ($order->carts as $cart)
                                            @if ($cart->product)
                                                <div>
                                                    {{ $cart->size }}個
                                                </div>
                                            @else
                                                <div>-</div>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <!-- 商品合計 -->
                                    <td>商品代金(税抜)</td>
                                    <td></td>
                                    <td class="uk-text-right">{{ number_format($order->cart_sum) }}円</td>
                                </tr>
                                <tr>
                                    <!-- 送料・手数料 -->
                                    <td>送料（税抜）</td>
                                    <td></td>
                                    <td class="uk-text-right">{{ number_format($order->shipping_fee) }}円</td>
                                </tr>
                                <tr>
                                    <!-- 商品合計 -->
                                    <td>小計</td>
                                    <td></td>
                                    <td class="uk-text-right">{{ number_format($order->sub_total) }}円</td>
                                </tr>
                                <tr>
                                    <!-- 消費税 -->
                                    <td>消費税</td>
                                    <td></td>
                                    <td class="uk-text-right">{{ number_format($order->tax) }}円</td>
                                </tr>
                                <tr>
                                    <!-- 合計 -->
                                    <td>請求金額合計</td>
                                    <td></td>
                                    <td class="uk-text-bold uk-text-right">{{ number_format($order->total_sales) }}円</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="uk-width-small@s uk-text-bold td-left">配送先</td>
                <td>
                    <div>
                        {{ $order->partner_name }}様 <br>
                        〒{{ $order->post_code }} <br>
                        {{ $order->prefecture }}
                        {{ $order->address }}
                        {{ $order->address_detail }}
                    </div>
                </td>
            </tr>
            <tr>
                <td class="uk-width-small@s uk-text-bold td-left">請求先</td>
                <td>
                    @if (isset($partner->billingInformation))
                        {{ $partner->billingInformation->name }}御中 <br>
                        {{ $partner->billingInformation->staff_name }}様 <br>
                        〒{{ $partner->billingInformation->post_code }} <br>
                        {{ $partner->billingInformation->prefecture . $partner->billingInformation->address . $partner->billingInformation->address_detail }}
                        <br>
                    @else
                        ※配送先と同じ
                    @endif
                </td>
            </tr>
            @if ($order->payment_type == config('const.TRANSFER'))
                <tr>
                    <td class="uk-width-small@s uk-text-bold td-left">お振込期日</td>
                    <td>
                        {{ $order->payment_due_date->format('Y/m/d') }} <br>
                        <small class="uk-text-danger">
                            ※{{ $order->billing_date->format('n月d日') }}以降にメールにて請求書を送付いたします。
                        </small>
                    </td>
                </tr>
            @elseif($order->payment_type == config('const.CREDIT'))
                <tr>
                    <td class="uk-width-small@s uk-text-bold td-left">お支払い方法</td>
                    <td>
                        クレジットカード
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="uk-margin-medium uk-text-center">
        <a href="{{ route('partner.orders.index') }}" class="uk-button uk-button-default uk-width-medium">
            発注履歴
        </a>
    </div>
@endsection
