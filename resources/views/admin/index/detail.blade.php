@extends('layouts.app')
@section('content')
    <h1>{{ $month->format('Y年n月')}}の実績</h1>
    <hr>
    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-medium uk-table-divider">
            <thead>
                <tr>
                    <th class="uk-width-small">収支項目/店舗名</th>
                    @foreach ($partners as $partner)
                        <th class="uk-width-small">{{ $partner->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="uk-text-bold">売上高</td>
                    @foreach ($partners as $partner)
                        <td>
                            {{ number_format(monthly_achievement($partner->id, $month)['sales']) }}
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td><span class="uk-margin-left">商品売上</span></td>
                    @foreach ($partners as $partner)
                        <td>
                            {{ number_format(monthly_achievement($partner->id, $month)['cart_sum']) }}
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td><span class="uk-margin-left">送料売上</span></td>
                    @foreach ($partners as $partner)
                        <td>
                            {{ number_format(monthly_achievement($partner->id, $month)['shipping_fee']) }}
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="uk-text-bold">売上原価</td>
                    @foreach ($partners as $partner)
                        <td>
                            {{ number_format(monthly_achievement($partner->id, $month)['prime_cost']) }}
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td class="uk-text-muted uk-margin-left">(売上原価率)</td>
                    @foreach ($partners as $partner)
                        <td>
                            {{ number_format(monthly_achievement($partner->id, $month)['sales_cost_rate']) }}%
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
@endsection