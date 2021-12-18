@extends('layouts.app')

@section('content')
    
<div class="uk-text-center">
  <div class="uk-width-large uk-display-inline-block uk-text-left uk-card- uk-card-body uk-card-default">
    <h1 class="uk-text-center">
      LOGIN
    </h1>
    <div class="uk-margin">
      <form method="post" action="{{route('admin.login')}}">
        <div class="uk-margin-small">
          @component("components.input.text", [
            "type" => "text", "name" => "email", "label" => "メールアドレス", "required" => true
          ])@endcomponent
        </div>
        <div class="uk-margin-small">
          @component("components.input.text", [
            "type" => "password", "name" => "password", "label" => "パスワード", "required" => true
          ])@endcomponent
        </div>
        <div class="uk-margin-small">
          <button class="uk-button uk-button-primary uk-width-1-1 only_required">
            ログイン
          </button>
        </div>
        {{ csrf_field() }}
      </form>
    </div>
  </div>
</div>

@endsection
