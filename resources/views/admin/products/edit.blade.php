@extends('layouts.app')
@section('title', '商品情報を編集')
@section('content')
    <form action="{{ route('products.edit', ['product' => $product]) }}" method="post">
        @component('components.form.product', ['product' => $product])@endcomponent
        <div class="uk-margin">
            <button type="submit" class="uk-button uk-button-primary">更新する</button>
        </div>
        @csrf
    </form>
    <form action="{{ route('products.delete', ['product' => $product]) }}" method="post" onsubmit="return confirm('削除してもよろしいですか？')">
        <div class="uk-margin">
            <button type="submit" class="uk-button uk-button-danger">削除する</button>
        </div>
        @csrf
    </form>
@endsection
