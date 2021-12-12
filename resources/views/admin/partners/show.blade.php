@extends('layouts.app')
@section('content')
    <h1>パートナー詳細</h1>
    <!-- パートナー情報 -->
    <div class="uk-margin-medium">
        <table class="uk-margin uk-table uk-table-middle uk-table-responsive uk-table-divider uk-table-form">
            <caption>パートナー情報</caption>
            <tbody>
                <tr>
                    <td class="uk-width-medium@s uk-text-bold td-left">ID</td>
                    <td>
                        {{ $partner->id }}
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-medium@s uk-text-bold td-left">店舗名/連絡先
                    </td>
                    <td>
                        <span class="uk-margin-right">{{ $partner->name }}</span>
                        <a target="_blank" class="uk-button uk-button-text" href="{{route('admin.partner.login', ['partner' => $partner])}}">>マイページにログイン</a> <br>
                        (<span class="uk-margin-small-right">担当:</span>{{ $partner->staff_name }}様) <br>
                        {{ $partner->tel }}
                        <span>/</span>
                        <a href="mailto:{{ $partner->email }}">{{ $partner->email }}</a>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-medium@s uk-text-bold td-left">
                        販売形態
                    </td>
                    <td>
                        @if ($partner->sales_style == config('const.SALES_STYLE.PURCHASE') )
                            <span class="uk-label-primary">買取</span>
                        @elseif($partner->sales_style == config('const.SALES_STYLE.ENTRUSTMENT'))
                            <span class="uk-label-warning">委託</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-medium@s uk-text-bold td-left">
                        契約期間
                    </td>
                    <td>
                        {{ $partner->contract_start ? $partner->contract_start->format('Y年n月d日') : null }}〜
                        {{ $partner->contract_end ? $partner->contract_end->format('Y年n月d日') : null }}まで
                        @if ($partner->contract_end && $partner->contract_end->lte(now()))
                            <div class="uk-text-danger uk-text-bold">※契約情報を更新してください。</div>
                        @elseif ($partner->contract_end && now()->diffInDays($partner->contract_end) <= 30)
                            <div class="uk-text-primary">※契約更新が近づいています</div>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-medium@s uk-text-bold td-left">住所</td>
                    <td>
                        〒{{ $partner->post_code }} <br>
                        {{ $partner->prefecture . $partner->address . $partner->address_detail }}
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-medium@s uk-text-bold uk-text-left">
                        紹介件数({{ now()->addMonthNoOverflow(-3)->format('n') }}月~{{ now()->format('n') }}月分)
                    </td>
                    <td>
                        <div>
                            @if ($referrals)
                                <a
                                    href="{{ route('partners.referrals', compact('partner')) }}">{{ count($referrals) }}件</a>
                            @else()
                                <div>紹介はありません</div>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-medium@s uk-text-bold td-left">累計</td>
                    <td>
                        <span class="uk-margin-small-right">累計発注額:</span>
                        {{ number_format($partner->total_sales) }}円<br>
                        <span class="uk-margin-small-right">発注回数:</span>
                        {{ $partner->orders->count() }}回
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-medium@s uk-text-bold td-left">
                        請求先
                    </td>
                    <td>
                        @if (isset($partner->billingInformation))
                            ID:{{ $partner->billingInformation->id }} <br>
                            {{ $partner->billingInformation->name }} <br>
                            {{ $partner->billingInformation->staff_name }}様 /
                            <a
                                href="mailto:{{ $partner->billingInformation->email }}">{{ $partner->billingInformation->email }}</a><br>
                            〒{{ $partner->billingInformation->post_code }}
                            {{ $partner->billingInformation->prefecture . $partner->billingInformation->address }}
                            {{ $partner->billingInformation->address_detail }}
                        @else
                            ※店舗と同じ
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-medium@s uk-text-bold td-left">
                        お支払い方法
                    </td>
                    <td>
                        @component('components.payment_type', [
                            'payment_type' => $partner->payment_type,
                        ])@endcomponent
                    </td>
                </tr>
            </tbody>
        </table>
        <!-- 編集ボタン-->
        <div class="uk-margin uk-text-center">
            <a href="{{ route('partners.edit', ['partner' => $partner]) }}">
                <button type="button" class="uk-button uk-button-muted">
                    パートナー情報を編集する
                </button>
            </a>
        </div>
    </div>
    <!-- メモ編集 -->
    <form action="{{ route('partners.memo', ['partner' => $partner]) }}" method="POST">
        <div class="uk-grid-small uk-flex-bottom uk-grid" uk-grid>
            <div class="uk-width-expand uk-first-column">
                <div class="uk-margin-small">
                    <label class="uk-form-label" for="form_memo">メモ欄</label>
                    <div class="uk-form-controls">
                        <textarea class="uk-height-small uk-textarea" type="text" name="memo"
                            value="{{ old('memo') }}">{{ $partner->memo }}</textarea>
                    </div>
                </div>
            </div>
            <div class="uk-width-auto">
                <button class="uk-button uk-button-muted ukk-width-medium@s" type="submit">更新する</button>
            </div>
        </div>
        @csrf
    </form>

    <div class="uk-margin-medium">
        <div class="uk-grid-small uk-flex-middle uk-margin" uk-grid>
            <div class="uk-width-expand">
                <h2>発注履歴</h2>
            </div>
            <div class="uk-width-auto">
                <a href="{{ route('carts.create', ['partner' => $partner]) }}"
                    class="uk-button uk-button-primary uk-width-medium uk-margin">
                    発注登録
                </a>
            </div>
        </div>
        @component('components.order_list', [
            'orders' => $partner->orders,
            'param' => null
        ])@endcomponent
    </div>

    <hr>
    <!-- 削除ボタン -->
    <div class="uk-margin-medium uk-text-right">
        <form action="{{ route('partners.delete', ['partner' => $partner]) }}" method="post"
            onsubmit="return confirm('本当に削除しますか？');">
            <button class="uk-button uk-button-danger">このパートナーの情報を完全に削除する</button>
            @csrf
        </form>
    </div>

@endsection
