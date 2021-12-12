@extends('layouts.partner')
@section('content')
    @include('components.errors')
    <h1 class="uk-text-center uk-text-bold">
        発注登録
    </h1>
    <form action="{{ route('partner.carts.confirm') }}" method="GET">
        <!-- パートナーの情報 -->
        <table class="uk-table uk-table-view uk-table-divider uk-tabel-middle uk-table-responsive">
            <caption>店舗情報</caption>
            <tbody>
                <tr>
                    <td class="uk-text-bold">店舗名</td>
                    <td>
                        {{ $partner->name }}様 <br>
                        (担当:{{ $partner->staff_name }}様) <br>
                        {{ $partner->tel }}
                        <span class="side-margin">/</span>
                        {{ $partner->email }}
                    </td>
                </tr>
                <tr>
                    <td class="uk-text-bold">配送先</td>
                    <td>
                        〒{{ $partner->post_code }} <br>
                        {{ $partner->prefecture }} <br>
                        {{ $partner->address }} <br>
                        {{ $partner->address_detail }}
                    </td>
                </tr>
                <tr>
                    <td class="uk-text-bold">お支払い方法</td>
                    <td>
                        @component('components.payment_type', [
                            'payment_type' => $partner->payment_type
                        ])@endcomponent
                        <div>
                            <a href="{{ route('partner.payment.edit')}}" type="uk-margin uk-link">お支払い方法を変更する</a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- 注文フォーム -->
        <div id="cart">
            <table class="uk-table uk-table-form uk-table-divider uk-table-small uk-table-responsive uk-margin">
                <caption>注文内容</caption>
                <tbody>
                    <tr v-for="product in purchase_products">
                        <td>
                            <span class="uk-h5 uk-text-bold">@{{ product . name }}</span> <br>
                            <span class="uk-text-small uk-text-muted">単価@{{ product . price }}円</span>
                        </td>
                        <td class="uk-text-right">
                            <div class="uk-width-small@m uk-display-inline-block">
                                <select class="uk-select" v-model="sizes[product.id]" :name="'sizes['+product.id+']'">
                                    <option v-for="box in boxes" :value="box.value">
                                        @{{ box . text }}
                                    </option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="uk-text-bold">到着希望日時</td>
                        <td>
                            <div class="uk-width@s">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-2">
                                        <select class="uk-select" name="arrival_date">
                                            <option v-for="date in dates" :value="date.value">@{{ date . text }}</option>
                                        </select>
                                    </div>
                                    <div class="uk-width-1-2">
                                        <select class="uk-select" name="arrival_time">
                                            <option value="指定なし">指定なし</option>
                                            <option value="午前中">午前中</option>
                                            <option value="14時-16時">14時-16時</option>
                                            <option value="16時-18時">16時-18時</option>
                                            <option value="18時-20時">18時-20時</option>
                                            <option value="19時-21時">19時-21時</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="uk-text-bold uk-text-muted">商品代金（税抜）</span>
                        </td>
                        <td class="uk-text-muted uk-text-right">
                            <span>@{{ cartSum }}円</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="uk-text-bold uk-text-muted">送料（税抜）</span>
                        </td>
                        <td class="uk-text-muted uk-text-right">
                            <span>@{{ shipping }}円</span>
                            <span class="uk-text-small uk-text-danger uk-text-bold"
                                v-if="partner.prefecture === '沖縄県' && this.cartSum < this.free_shipping_amount">
                                遠方地域のため送料は{{ config('const.FAR_SHIPPING') }}円です。
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="uk-text-bold uk-text-muted">小計</span>
                        </td>
                        <td class="uk-text-right">
                            <div class="uk-margin-xsmall">
                                <span class="uk-h4">@{{ subTotal }} 円</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="uk-text-bold uk-text-muted">消費税</span>
                        </td>
                        <td class="uk-text-muted uk-text-right">
                            <span>@{{ tax }}円</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="uk-text-bold uk-h5">合計</span>
                        </td>
                        <td class="uk-text-right">
                            <span class="uk-text-bold uk-h3">@{{ totalPrice }}円</span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="partner_id" value="{{ $partner->id }}">
            <input type="hidden" name="shipping_fee" :value="this.shipping">
            <input type="hidden" name="total_sales" :value="this.totalPrice">
            <input type="hidden" name="partner_name" value="{{ $partner->name }}">
            <input type="hidden" name="staff_name" value="{{ $partner->staff_name }}">
            <input type="hidden" name="post_code" value="{{ $partner->post_code }}">
            <input type="hidden" name="tel" value="{{ $partner->tel }}">
            <input type="hidden" name="email" value="{{ $partner->email }}">
            <input type="hidden" name="prefecture" value="{{ $partner->prefecture }}">
            <input type="hidden" name="address" value="{{ $partner->address }}">
            <input type="hidden" name="address_detail" value="{{ $partner->address_detail }}">
            <input type="hidden" name="is_billing" value="{{ isset($partner->billingInformation) ? true : false }}">
            <input type="hidden" name="payment_type" value="{{ (int)$partner->payment_type }}">
            <input type="hidden" name="sales_style" value="{{ (int)$partner->sales_style }}">
            <input type="hidden" name="payjp_customer_token" value="{{ isset($partner->payjp_customer_token) ? $partner->payjp_customer_token : null }}">
            <input type="hidden" name="billing_name"
                value="{{ isset($partner->billingInformation->name) ? $partner->billingInformation->name : null }}">
            <input type="hidden" name="billing_staff_name"
                value="{{ isset($partner->billingInformation->staff_name) ? $partner->billingInformation->staff_name : null }}">
            <input type="hidden" name="billing_post_code"
                value="{{ isset($partner->billingInformation->post_code) ? $partner->billingInformation->post_code : null }}">
            <input type="hidden" name="billing_prefecture"
                value="{{ isset($partner->billingInformation->prefecture) ? $partner->billingInformation->prefecture : null }}">
            <input type="hidden" name="billing_address"
                value="{{ isset($partner->billingInformation->address) ? $partner->billingInformation->address : null }}">
            <input type="hidden" name="billing_address_detail"
                value="{{ isset($partner->billingInformation->address_detail) ? $partner->billingInformation->address_detail : null }}">

            <div class="uk-margin uk-text-center uk-text-bold uk-text-danger" v-if="totalSizes < this.minimum_sizes">
                @{{ this . minimum_sizes }}袋以上を設定してください。
            </div>
            <div class="uk-margin uk-text-center">
                <button class="uk-button uk-button-primary uk-width-medium@m" :disabled="totalSizes < this.minimum_sizes">
                    確認画面へ
                </button>
            </div>
        </div>
        @csrf
    </form>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            let vm = new Vue({
                el: '#cart',
                data() {
                    var old = @json(old('sizes'));
                    var purchase_products = @json($purchase_products);
                    var sizes = {}
                    for (let product of purchase_products) {
                        if (old) {
                            sizes[product.id] = old[product.id]
                        } else {
                            sizes[product.id] = 0
                        }
                    }
                    var boxes = []
                    for (let i = 0; i <= 400; i++) {
                        var obj = {
                            text: `${i}個`,
                            value: i
                        };
                        boxes.push(obj);
                    }
                    var delivery_exclusion_dates = @json(config('const.DELIVERY_EXCLUSION_DATES'));
                    var lead_time = @json(config('const.ARRIVAL_LEAD_DAYS'));
                    var dates = []
                    for (let i = 0; i < 30; i++) {
                        var today = new Date();
                        today.setDate(today.getDate() + i + lead_time);
                        var year = today.getFullYear();
                        var month = today.getMonth() + 1;
                        var date = today.getDate();
                        var obj = {
                            text: month + '月' + date + '日',
                            value: year + '-' + month + '-' + date,
                        };
                        if (!(delivery_exclusion_dates.includes(obj.value))) {
                            dates.push(obj);
                        }
                    }
                    return {
                        delivery_exclusion_dates: delivery_exclusion_dates,
                        partner: @json($partner),
                        old: old,
                        purchase_products: purchase_products,
                        sizes: sizes,
                        boxes: boxes,
                        dates: dates,
                        lead_time: lead_time,
                        shipping_fee: @json(config('const.SHIPPING_FEE')),
                        far_shipping_fee: @json(config('const.FAR_SHIPPING_FEE')),
                        free_shipping: 0,
                        tax_rate: @json(config('const.TAX_RATE')),
                        free_shipping_amount: @json(config('const.FREE_SHIPPING_AMOUNT')),
                        minimum_sizes: @json(config('const.MINIMUM_SIZES')),
                    }
                },
                computed: {
                    cartSum() {
                        var cart_sum = 0
                        for (let product of this.purchase_products) {
                            cart_sum += product.price * this.sizes[product.id]
                        }
                        return cart_sum
                    },
                    shipping() {
                        if (this.cartSum >= this.free_shipping_amount) {
                            return this.free_shipping;
                        } else if (this.partner.prefecture == '沖縄県') {
                            return this.far_shipping_fee;
                        } else {
                            return this.shipping_fee;
                        }
                    },
                    subTotal() {
                        return this.cartSum + this.shipping;
                    },
                    tax() {
                        return Math.floor(this.subTotal * this.tax_rate);
                    },
                    totalPrice() {
                        return this.subTotal + this.tax
                    },
                    totalSizes() {
                        var sizes = 0;
                        for (let product of this.purchase_products) {
                            sizes += this.sizes[product.id];
                        }
                        return sizes;
                    },
                },
            })
        });
    </script>

@endsection
