@extends('layouts.partner')
@section('content')
    @include('components.errors')
    @component('components.flash')
    @endcomponent
    <h1 class="uk-text-center uk-text-bold">
        確認画面
    </h1>
    <form action="{{ route('partner.carts.create') }}" method="POST">
        <table class="uk-table uk-table-view uk-table-divider uk-table-middle uk-table-responsive">
            <caption>ご注文内容</caption>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td class="uk-text-bold">{{ $product->name }}</td>
                        <td>
                            {{ $data['sizes'][$product->id] }}袋
                        </td>
                    </tr>
                @endforeach
                @if ($partner->sales_style == config('const.SALES_STYLE.PURCHASE'))
                    <tr>
                        <td class="uk-text-bold">合計金額</td>
                        <td>
                            {{ number_format($data['total_sales']) }}円
                        </td>
                    </tr>
                @endif
                <tr>
                    <td class="uk-text-bold">到着希望日</td>
                    <td>
                        <div class="uk-grid-small" uk-grid>
                            {{ $data['arrival_date'] }}
                            {{ $data['arrival_time'] }}
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="uk-table uk-table-view uk-table-divider uk-table-middle uk-table-responsive">
            <caption>パートナー様情報</caption>
            <tr>
                <td class="uk-text-bold">配送先</td>
                <td>
                    {{ $data['partner_name'] }} <br>
                    〒{{ $data['post_code'] }} <br>
                    {{ $data['prefecture'] }} <br>
                    {{ $data['address'] }} <br>
                    {{ $data['address_detail'] }}
                </td>
            </tr>
            <tr>
                <td class="uk-text-bold">ご請求先</td>
                <td>
                    @if ($data['is_billing'])
                        {{ $data['billing_name'] }}様 <br>
                        {{ $data['billing_staff_name'] }} <br>
                        〒{{ $data['billing_post_code'] }} <br>
                        {{ $data['billing_prefecture'] }} <br>
                        {{ $data['billing_address'] }} <br>
                        {{ $data['billing_address_detail'] }}
                    @else
                        店舗と同じ
                    @endif
                </td>
            </tr>
            <tr>
                <td class="uk-text-bold">お支払い方法</td>
                <td>
                    @if ($data['payment_type'] == $partner::CREDIT)
                        クレジットカード
                    @elseif($data['payment_type'] == $partner::TRANSFER)
                        口座振込
                    @endif
                    <div>
                        <a href="{{ route('partner.payment.edit')}}" class="uk-text-link" onclick="return confirm('ご注文内容は削除されます。よろしいですか？')">お支払い方法を変更する</a>
                    </div>
                </td>
            </tr>
        </table>
        @csrf
        <div class="uk-margin uk-text-center">
            <button class="uk-button uk-button-primary">
                注文を確定する
            </button>
        </div>
    </form>
@endsection
