@extends('layouts.app')
@section('title', '注文の編集')
@section('content')
    <table class="uk-margin uk-table uk-table-middle uk-table-responsive uk-table-divider uk-table-form">
        <caption>発注者情報</caption>
        <tbody>
            <tr>
                <!--注文ID-->
                <td class="uk-width-medium@s uk-text-bold td-left">ID</td>
                <td>
                    {{ $order->id }}
                </td>
            </tr>
            <tr>
                <!--注文日-->
                <td class="uk-width-medium@s uk-text-bold td-left">
                    発注日時<br />
                </td>
                <td>
                    {{ $order->created_at->format('n月j日 H時i分') }}
                </td>
            </tr>
            <tr>
                <!--注文日-->
                <td class="uk-width-medium@s uk-text-bold td-left">
                    出荷日 / 到着希望日時
                </td>
                <td>
                    {{ $order->shipping_date->format('n月j日') }}
                    <span>/</span>
                    {{ $order->arrival_date->format('n月j日') }}
                    {{ $order->arrival_time }}
                </td>
            </tr>
            <tr>
                <!--名前-->
                <td class="uk-width-medium@s uk-text-bold td-left">名前</td>
                <td>
                    <a href="{{ route('partners.show', ['partner' => $order->partner]) }}">
                        {{ $order->partner_name }}
                    </a>
                    (<span class="uk-margin-small-right">担当:</span>{{ $order->staff_name }}様)<br>
                    <span class="uk-margin-small-right">累計発注額:</span>{{ number_format($order->partner->total_sales) }}円
                    <span>/</span>
                    <span class="uk-margin-small-right">発注回数:</span>{{ $order->partner->orders->count() }}回
                </td>
            </tr>
            <tr>
                <!--詳細-->
                <td class="uk-width-medium@s uk-text-bold td-left">詳細</td>
                <td>
                    <div>
                        {{ $order->tel }}
                        <span>/</span>
                        <a href="mailto:{{ $order->partner->email }}">{{ $order->email }}</a> <br>
                        〒{{ $order->post_code }}
                        {{ $order->prefecture }}
                        {{ $order->address }}
                        {{ $order->address_detail }}
                    </div>
                </td>
            </tr>
            <tr>
                <!--出荷ステータス-->
                <td class="uk-width-medium@s uk-text-bold td-left">出荷状況</td>
                <td>
                    <form action="{{ route('orders.changeStatus', ['order' => $order]) }}" method="POST">
                        @if ($order->registered == $order::UNREGISTERED)
                            <span class="uk-label uk-label-danger">未登録</span>
                            <button class="uk-button uk-button-link" name="status" value="{{ $order::REGISTERED }}">
                                「登録済み」に変更
                            </button>
                        @elseif($order->registered == $order::REGISTERED)
                            <span class="uk-label uk-label-success">登録済</span>
                            <button class="uk-button uk-button-link" name="status" value="{{ $order::UNREGISTERED }}">
                                「未登録」に変更
                            </button>
                        @endif
                        @csrf
                    </form>
                </td>
            </tr>
            <tr>
                <td class="uk-width-medium@s uk-text-bold td-left">販売形態</td>
                <td>
                    @if ($order->sales_style == config('const.SALES_STYLE.PURCHASE'))
                        <div class="uk-label uk-label-primary">買取</div>
                    @elseif($order->sales_style == config('const.SALES_STYLE.ENTRUSTMENT'))
                        <div class="uk-label uk-label-warning">委託</div>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="uk-width-medium@s uk-text-bold td-left">納品書</td>
                <td>
                    <div class="uk-grid-small" uk-grid>
                        <a target="_blank" href="{{ route('orders.note', ['order' => $order]) }}">
                            プレビュー
                        </a>
                        <a target="_blank" href="{{ route('orders.download', ['order' => $order]) }}">
                            ダウンロード
                        </a>
                    </div>
                    <form action="{{ route('orders.send', ['order' => $order] )}}" method="POST" onsubmit="return confirm('お客様に送信します。よろしいですか？')">
                        @csrf
                        <button class="uk-button uk-button-text">メールで送信する</button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>

    <form action="{{ route('orders.update', ['order' => $order]) }}" method="post">
        <table class="uk-margin uk-table uk-table-middle uk-table-responsive uk-table-divider uk-table-form">
            <caption>日付情報の変更</caption>
            <tbody>
                <tr>
                    <!--発送日-->
                    <td class="uk-width-medium@s uk-text-bold td-left">出荷日</td>
                    <td>
                        <div class="uk-width-1-5@s">
                            @component('components.input.text', [
                                'name' => 'shipping_date',
                                'type' => 'date',
                                'value' => $order->shipping_date->format('Y-m-d'),
                            ])@endcomponent </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <!--到着希望日-->
                    <td class="uk-width-medium uk-text-bold td-left">到着希望日</td>
                    <td uk-grid>
                        <div class="uk-width-1-5">
                            @component('components.input.text', [
                                'name' => 'arrival_date',
                                'type' => 'date',
                                'value' => $order->arrival_date->format('Y-m-d'),
                            ])@endcomponent
                        </div>
                        <div class="uk-width-1-5">
                            <select class="uk-select" name="arrival_time">
                                <option hidden>{{ $order->arrival_time }}</option>
                                <option value="指定なし">指定なし</option>
                                <option value="午前中">午前中</option>
                                <option value="14時-16時">14時-16時</option>
                                <option value="16時-18時">16時-18時</option>
                                <option value="18時-20時">18時-20時</option>
                                <option value="19時-21時">19時-21時</option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <!--請求日-->
                    <td class="uk-width-medium uk-text-bold td-left">請求日/入金日</td>
                    <td uk-grid>
                        <div class="uk-width-1-5">
                            @component('components.input.text', [
                                'name' => 'billing_date',
                                'type' => 'date',
                                'value' => $order->billing_date->format('Y-m-d'),
                            ])@endcomponent
                        </div>
                        <div class="uk-width-1-5">
                            @component('components.input.text', [
                                'name' => 'payment_due_date',
                                'type' => 'date',
                                'value' => $order->payment_due_date->format('Y-m-d'),
                            ])@endcomponent
                        </div>
                    </td>
                </tr>
                <tr>
                    <!--注文詳細-->
                    <td class="uk-width-medium@s uk-text-bold td-left">注文明細</td>
                    <td>
                        <table class="uk-margin-small uk-table uk-table-small uk-table-striped uk-table-middle">
                            <thead class="thead-color">
                                <tr>
                                    <td>商品名</td>
                                    <td>単価</td>
                                    <td>購入数</td>
                                    <td>計</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        @foreach ($order->carts as $cart)
                                            @if ($cart->product)
                                                <div>
                                                    {{ $cart->product_name }}
                                                </div>
                                            @else
                                                <div class="uk-text-danger">
                                                    削除された注文が含まれています
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($order->carts as $cart)
                                            @if ($cart->product)
                                                <div>
                                                    {{ number_format($cart->price) }}円
                                                </div>
                                            @else
                                                <div>-</div>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
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
                                    <td>
                                        {{ number_format($order->sub_total) }}円
                                    </td>
                                </tr>
                                <tr>
                                    <!-- 送料・手数料 -->
                                    <td>送料(税抜)</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ $order->shipping_fee }}円</td>
                                </tr>
                                <tr>
                                    <!-- 商品合計 -->
                                    <td>小計(商品代+送料)</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ number_format($order->sub_total) }}円</td>
                                </tr>
                                <tr>
                                    <!-- 消費税 -->
                                    <td>消費税</td>
                                    <td></td>
                                    <td></td>
                                    <td>{{ number_format($order->tax) }}円</td>
                                </tr>
                                <tr>
                                    <!-- 合計 -->
                                    <td>請求金額合計</td>
                                    <td></td>
                                    <td></td>
                                    <td class="uk-text-bold">{{ number_format($order->total_sales) }}円</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-medium@s uk-text-bold td-left">お支払い方法</td>
                    <td>
                        @component('components.payment_type', [
                            'payment_type' => $order->payment_type,
                        ])@endcomponent
                    </td>
                </tr>
            </tbody>
        </table>
        <div id="cart">
            <table class="uk-table uk-table-form uk-table-divider uk-table-middle uk-table-responsive">
                <caption>商品の変更</caption>
                <tbody>
                    <tr v-for="cart in carts">
                        <td>
                            <div>
                                <span class="uk-h3 uk-text-bold">@{{ cart . product_name }}</span>
                            </div>
                            <div>
                                <span class="uk-text-small uk-text-muted">単価@{{ cart . price }}円</span>
                            </div>
                        </td>
                        <td class="uk-text-right">
                            <div class="uk-width-small uk-display-inline-block">
                                <div class="uk-form-controls">
                                    <select class="uk-select" :name="'sizes['+cart.id+']'" v-model="cart.size">
                                        <option v-for="box in boxes" :value="box.value">
                                            @{{ box . text }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="shipping_fee" :value="this.shipping">
            <div class="uk-margin uk-text-center">
                <button type="submit" class="uk-button uk-button-primary uk-width-medium@s" id="button">
                    更新する
                </button>
            </div>
            @csrf
        </div>
    </form>

    <!-- 削除ボタン -->
    <div class="uk-flex uk-flex-right uk-margin-large-top">
        <form action="{{ route('orders.delete', ['order' => $order]) }}" method="post"
            onsubmit="return confirm('本当に削除しますか？');">
            @csrf
            <button type="submit" class="uk-button uk-button-danger" id="button">
                注文を削除する
            </button>
        </form>
    </div>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            let vm = new Vue({
                el: '#cart',
                data() {
                    var products = @json($products);
                    var sizes = {}
                    var carts = @json($order->carts);
                    var boxes = []
                    for (let i = 0; i <= 400; i++) {
                        var obj = {
                            text: `${i}個`,
                            value: i
                        };
                        boxes.push(obj);
                    }
                    return {
                        products: products,
                        sizes: sizes,
                        carts: carts,
                        boxes: boxes,
                        shipping_fee: @json(config('const.SHIPPING_FEE')),
                        far_shipping_fee: @json(config('const.FAR_SHIPPING_FEE')),
                        free_shipping: 0,
                        free_shipping_amount: @json(config('const.FREE_SHIPPING_AMOUNT')),
                    }
                },
                computed: {
                    cartSum() {
                        var cartSum = 0;
                        for (let cart of this.carts) {
                            cartSum += cart.price * cart.size;
                        }
                        return cartSum;
                    },
                    shipping() {
                        if (this.cartSum < this.free_shipping_amount) {
                            return this.shipping_fee;
                        } else if (this.cartSum >= this.free_shipping_amount) {
                            return this.free_shipping;
                        } else if (this.partner.prefecture == '沖縄県') {
                            return this.far_shipping_fee;
                        }
                    },
                }
            })
        });
    </script>

@endsection
