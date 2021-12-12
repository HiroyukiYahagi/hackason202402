@extends('layouts.app')
@section('title', 'パートナー情報を編集する')
@section('content')
    @include('components.errors')
    <div id="app">
        <form action="{{ route('partners.update', ['partner' => $partner]) }}" method="POST">

            @component('components.form.partner', [
                'partner' => $partner,
            ])@endcomponent

            <div>
                @if (isset($partner->billingInformation))
                    <input class="uk-radio" type="checkbox" v-model="display">
                    <label class="uk-text-bold">請求先を編集する</label>
                    <table class="uk-margin uk-table uk-table-middle uk-table-responsive uk-table-divider uk-table-form"
                        v-if="display">
                        @component('components.form.billing', [
                            'billingInformation' => $partner->billingInformation,
                        ])@endcomponent
                    </table>
                @else
                    <input class="uk-radio" type="checkbox" v-model="display">
                    <label class="uk-text-bold">請求先を別途登録する</label>
                    <table class="uk-margin uk-table uk-table-middle uk-table-responsive uk-table-divider uk-table-form"
                        v-if="display">
                        @component('components.form.billing', [
                            'billingInformation' => $partner->billingInformation,
                        ])@endcomponent
                    </table>

                @endif
            </div>
            <div class="uk-margin uk-text-center">
                <button type="submit" class="uk-button uk-button-primary uk-width-medium@s">更新する</button>
            </div>
            @csrf
        </form>
        <form action="{{ route('partners.password.update', compact('partner')) }}" method="POST">
            <table class="uk-margin uk-table uk-table-middle uk-table-responsive uk-table-divider uk-table-form">
                <caption>パスワード情報</caption>
                <tbody>
                    <tr>
                        <td class="uk-width-medium@s uk-text-bold">新しいパスワード</td>
                        <td>
                            <div class="uk-form-controls">
                                <input type="password" class="uk-input" name="password" :value="password"
                                    placeholder="新しいパスワードを入力してください">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="uk-width-medium@s uk-text-bold">新しいパスワード（確認）</td>
                        <td>
                            <div class="uk-form-controls">
                                <input type="password" class="uk-input" name="password_confirmation" :value="password"
                                    placeholder="もう一度新しいパスワードを入力してください">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="uk-width-medium@s">
                            <button type="button" class="uk-button" v-on:click="createRandomPass">
                                パスワードを自動入力
                            </button>
                        </td>
                        <td>
                            <input type="text" class="uk-input uk-text-bold uk-width-1-5" :value="password" readonly>
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
    </div>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            let vm = new Vue({
                el: '#app',
                data() {
                    partner = @json($partner);
                    display = false
                    password = ''
                    return {
                        display: display,
                        partner: partner,
                        password: password,
                    }
                },
                methods: {
                    createRandomPass() {
                        var S = '1234567890'
                        var N = 8
                        this.password = Array.from(Array(N)).map(() => S[Math.floor(Math.random() * S
                            .length)]).join('')
                    }
                }
            })
        });
    </script>

@endsection
