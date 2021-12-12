@extends('layouts.app')
@section('title', '紹介一覧')
@section('content')
    <h1>
        <span class="uk-margin-right">{{ $partner->name }}様からの紹介</span>
        <span class="uk-text-small">{{ count($referrals) }}件</span>
    </h1>
    <div>
        ({{ now()->addMonthNoOverflow(-3)->format('n') .
    '月~' .
    now()->format('n') .
    '月' }})
    </div>
    <table class="uk-table uk-table-striped">
        <thead class="thead-color">
            <tr>
                <th>お客様ID</th>
                <th>注文日</th>
                <th>お客様情報</th>
                <th>紹介店舗</th>
                <th>注文ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($referrals as $referral)
                <tr>
                    <td>
                        <a href="{{ cart_path('owners', $referral['id']) }}">
                            {{ $referral['id'] }}
                        </a>
                    </td>
                    <td>
                        {{ $referral['orders'][0]['created_at'] }}
                    </td>
                    <td>
                        <div>
                            <a href="{{ cart_path('owners', $referral['id']) }}">
                                {{ $referral['last_name'] . $referral['first_name'] }}
                            </a>
                        </div>
                        <div>
                            {{ $referral['prefecture'] . $referral['address'] . $referral['address_detail'] }}
                        </div><br>
                        <div>
                            {{ $referral['email'] }}
                        </div>
                        <div>
                            {{ $referral['cv_param'] }}
                        </div>
                    </td>
                    <td>
                        {{ $partner->name }}
                    </td>
                    <td>
                        <a href="{{ cart_path('orders', $referral['orders'][0]['id']) }}">
                            {{ $referral['orders'][0]['id'] }}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
