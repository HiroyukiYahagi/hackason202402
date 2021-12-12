@extends('layouts.partner')
@section('content')
    @component('components.flash')
    @endcomponent
    <h1 class="uk-text-center uk-text-bold">パートナー様の情報</h1>
    @include('components.errors')
    <form action="{{ route('partner.update', ['partner' => $partner]) }}" method="POST">
        <div id="app">
            <table class="uk-margin-medium uk-table uk-table-middle uk-table-responsive uk-table-divider uk-table-form">
                <caption>店舗情報</caption>
                <tbody>
                    <tr>
                        <td class="uk-width-medium@s uk-text-bold">
                            パートナー名 <span class="uk-text-danger">*必須</span>
                        </td>
                        <td>
                            <div class="uk-width-large">
                                @component('components.input.text', [
                                    'name' => 'name',
                                    'required' => true,
                                    'value' => $partner->name,
                                ])@endcomponent
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="uk-width-medium@s uk-text-bold">
                            担当者名 <span class="uk-text-danger">*必須</span>
                        </td>
                        <td>
                            <div class="uk-width-small">
                                @component('components.input.text', [
                                    'name' => 'staff_name',
                                    'required' => true,
                                    'value' => $partner->staff_name,
                                ])@endcomponent
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="uk-width-medium@s uk-text-bold">
                            電話番号 <span class="uk-text-danger">*必須</span>
                        </td>
                        <td>
                            <div class="uk-width-small">
                                @component('components.input.text', [
                                    'name' => 'tel',
                                    'required' => true,
                                    'value' => $partner->tel,
                                ])@endcomponent
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="uk-width-medium@s uk-text-bold">
                            メールアドレス <span class="uk-text-danger">*必須</span>
                        </td>
                        <td>
                            <div class="uk-width-medium">
                                @component('components.input.text', [
                                    'name' => 'email',
                                    'type' => 'email',
                                    'required' => true,
                                    'value' => $partner->email,
                                ])@endcomponent
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="uk-width-medium@s uk-text-bold">
                            郵便番号 <span class="uk-text-danger">*必須</span>
                        </td>
                        <td>
                            <div class="uk-grid-small uk-flex-middle uk-grid" uk-grid>
                                <div class="uk-width-small">
                                    <div class="uk-form-controls">
                                        @component('components.input.text', [
                                            'name' => 'post_code',
                                            'required' => true,
                                            'value' => $partner->post_code,
                                        ])@endcomponent
                                    </div>
                                </div>
                                <div class="uk-width-small">
                                    <div class="uk-form-controls">
                                        <button onclick="AjaxZip3.zip2addr(this,'post_code','prefecture','address');"
                                            type="button" class="uk-button uk-button-default">
                                            自動入力
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="uk-width-medium@s uk-text-bold">
                            都道府県 <span class="uk-text-danger">*必須</span>
                        </td>
                        <td>
                            <div class="uk-form-controls">
                                <select class="uk-select uk-form-width-medium" name="prefecture"
                                    v-model="partner.prefecture">
                                    @foreach (config('prefectures') as $pref)
                                        @if (old('prefecture') == $pref)
                                            <option value="{{ $pref }}" selected="selected" name="pref01">
                                                {{ $pref }}</option>
                                        @else
                                            <option value="" style="display: none;">選択してください</option>
                                            <option value="{{ $pref }}" name="pref01">{{ $pref }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="uk-width-medium@s uk-text-bold">
                            市区町村 <span class="uk-text-danger">*必須</span>
                        </td>
                        <td>
                            <div class="uk-form-controls">
                                @component('components.input.text', [
                                    'name' => 'address',
                                    'value' => $partner->address,
                                ])@endcomponent
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="uk-width-medium@s uk-text-bold">
                            建物・部屋番号
                        </td>
                        <div class="uk-width-small">
                            <td>
                                @component('components.input.text', [
                                    'name' => 'address_detail',
                                    'value' => $partner->address_detail,
                                ])@endcomponent
                            </td>
                        </div>
                    </tr>
                </tbody>
            </table>
            <div>
                @if (isset($partner->billingInformation))
                    <label class="uk-text-bold">
                        <input class="uk-radio" type="checkbox" v-model="display">
                        請求先を編集する
                    </label>
                    <table class="uk-margin uk-table uk-table-middle uk-table-responsive uk-table-divider uk-table-form"
                        v-if="display">
                        @component('components.form.billing', [
                            'billingInformation' => $partner->billingInformation,
                        ])@endcomponent
                    </table>
                @else
                    <label class="uk-text-bold">
                        <input class="uk-radio" type="checkbox" v-model="display"> 請求先を別途登録する
                    </label>
                    <table class="uk-margin uk-table uk-table-middle uk-table-responsive uk-table-divider uk-table-form"
                        v-if="display">
                        @component('components.form.billing', [
                            'billingInformation' => $partner->billingInformation,
                        ])@endcomponent
                    </table>
                @endif
            </div>
            <div class="uk-margin uk-text-center">
                <button class="uk-button uk-button-primary uk-width-medium@s">
                    情報を更新する
                </button>
            </div>
            @csrf
    </form>
    <form action="{{ route('partner.password.update') }}" method="POST">
        <table class="uk-margin-medium uk-table uk-table-middle uk-table-responsive uk-table-divider uk-table-form">
            <caption>パスワード情報</caption>
            <tbody>
                <tr>
                    <td class="uk-width-medium@s uk-text-bold">現在のパスワード</td>
                    <td>
                        <div class="uk-form-controls">
                            <input class="uk-input" type="password" name="current_password"
                                placeholder="現在のパスワードを入力してください" required autofocus>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-medium@s uk-text-bold">新しいパスワード</td>
                    <td>
                        <div class="uk-form-controls">
                            <input type="password" class="uk-input" name="new_password"
                                placeholder="新しいパスワードを入力してください">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-medium@s uk-text-bold">新しいパスワード（確認）</td>
                    <td>
                        <div class="uk-form-controls">
                            <input type="password" class="uk-input" name="new_password_confirmation"
                                placeholder="もう一度新しいパスワードを入力してください">
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="uk-margin uk-text-center">
            <button class="uk-button uk-button-primary uk-width-medium@s">
                パスワードを更新する
            </button>
        </div>
        @csrf
    </form>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            let vm = new Vue({
                el: '#app',
                data() {
                    partner = @json($partner);
                    display = false
                    return {
                        display: display,
                        partner: partner,
                    }
                },
            })
        });
    </script>

@endsection
