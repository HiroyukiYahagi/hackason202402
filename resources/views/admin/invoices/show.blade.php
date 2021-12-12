@extends('layouts.invoice')
@section('main')
    <div style="display: inline-block;min-width: 960px;text-align: left;">
        @component('components.flash')
        @endcomponent
        @component('components.invoice', [
            'invoice' => $invoice,
            'partner' => $invoice->partner,
            'monthly_details' => $monthly_details,
            'monthly_carts' => $monthly_carts,
        ])@endcomponent
        <table class="uk-margin uk-table uk-table-middle uk-table-responsive uk-table-divider uk-table-form">
            <tbody>
                <tr>
                    <td class="uk-width-medium@s uk-text-bold td-left">ステータス</td>
                    <td>
                        @if ($invoice->status == $invoice::UNAPPROVED)
                            <label class="uk-label uk-label-danger">未承認</label>
                        @elseif($invoice->status == $invoice::CONFIRMING)
                            <label class="uk-label uk-label-warning">確認中</label>
                        @elseif($invoice->status == $invoice::APPROVED)
                            <label class="uk-label">承認済</label>
                        @elseif($invoice->status == $invoice::SENT)
                            <label class="uk-label">送信済み</label>
                        @elseif($invoice->status == $invoice::PAYD)
                            <label class="uk-label uk-label-success">入金済み</label>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="uk-width-medium@s uk-text-bold td-left">操作</td>
                    <td>
                        @if ($invoice->status == $invoice::UNAPPROVED)
                            <form
                                action="{{ route('invoices.changeStatus', ['partner' => $invoice->partner, 'invoice' => $invoice]) }}"
                                method="POST">
                                <button class="uk-button uk-button-text" name="status" value="{{ $invoice::CONFIRMING }}">
                                    承認依頼を送信
                                </button>
                                @csrf
                            </form>
                        @elseif($invoice->status == $invoice::CONFIRMING)
                            経理担当者の承認待ちです
                        @elseif($invoice->status == $invoice::APPROVED)
                            <div class="uk-grid" uk-grid>
                                <a href="{{ route('invoices.download', ['invoice' => $invoice]) }}"
                                    method="GET">
                                    PDF出力
                                </a>
                                <form
                                    action="{{ route('invoices.changeStatus', ['partner' => $invoice->partner, 'invoice' => $invoice]) }}"
                                    method="POST">
                                    <button class="uk-button uk-button-text" name="status" value="{{ $invoice::PAYD }}">
                                        入金済みに変更する
                                    </button>
                                    @csrf
                                </form>
                            </div>
                        @elseif($invoice->status == $invoice::SENT)
                            <a href="{{ route('invoices.download', ['partner' => $invoice->partner, 'invoice' => $invoice]) }}"
                                method="GET">
                                PDF出力
                            </a>
                        @elseif($invoice->status == $invoice::PAYD)
                            <a href="{{ route('invoices.download', ['partner' => $invoice->partner, 'invoice' => $invoice]) }}"
                                method="GET">
                                PDF出力
                            </a>
                        @endif
                        <form action="{{ route('invoices.delete', ['invoice' => $invoice])}}" method="POST" onsubmit="return confirm('請求書を削除します。よろしいですか？')">
                            @csrf
                            <button class="uk-button uk-button-danger uk-margin">削除する</button>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
