@extends('layouts.app')
@section('content')
    @component('components.flash')
    @endcomponent
    <div class="uk-grid-small" uk-grid>
        <div class="uk-width-expand">
            <h1>パートナー一覧</h1>
        </div>
        <div class="uk-width-auto">
            <a href="{{ route('partners.create') }}" class="uk-button uk-button-primary">
                パートナーを登録する
            </a>
        </div>
    </div>
    <hr>
    <div class="uk-margin-medium">
        <!-- 検索 -->
        <h3 class="uk-margin-small">
            絞り込み検索
            <span class="uk-text-small">({{ $partners->total() }}件)</span>
        </h3>
        <form action="{{ route('partners.index') }}">
            @csrf
            <div class="uk-grid-small uk-flex-bottom" uk-grid>
                <div class="uk-width-1-6@s">
                    <label for="id" class="uk-form-label">
                        <small>ID</small>
                    </label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-input" name="id"
                            value="{{ isset($param['id']) ? $param['id'] : null }}" placeholder="ID">
                    </div>
                </div>
                <div class="uk-width-1-6@s">
                    <label class="uk-form-label" for="name">
                        <small>パートナー名</small>
                    </label>
                    <div class="uk-form-controls">
                        <input type="text" class="uk-input" name='name'
                            value="{{ isset($param['name']) ? $param['name'] : null }}" placeholder="パートナー名を入力">
                    </div>
                </div>
                <div class="uk-width-1-6@s">
                    <button class="uk-button uk-button-primary uk-width-1-1">検索</button>
                </div>
            </div>
        </form>
    </div>

    <div class="uk-grid-small uk-margin uk-flex-middle uk-flex-right" uk-grid>
        <div>
            <h4 class="uk-margin-remove">CSV出力:</h4>
        </div>
        <div>
            <a href="{{ route('partners.cocogurasi') }}">ここぐらし出荷用CSV出力</a>
        </div>
    </div>

    <div class="uk-margin-medium">
        <table class="uk-table uk-table-striped">
            <thead class="thead-color">
                <tr>
                    <td>
                        @if (isset($param['direction']) && $param['direction'] == 'asc')
                            @sortablelink('created_at', 'ID▲')
                        @else
                            @sortablelink('created_at', 'ID▼')
                        @endif
                    </td>
                    <td>契約期間</td>
                    <td>パートナー情報</td>
                    <td>発注状況</td>
                    <td>操作</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($partners as $partner)
                    <tr>
                        <td>
                            <a href="{{ route('partners.show', ['partner' => $partner]) }}">{{ $partner->id }}</a>
                        </td>
                        <td>
                            {{ $partner->contract_start ? $partner->contract_start->format('Y年n月d日') : null }}〜 <br>
                            <br>
                            {{ $partner->contract_end ? $partner->contract_end->format('Y年n月d日') : null }}まで <br>
                            @if ($partner->contract_end && $partner->contract_end->lte(now()))
                                <div class="uk-text-danger uk-text-bold">※契約情報を更新してください。</div>
                            @elseif ($partner->contract_end && now()->diffInDays($partner->contract_end) <= 30)
                                <div class="uk-text-primary">※契約更新が近づいています</div>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('partners.show', ['partner' => $partner]) }}">
                                {{ $partner->name }}
                            </a>
                            (<span class="uk-margin-small-right">担当:</span>{{ $partner->staff_name }}様) <br>
                            {{ $partner->tel }}
                            <span>/</span>
                            <a href="mailto:{{ $partner->email }}">{{ $partner->email }}</a> <br>
                            〒{{ $partner->post_code }} <br>
                            {{ $partner->prefecture }}
                            {{ $partner->address }}
                            {{ $partner->address_detail }}
                        </td>
                        <td>
                            <span class="uk-margin-small-right">累計発注額:</span>
                            {{ number_format($partner->total_sales) }}円<br>
                            <span class="uk-margin-small-right">発注回数:</span>
                            {{ $partner->orders->count() }}回
                        </td>
                        <td>
                            @component('components.icon', [
                                'route' => 'partners.show',
                                'args' => ['partner' => $partner],
                                'icon' => 'file-edit',
                                'color' => 'primary',
                            ])@endcomponent
                            @component('components.icon', [
                                'route' => 'carts.create',
                                'args' => ['partner' => $partner],
                                'icon' => 'cart',
                                'color' => 'primary',
                            ])@endcomponent
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- ページネート -->
    {{ $partners->appends(request()->query())->links('pagination::default') }}

@endsection
