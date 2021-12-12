@extends('layouts.app')
@section('content')
    @component('components.flash')
    @endcomponent
    <div class="uk-grid-small" uk-grid>
        <div class="uk-width-expand">
            <h1>商品一覧</h1>
        </div>
        <div class="uk-text-right">
            <a href="{{ route('products.create') }}" class="uk-button uk-button-primary">
                商品を登録する
            </a>
        </div>
    </div>
    <hr>
    <div class="uk-margin-medium">
        <table class="uk-table uk-table-striped">
            <thead class="thead-color">
                <tr>
                    <td>ID</td>
                    <td>商品名</td>
                    <td>原価</td>
                    <td>単価(税抜)</td>
                    <td>販売形態</td>
                    <td>登録日 / 最終更新日</td>
                    <td>操作</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            <a href="{{ route('products.edit', ['product' => $product]) }}">{{ $product->id }}</a>
                        </td>
                        <td>
                            {{ $product->name }}
                        </td>
                        <td>
                            {{ $product->prime_cost }}円
                        </td>
                        <td>
                            {{ number_format($product->price) }}円
                        </td>
                        <td>
                            @if ($product->sales_style == config('const.SALES_STYLE.PURCHASE'))
                                買取
                            @elseif($product->sales_style == config('const.SALES_STYLE.ENTRUSTMENT'))
                                委託
                            @endif
                        </td>
                        <td>
                            {{ $product->created_at }} / {{ $product->updated_at }}
                        </td>
                        <td>
                            @component('components.icon', [
                                'route' => 'products.edit',
                                'args' => ['product' => $product],
                                'icon' => 'file-edit',
                                'color' => 'primary',
                            ])@endcomponent
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
