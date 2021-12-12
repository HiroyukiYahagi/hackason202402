@extends('layouts.partner')
@section('content')
    @component('components.flash')
    @endcomponent
    <h1 class="uk-text-center uk-text-bold">請求書のダウンロード</h1>
    @include('components.errors')
    <table class="uk-table uk-table-striped">
        <thead class="thead-color">
            <tr>
                <th>請求月</th>
                <th>請求先</th>
                <th>請求額(送料・税込)</th>
                <th class="uk-text-center">操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
                <tr>
                    <td class="uk-width-auto">
                        {{ $invoice->closing_date->format('Y年n月')}}
                    </td>
                    <td class="uk-width-auto">
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
                    <td class="uk-width-auto">
                        {{ number_format($invoice->total_sales) }}円
                    </td>
                    <td class="uk-text-center">
                        <form action="{{ route('partner.downloadInvoice', ['invoice' => $invoice]) }}" onsubmit="return confirm('請求書をダウンロードします')">
                            @csrf
                            <button class="uk-button uk-button-text">
                                ダウンロード
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
