@extends('layouts.wani')

@section('content')

<h1 class="uk-text-center uk-margin-medium">ありがとうございました！</h1>

<div class="uk-margin">
  以下の内容でお申込みを受付ました。<br/>
  この度はわににゃるプロジェクトへご賛同いただきありがとうございました。
</div>

<div class="uk-margin uk-text-center uk-padding uk-background-muted uk-text-center">
  <label class="uk-form-label" for="form-stacked-text">申込みID</label>
  <div class="uk-margin-small uk-h1">
     {{ $donate->id * 631 }} - {{ $donate->id * 199 }}
  </div>
</div>

<div class="uk-margin">
  <label class="uk-form-label" for="form-stacked-text">申請者名</label>
  <div class="uk-margin-small">
    {{ $donate->name }}
  </div>
</div>

<div class="uk-margin">
  <label class="uk-form-label" for="form-stacked-text">寄付金額</label>
  <div class="uk-margin-small">
    {{ $donate->price }}円
  </div>
</div>

<div class="uk-margin">
  <label class="uk-form-label" for="form-stacked-text">お支払い方法</label>
  <div class="uk-margin-small">
    クレジットカード
  </div>
</div>

@endsection
