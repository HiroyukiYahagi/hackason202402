@extends('layouts.partner')
@section('content')
@component('components.flash')
@endcomponent
<div class="uk-margin-medium">
    <h1 class="uk-text-center">
        最近の発注内容
    </h1>
    <div class="uk-margin-medium">
        @if ($partner->orders->count() == 0)
        <div class="uk-text-bold uk-text-center">
            注文はまだありません
        </div>
        @else
        <div class="uk-margin uk-text-center">
            <h4 class="uk-text-bold uk-margin-small">直近の配送予定</h4>
            <div class="uk-text-bold uk-margin-small">
                {{ $latest_order->arrival_date->format('Y年n月d日') }}
            </div>
            <div class="uk-text-muted uk-margin-small">
                ({{ $latest_order->arrival_time }})で配送
            </div>
            <div class="uk-margin-small">
                <a href="{{route('partner.orders.show', ['order' => $latest_order ])}}" class="uk-button uk-button-link">
                    詳細
                </a>
            </div>
        </div>
        <div class="uk-margin uk-text-center">
            <a href="{{ route('partner.orders.index') }}" class="uk-button uk-button-default uk-width-medium">
                発注履歴
            </a>
        </div>
        @endif
    </div>
    <div class="uk-margin uk-text-center">
        <a href="{{ route('partner.carts.create') }}" class="uk-button uk-button-primary uk-width-medium">
            新しく発注する
        </a>
    </div>
</div>
@endsection
