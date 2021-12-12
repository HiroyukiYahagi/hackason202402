@extends('layouts.app')
@section('content')
    @include('components.errors')
    <h2>新規注文登録</h2>
    <hr>
    <form action="{{ route('carts.create', ['partner' => $partner]) }}" method="POST" onsubmit="return confirm('発注登録をしますか？');">
        <!-- パートナーの情報 -->
        <table class="uk-table uk-table-view uk-table-divider uk-tabel-middle uk-table-responsive">
            <caption>パートナー情報</caption>
            <tbody>
                <tr>
                    <td class="uk-text-bold">店舗名</td>
                    <td class="uk-margin-medium-left">
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
                    <td class="uk-text-bold">販売形態</td>
                    <td>
                        @if ($partner->sales_style == config('const.SALES_STYLE.PURCHASE'))
                            買取
                        @elseif($partner->sales_style == config('const.SALES_STYLE.ENTRUSTMENT'))
                            委託
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="uk-text-bold">お支払い方法</td>
                    <td>
                        @component('components.payment_type', [
                            'payment_type' => $partner->payment_type
                        ])@endcomponent
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- 注文フォーム -->
        <div id="cart">
            <table class="uk-table uk-table-form uk-table-divider uk-table-middle uk-table-responsive">
                <caption>注文フォーム</caption>
                <tbody>
                    @if ($partner->sales_style == config('const.SALES_STYLE.PURCHASE'))
                        <tr v-for="product in purchase_products">
                    @elseif($partner->sales_style == config('const.SALES_STYLE.ENTRUSTMENT'))
                        <tr v-for="product in entrustment_products">
                    @endif
                        <td>
                            <span class="uk-h5 uk-text-bold">@{{ product . name }}</span><br>
                            <span class="uk-text-small uk-text-muted">単価@{{ product . price }}円</span>
                        </td>
                        <td>
                            <div class="uk-width-small">
                                <div class="uk-position-relative">
                                    <select class="uk-select" v-model="sizes[product.id]"
                                        :name="'sizes['+product.id+']'">
                                        <option v-for="box in boxes" :value="box">
                                            @{{ box }}袋
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="uk-text-bold">到着希望日時</td>
                        <td>
                            <div class="uk-width-large">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-2">
                                        <input type="date" class="uk-input" name="arrival_date">
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
                            <span class="uk-text-bold uk-text-muted">小計</span>
                        </td>
                        <td>
                            <div class="uk-margin-xsmall">
                                <span class="uk-h4">@{{ subTotal }} 円</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="uk-text-bold uk-text-muted">送料</span>
                        </td>
                        <td class="uk-text-muted">
                            <span>+@{{ shipping }}円（税抜）</span>
                            <span class="uk-text-small uk-text-danger uk-text-bold"
                                v-if="partner.prefecture === '沖縄県' && this.cartSum < this.free_shipping_amount">
                                遠方地域のため送料は{{ config('const.FAR_SHIPPING') }}円です。
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="uk-text-bold uk-text-muted">消費税</span>
                        </td>
                        <td class="uk-text-muted">
                            <span>+@{{ tax }}円</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="uk-text-bold uk-h5">合計</span>
                        </td>
                        <td>
                            <span class="uk-text-bold uk-h3">@{{ totalPrice }}円</span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <input type="hidden" name="partner_id" value="{{ $partner->id }}">
            <input type="hidden" name="shipping_fee" :value="this.shipping">
            <input type="hidden" name="partner_name" value="{{ $partner->name }}">
            <input type="hidden" name="staff_name" value="{{ $partner->staff_name }}">
            <input type="hidden" name="post_code" value="{{ $partner->post_code }}">
            <input type="hidden" name="tel" value="{{ $partner->tel }}">
            <input type="hidden" name="email" value="{{ $partner->email }}">
            <input type="hidden" name="prefecture" value="{{ $partner->prefecture }}">
            <input type="hidden" name="address" value="{{ $partner->address }}">
            <input type="hidden" name="address_detail" value="{{ $partner->address_detail }}">
            <input type="hidden" name="payment_type" value="{{ (int)$partner->payment_type }}">
            <input type="hidden" name="sales_style" value="{{ (int)$partner->sales_style }}">

            <div class="uk-margin uk-text-center">
                <button type="submit" class="uk-width-medium uk-button uk-button-primary" id="button"
                    :disabled="totalSizes < this.minimum_sizes">
                    注文を確定する
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
                    var entrustment_products = @json($entrustment_products);
                    var products = @json($products);
                    var sizes = {}
                    for (let product of products) {
                        if (old) {
                            sizes[product.id] = old[product.id]
                        } else {
                            sizes[product.id] = 0
                        }
                    }
                    var boxes = []
                    for (let i = 0; i <= 300; i++) {
                        boxes.push(i)
                    }
                    var lead_time = @json(delivery_lead_time($partner->prefecture));
                    var sales_style = @json($partner->sales_style);
                    return {
                        partner: @json($partner),
                        old: old,
                        purchase_products: purchase_products,
                        entrustment_products: entrustment_products,
                        sizes: sizes,
                        boxes: boxes,
                        lead_time: lead_time,
                        sales_style: sales_style,
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
                        if(this.sales_style == 0) {
                            for (let product of this.purchase_products) {
                                cart_sum += product.price * this.sizes[product.id]
                            }
                        } else if(this.sales_style == 1) {
                            for (let product of this.entrustment_products) {
                                cart_sum += product.price * this.sizes[product.id]
                            }
                        }
                        return cart_sum
                    },
                    shipping() {
                        if (this.cartSum >= this.free_shipping_amount || this.sales_style == 1) {
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
                        if(this.sales_style == 0) {
                            for (let product of this.purchase_products) {
                                sizes += this.sizes[product.id];
                            }
                        } else if(this.sales_style == 1) {
                            for (let product of this.entrustment_products) {
                                sizes += this.sizes[product.id];
                            }
                        }
                 
                        return sizes;
                    },
                },
            })
        });
    </script>

@endsection
