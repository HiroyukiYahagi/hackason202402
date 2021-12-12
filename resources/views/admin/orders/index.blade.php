@extends('layouts.app')
@section('content')
    <h2>注文一覧</h2>
    <hr>
    <div class="uk-margin">
        <h3>
            絞り込み検索
            <span class="uk-text-small">({{ $orders->total() }}件)</span>
        </h3>
        <form action="{{ route('orders.index') }}">
            @csrf
            @component('components.order_search', [
                'param' => $param,
            ])@endcomponent
        </form>
    </div>
    <div class="uk-grid-small uk-margin uk-flex-middle uk-flex-right" uk-grid>
        <div>
            <h4 class="uk-margin-remove">CSV出力:</h4>
        </div>
        <div>
            <form action="{{ route('orders.downloadCsv') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <button type="submit" class="uk-button uk-button-default">
                    全ての注文
                </button>
            </form>
        </div>
        <div>
            <form action="{{ route('orders.thisMonthCsv') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <button type="submit" class="uk-button uk-button-default" name="from" value="{{ now()->firstOfMonth() }}">
                    今月の注文
                </button>
            </form>
        </div>
        <div>
            <form action="{{ route('orders.lastMonthCsv') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <button type="submit" class="uk-button uk-button-default" name="from"
                    value="{{ now()->addMonthNoOverflow(-1)->firstOfMonth() }}">
                    先月の注文
                </button>
            </form>
        </div>
    </div>
    @component('components.order_list', [
        'orders' => $orders,
        'param' => $param,
    ])@endcomponent
    <!-- ページネート -->
    {{ $orders->appends(request()->query())->links('pagination::default') }}

@endsection
