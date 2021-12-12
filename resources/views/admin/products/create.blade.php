@extends('layouts.app')
@section('title', '商品情報を登録')
@section('content')
    @include('components.errors')

    <form action="{{ route('products.create') }}" method="post">
        @component('components.form.product')@endcomponent
        <div class="uk-margin">
            <button class="uk-button uk-button-primary">登録する</button>
        </div>
        @csrf
    </form>
@endsection
