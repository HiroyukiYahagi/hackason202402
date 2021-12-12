@extends('layouts.partner')
@section('content')
    <h1 class="uk-text-center uk-text-bold">発注履歴</h1>
    <table class="uk-table uk-table-view uk-table-divider uk-table-middle uk-table-responsive uk-margin-medium">
        <thead class="thead-color">
            <tr>
                <td class="uk-text-bold uk-border-gray@s uk-width-small">
                    ご注文日
                </td>
                <td class="uk-text-bold uk-border-gray@s uk-width-small">
                    到着希望日
                </td>
                <td class="uk-text-bold uk-border-gray@s">
                    数量
                </td>
                <td class="uk-text-bold uk-border-gray@s">
                    お支払い方法
                </td>
                <td class="uk-text-bold uk-border-gray@s">
                    金額（税込）
                </td>
            <tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>
                        <div class="uk-hidden@s uk-text-bold uk-margin-small-bottom">
                            ご注文日
                        </div>
                        {{ $order->created_at->format('Y/m/d') }}
                    </td>
                    <td>
                        <div class="uk-hidden@s uk-text-bold uk-margin-small-bottom">
                            到着希望日
                        </div>
                        <div>
                            {{ $order->arrival_date->format('Y/m/d') }}
                        </div>
                        <div>
                            {{ $order->arrival_time }}
                        </div>
                    </td>
                    <td>
                        <div class="uk-hidden@s uk-text-bold uk-margin-small-bottom">
                            数量
                        </div>
                        @foreach ($order->carts as $cart)
                            @if ($cart->product)
                                <div>
                                    <span class="uk-margin-small-right">{{ $cart->product->name }}:</span>
                                    {{ $cart->size }}個
                                </div>
                            @else
                                <span class="uk-text-danger">
                                    *削除された注文が含まれています
                                </span>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        <div class="uk-hidden@s uk-text-bold uk-margin-small-bottom">
                            お支払い方法
                        </div>
                        @component('components.payment_type', [
                            'payment_type' => $order->payment_type,
                        ])@endcomponent
                    </td>
                    <td>
                        <div class="uk-hidden@s uk-text-bold uk-margin-small-bottom">
                            金額（税込）
                        </div>
                        @if ($order->temporary == true)
                            <span class="uk-text-danger">※金額が確定していません。</span>
                        @elseif($order->temporary == false)
                            {{ number_format($order->total_sales) }}円
                        @endif
                        <div class="uk-text-right">
                            <a href="{{ route('partner.orders.show', ['order' => $order]) }}">詳細</a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
