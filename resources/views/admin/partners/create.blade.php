@extends('layouts.app')
@section('title', 'パートナーを登録')
@section('content')
    @include('components.errors')
    <form action="{{ route('partners.create') }}" method="POST">

        @component('components.form.partner')
        @endcomponent

        <div id="billing">
            <h3>
                請求先 <small class="uk-text-danger">※必須</small>
            </h3>
            <hr>
            <div uk-grid>
                <div class="uk-grid-1-3">
                    <label class="uk-text-bold">
                        <input type="radio" class="uk-radio" name="type" value="new" v-model="selected">
                        新しい請求先を登録
                    </label>
                </div>
                <div class="uk-grid-1-3">
                    <label class="uk-text-bold">
                        <input type="radio" class="uk-radio" name="type" value="id" v-model="selected">
                        既存の請求先から登録
                    </label>
                </div>
                <div class="uk-grid-1-3">
                    <label class="uk-text-bold">
                        <input type="radio" class="uk-radio" name="type" value="same" v-model="selected">
                        店舗と同じ
                    </label>
                </div>
            </div>
            <table>
                <tbody class="uk-margin uk-table uk-table-middle uk-table-responsive uk-table-divider uk-table-form"
                    v-if="selected === 'id'">
                    <tr>
                        <td class="uk-width-medium@s uk-text-bold">
                            請求先ID <span class="uk-text-danger">*必須</span>
                        </td>
                        <td>
                            <div class="uk-width-xsmall">
                                <input class="uk-input" type="integer" name="billing[id]" placeholder="IDを入力">
                            </div>
                        </td>
                    </tr>
            </table>

            <table class="uk-margin uk-table uk-table-middle uk-table-responsive uk-table-divider uk-table-form"
                v-if="selected === 'new'">
                @component('components.form.billing')
                @endcomponent
            </table>
        </div>
        <div class="uk-margin">
            <button class="uk-button uk-button-primary">登録する</button>
        </div>
        @csrf
    </form>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            let vm = new Vue({
                el: '#billing',
                data: {
                    selected: '',
                    partner: '',
                }
            });
        });
    </script>

@endsection
