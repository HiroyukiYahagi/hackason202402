@extends('layouts.wani')

@section('content')

<h1 class="uk-text-center uk-margin-medium">申込内容の確認</h1>

<div class="uk-margin">
  以下の内容に問題がないかご確認の上「申し込む」ボタンを押してください。
</div>
<div class="uk-margin">
  <label class="uk-form-label" for="form-stacked-text">申請者名</label>
  <div class="uk-margin-small">
    {{ $donate["name"] }}
  </div>
</div>

<div class="uk-margin">
  <label class="uk-form-label" for="form-stacked-text">寄付金額</label>
  <div class="uk-margin-small">
    {{ $donate["price"] }}円
  </div>
</div>


<div class="uk-margin">
  <label class="uk-form-label" for="form-stacked-text">お支払い方法</label>
  <div class="uk-margin-small">
    クレジットカード
  </div>
</div>

<div id="donate-form" class="uk-margin uk-text-center">
  <form method="post" action="{{route('donate.submit', ['hash' => $hash])}}">
    <button class="uk-button uk-button-primary uk-button-large uk-width-medium uk-text-bold">
      申し込む
    </button>
    {{ csrf_field() }}
  </form>
</div>

@endsection
