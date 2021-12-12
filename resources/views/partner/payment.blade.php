@extends('layouts.partner')
@section('content')
    @component('components.flash')
    @endcomponent
    <h1 class="uk-text-center uk-text-bold">お支払い情報の変更</h1>
    @include('components.errors')
    <table class="uk-margin-medium uk-table uk-table-middle uk-table-responsive uk-table-divider uk-table-form">
        <caption>現在のお支払い設定</caption>
        <tbody>
            <tr>
                <td class="uk-width-medium@s uk-text-bold">お支払い方法</td>
                <td calss="uk-width-large">
                    @component('components.payment_type', [
                        'payment_type' => $partner->payment_type,
                    ])@endcomponent
                </td>
            </tr>
            @if (isset($card))
                <tr>
                    <td class="uk-width-medium uk-text-bold">詳細</td>
                    <td class="uk-width-large">
                        **** **** **** {{ $card->last4}} <br>
                        有効期限:{{ $card->exp_year}}/0{{ $card->exp_month }}
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <h3 class="uk-text-center">新しいお支払い設定</h3>
    <form action="{{ route('partner.payment.changeCredit')}}" method="POST" class="text-center mt-xxl">
        @csrf
        <table class="uk-margin uk-table uk-table-middle uk-table-responsive uk-table-divider uk-table-form">
            <caption>クレジットカード/デビットカード</caption>
            <tbody>
                <tr>
                    <td class="uk-width-medium@s"><span class="uk-text-samll uk-text-danger">※</span>クレジットカード情報の<br />お取り扱いについて</td>
                    <td>
                        <div class="uk-text-small">
                            【利用目的】お申し込みいただいた商品購入、サービスに関する決済のため。
                        </div>
                        <div class="uk-text-small">
                            【取得者】株式会社バイオフィリア
                        </div>
                        <div class="uk-text-small">
                            【提供元】お客様がご指定したカード会社
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-medium uk-background-muted">
                        カード番号<span class="uk-text-small uk-text-danger uk-margin-left">※必須</span>
                    </td>
                    <td>
                        @component('components.input.text', [
                            'name' => 'number',
                            'type' => 'string',
                            'required' => true,
                        ])@endcomponent
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-medium uk-background-muted">
                        有効期限<span class="uk-text-small uk-text-danger uk-margin-left">※必須</span>
                    </td>
                    <td>
                        <div class="uk-grid-small uk-grid" uk-grid>
                            <div class="uk-width-auto uk-first-column">
                                <label class="form-label">月</label>
                            </div>
                            <div class="uk-width-expand">
                                <div class="uk-form-controls">
                                    @component('components.input.select_month', [
                                        'name' => 'exp_month'
                                    ])@endcomponent
                                </div>
                            </div>
                            <div class="uk-width-auto uk-first-column">
                                <label class="form-label">年</label>
                            </div>
                            <div class="uk-width-expand">
                                <div class="uk-form-controls">
                                    @component('components.input.select_year', [
                                        'name' => 'exp_year'
                                    ])@endcomponent
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-medium uk-background-muted">
                        名義人<span class="uk-text-small uk-text-danger uk-margin-left">※必須</span>
                    </td>
                    <td>
                        @component('components.input.text', [
                            'name' => 'name',
                            'type' => 'string',
                            'required' => true,
                        ])@endcomponent
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-medium uk-background-muted">
                        セキュリティ番号<span class="uk-text-small uk-text-danger uk-margin-left">※必須</span>
                    </td>
                    <td>
                        @component('components.input.text', [
                            'name' => 'cvc',
                            'type' => 'password',
                            'required' => true,
                        ])@endcomponent
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="uk-text-center">
            <button class="uk-button uk-button-primary">カード情報を送信</button>
        </div>
    </form>

    <form action="{{ route('partner.payment.changeTransfer')}}" method="POST">
        @csrf
        <table class="uk-margin-medium uk-table uk-table-middle uk-table-responsive uk-table-divider">
            <caption>その他のお支払い方法</caption>
            <tbody>
                <tr>
                    <td class="uk-width-medium@s uk-text-bold">口座振込</td>
                    <td calss="uk-flex uk-flex-center">
                        <div>
                            毎月、月末締め翌月末払い<br>
                            弊社指定の口座にお振り込みをお願いいたします
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <button class="uk-button uk-button-primary uk-align-center">口座振込に変更する</button>
    </form>
  
@endsection