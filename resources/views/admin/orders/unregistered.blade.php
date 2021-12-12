@extends('layouts.app')
@section('content')
    <h2 class="bold-letters">未登録の注文</h2>
    <hr>
    <h3>
        絞り込み検索
        <span class="uk-text-small">({{ $orders->total() }}件)</span>
    </h3>
    <form action="{{ route('orders.unregistered') }}">
        @csrf
        @component('components.order_search', [
            'param' => $param,
        ])@endcomponent
        <input type="hidden" name="status" value="{{ config('const.UNREGISTERED') }}">
    </form>
    <!-- CSV登録ボタン -->
    <div class="uk-margin-small uk-text-right">
        <form action="{{ route('orders.unregdDownload') }}" method="post" enctype="multipart/form-data">
            <button type="submit" class="uk-button uk-button-default" name="registration_status"
                value="{{ config('const.UNREGISTERED') }}">
                CSV出力
            </button>
            @csrf
        </form>
    </div>
    <!-- 注文一覧 -->
    @component('components.order_list', [
        'orders' => $orders,
        'param' => $param,
    ])@endcomponent    
    <!-- ページネート -->
    {{ $orders->appends(request()->query())->links('pagination::default') }}

@endsection
