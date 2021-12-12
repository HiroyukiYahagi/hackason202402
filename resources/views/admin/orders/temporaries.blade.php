@extends('layouts.app')
@section('content')
    <h2>委託の出荷一覧</h2>
    <hr>
    <div class="uk-margin">
    </div>
    @component('components.order_list', [
        'orders' => $orders,
        'param' => $param,
    ])@endcomponent
@endsection
