@extends('layouts.app')
@section('content')
    <h1>未承認の請求書一覧</h1>
    <hr>
    <div id="app">
        <div class="uk-margin">
            <h3>
                絞り込み検索
                <span class="uk-text-small">({{ $invoices->total() }}件)</span>
            </h3>
            <form action="{{ route('invoices.unapproved') }}" method="GET">
                <div class="uk-grid-small uk-flex-bottom" uk-grid>
                    <div class="uk-width-1-6@s">
                        <label for="partner_name" class="uk-form-label">
                            <small>パートナー名</small>
                        </label>
                        <div class="uk-form-controls">
                            <input type="text" class="uk-input" name="partner_name"
                                value="{{ isset($param['partner_name']) ? $param['partner_name'] : null }}">
                        </div>
                    </div>
                    <div class="uk-width-1-6@s">
                        <label for="billing_year" class="uk-form-label">
                            <small>請求年</small>
                        </label>
                        <div class="uk-form-controls">
                            <select type="text" class="uk-select" name="billing_year" v-model="old_year">
                                <option v-for="year in years" :value="year.value">
                                    @{{ year . text }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="uk-width-1-6@s">
                        <label for="" class="uk-form-label">
                            <small>請求月</small>
                        </label>
                        <div class="uk-form-controls">
                            <select class="uk-select" name="billing_month" v-model="old_month">
                                <option v-for="month in months" :value="month.value">
                                    @{{ month . text }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="uk-width-1-6@s">
                        <label for="" class="uk-form-label">
                            <small>ステータス</small>
                        </label>
                        <div class="uk-form-controls">
                            <select class="uk-select" name="status" v-model="old_status">
                                <option v-for="status in statuses" :value="status.value">
                                    @{{ status . text }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="uk-width-1-6@s">
                        <button class="uk-button uk-button-primary uk-width-1-1">
                            検索
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <table class="uk-table uk-table-striped">
        <thead class="thead-color">
            <tr>
                <th>ID</th>
                <th>請求月</th>
                <th>パートナー名</th>
                <th>請求額(送料・税込)</th>
                <th>紹介割引</th>
                <th>詳細</th>
                <th></th>
            <tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
                <tr>
                    <td>
                        <a href="{{ route('invoices.show', ['partner' => $invoice->partner, 'invoice' => $invoice]) }}"
                            method="GET">
                            {{ $invoice->id }}
                        </a>
                    </td>
                    <td>
                        {{ $invoice->closing_date->format('Y年n月') }}
                    </td>
                    <td>
                        <a href="{{ route('partners.show', ['partner' => $invoice->partner]) }}">
                            {{ $invoice->partner->name }}
                        </a>
                    </td>
                    <td>
                        {{ number_format($invoice->total_sales) }}円
                    </td>
                    <td>
                        {{ $invoice->referral_count }}回
                    </td>
                    <td>
                        <a href="{{ route('invoices.show', ['partner' => $invoice->partner, 'invoice' => $invoice]) }}"
                            method="GET">
                            詳細
                        </a>
                    </td>
                    <td>
                        <form
                            action="{{ route('invoices.changeStatus', ['partner' => $invoice->partner, 'invoice' => $invoice]) }}"
                            method="POST"
                            onsubmit="return confirm('以下内容で承認します。\n\nパートナー名：{{ $invoice->partner->name }}\n請求金額(送料・税込)：{{ number_format($invoice->total_sales) }}円');">
                            <button class="uk-button uk-button-primary uk-margin-bottom" name="status"
                                value="{{ $invoice::APPROVED }}">
                                承認
                            </button>
                            @csrf
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $invoices->appends(request()->query())->links('pagination::default') }}

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            let vm = new Vue({
                el: '#app',
                data() {
                    var today = new Date
                    var this_year = today.getFullYear()
                    var years = [{
                        value: null,
                        text: '選択してください'
                    }]
                    var months = [{
                        value: null,
                        text: '選択してください'
                    }]
                    for (let i = 2021; i <= this_year; i++) {
                        obj = {
                            value: i,
                            text: i + '年'
                        }
                        years.push(obj)
                    }
                    for (let i = 1; i <= 12; i++) {
                        obj = {
                            value: i,
                            text: i + '月'
                        }
                        months.push(obj)
                    }
                    var statuses = [{
                            value: null,
                            text: '選択してください'
                        },
                        {
                            value: 0,
                            text: '未承認'
                        },
                        {
                            value: 1,
                            text: '確認中'
                        },
                        {
                            value: 2,
                            text: '承認済み'
                        },
                        {
                            value: 3,
                            text: '送付済み'
                        },
                        {
                            value: 4,
                            text: '入金済み'
                        },

                    ]
                    var old_year = @json(isset($param['billing_year']) ? $param['billing_year'] : null);
                    var old_month = @json(isset($param['billing_month']) ? $param['billing_month'] : null);
                    var old_status = @json(isset($param['status']) ? $param['status'] : null);
                    return {
                        this_year: this_year,
                        years: years,
                        months: months,
                        statuses: statuses,
                        old_year: old_year,
                        old_month: old_month,
                        old_status: old_status,
                    }
                },
            });
        });
    </script>
@endsection
