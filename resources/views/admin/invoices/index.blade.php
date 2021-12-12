@extends('layouts.app')
@section('content')
    <h1>請求書一覧</h1>
    <hr>
    <div id="app">
        <div class="uk-margin">
            <h3>
                絞り込み検索
                <span class="uk-text-small">({{ $invoices->total() }}件)</span>
            </h3>
            <form action="{{ route('invoices.index') }}" method="GET">
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

            <div class="uk-grid-small uk-margin uk-flex-middle uk-flex-right" uk-grid>
                <div>
                    <h4 class="uk-margin-remove">紹介件数を更新:</h4>
                </div>
                <div>
                    <form action="{{ route('invoices.slackNoticeUndiscountedReferrals')}}" onsubmit="return confitm('更新します。よろしいですか？')">
                        <button class="uk-button uk-button-default">
                            更新
                        </button>
                    </form>
                    <form action="{{ route('invoices.fetchMonthlyReferrals')}}" method="GET" onsubmit="return confirm('紹介件数を取得します。よろしいですか？')">
                        <button class="uk-button uk-button-default" name="date" value="{{ now()->addMonthsNoOverflow(-1)}}">
                            先月の紹介
                        </button>
                        <button class="uk-button uk-button-default" name="date" value="{{ now() }}">
                            今月の紹介
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <table class="uk-table uk-table-striped">
        <thead class="thead-color">
            <tr>
                <th>ID</th>
                <th>請求月</th>
                <th>パートナー</th>
                <th>請求先</th>
                <th>請求額(送料・税込)</th>
                <th>ステータス</th>
                <th class="uk-text-center">操作</th>
            <tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
                @if ($invoice->partner)
                    <tr>
                        <td class="uk-width-auto"> {{-- id --}}
                            <a href="{{ route('invoices.show', ['invoice' => $invoice]) }}" method="GET">
                                {{ $invoice->id }}
                            </a>
                        </td>
                        <td class="uk-width-auto"> {{-- 請求月 --}}
                            {{ $invoice->closing_date->format('Y年n月') }}
                        </td>
                        <td class="uk-width-auto"> {{-- パートナー名 --}}
                            <a href="{{ route('partners.show', ['partner' => $invoice->partner]) }}">
                                {{ $invoice->partner->name }} <br>
                            </a>
                            〒{{ $invoice->partner->post_code }} <br>
                            {{ $invoice->partner->prefecture . $invoice->partner->address }} <br />
                            {{ $invoice->partner->address_detail }} <br/>
                            {{ $invoice->partner->email}}
                        </td>
                        <td class="uk-width-auto"> {{-- 請求先 --}}
                            @if ($invoice->partner->billingInformation)
                                {{ $invoice->partner->billingInformation->name }} <br>
                                〒{{ $invoice->partner->billingInformation->post_code }} <br>
                                {{ $invoice->partner->billingInformation->prefecture . $invoice->partner->billingInformation->address }} <br/>
                                {{ $invoice->partner->billingInformation->address_detail }} <br/>
                                {{ $invoice->partner->billingInformation->email }}
                            @else
                                店舗と同じ
                            @endif
                        </td>
                        <td class="uk-width-auto"> {{-- 請求額 --}}
                            {{ number_format($invoice->total_sales) }}円
                            <p>紹介件数:{{ $invoice->referral_count}}件</p>
                        </td>
                        {{-- ステータス、操作 --}}
                        @if ($invoice->status == $invoice::UNAPPROVED)
                            <td>
                                <label class="uk-label uk-label-danger">未承認</label>
                                <form
                                    action="{{ route('invoices.changeStatus', ['partner' => $invoice->partner, 'invoice' => $invoice]) }}"
                                    method="POST">
                                    <input type="hidden" name="page" value="{{ $invoices->currentPage() }}">
                                    <button class="uk-button uk-button-text" name="status"
                                        value="{{ $invoice::CONFIRMING }}">
                                        承認依頼を送信
                                    </button>
                                    @csrf
                                </form>
                            </td>
                        @elseif($invoice->status == $invoice::CONFIRMING)
                            <td>
                                <label class="uk-label uk-label-warning">
                                    確認中
                                </label>
                            </td>
                        @elseif($invoice->status == $invoice::APPROVED)
                            <td>
                                <label class="uk-label">承認済</label>
                                <form
                                    action="{{ route('invoices.send', ['partner' => $invoice->partner, 'invoice' => $invoice]) }}"
                                    method="POST"
                                    onsubmit="return confirm('以下内容で請求書を送信します。\n\n送付先：{{ $invoice->partner->billingInformation ? $invoice->partner->billingInformation->name : $invoice->partner->name }}\n請求月：{{ $invoice->closing_date->format('Y年n月') }}分\n請求金額(送料・税込)：{{ number_format($invoice->total_sales) }}円');">
                                    <input type="hidden" name="page" value="{{ $invoices->currentPage() }}">
                                    <button class="uk-button uk-button-text" name="status" value="{{ $invoice::SENT }}">
                                        請求書を送信
                                    </button>
                                    @csrf
                                </form>
                            </td>
                        @elseif($invoice->status == $invoice::SENT)
                            <td>
                                <label class="uk-label">送信済み</label>
                                <form
                                    action="{{ route('invoices.changeStatus', ['partner' => $invoice->partner, 'invoice' => $invoice]) }}"
                                    method="POST">
                                    <input type="hidden" name="page" value="{{ $invoices->currentPage() }}">
                                    <button class="uk-button uk-button-text" name="status" value="{{ $invoice::PAYD }}">
                                        入金済みに変更する
                                    </button>
                                    @csrf
                                </form>
                            </td>
                        @elseif($invoice->status == $invoice::PAYD)
                            <td>
                                <label class="uk-label uk-label-success">入金済み</label>
                                <form
                                    action="{{ route('invoices.changeStatus', ['partner' => $invoice->partner, 'invoice' => $invoice]) }}"
                                    method="POST">
                                    <input type="hidden" name="page" value="{{ $invoices->currentPage() }}">
                                    @csrf
                                </form>
                            </td>
                        @endif
                        <td class="uk-text-center">
                            @component('components.icon', [
                                'route' => 'invoices.show',
                                'args' => ['invoice' => $invoice],
                                'icon' => 'file-edit',
                                'color' => 'primary',
                            ])@endcomponent
                            @component('components.icon', [
                                'route' => 'invoices.fetchReferral',
                                'args' => ['invoice' => $invoice],
                                'icon' => 'refresh',
                                'color' => 'primary',
                            ])@endcomponent
                        </td>
                    </tr>
                @else
                    <tr>
                        <td class="uk-width-small">
                            {{ $invoice->id }}
                        </td>
                        <td class="uk-width-1-6">
                        </td>
                        <td class="uk-text-danger">削除されたパートナー</td>
                        <td>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
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
