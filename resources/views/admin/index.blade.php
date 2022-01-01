@extends('layouts.app')

@section('content')
    
<h2>
  Bot 一覧
</h2>

<table class="uk-table uk-table-striped uk-table-small uk-table-middle uk-margin">
  <thead>
    <tr>
      <th>#</th>
      <th>Bot name</th>
      <th class="uk-width-medium">action</th>
    </tr>
  </thead>
  <tbody>
  @foreach( $admin->bots as $bot )
    <tr>
      <td>
        {{ $bot->id }}
      </td>
      <td>
        {{ $bot->name }}
      </td>
      <td>
        <a class="uk-icon-button uk-button-primary" href="{{route('admin.bots.view', ['bot' => $bot])}}">
          <span uk-icon="file-edit"></span>
        </a>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>

<div class="uk-margin uk-text-right">
  <form method="post" action="{{route('admin.bots.add')}}">
    <button class="uk-button uk-button-primary">
      新しいボットを作成する
    </button>
    {{ csrf_field() }}
  </form>
</div>

<h2>
  ログイン情報
</h2>

<div class="uk-margin">
  <div class="uk-width-xlarge uk-display-inline-block">
    <form method="post" action="{{route('admin.edit')}}">
      <div class="uk-margin-small">
        @component("components.input.text", [
          "type" => "text", "name" => "email", "label" => "メールアドレス", "required" => true, "value" => $admin->email
        ])@endcomponent
      </div>
      <div class="uk-margin-small">
        @component("components.input.text", [
          "type" => "password", "name" => "password", "label" => "新しいパスワード", "required" => true
        ])@endcomponent
      </div>
      <div class="uk-margin-small">
        <button class="uk-button uk-button-primary uk-width-1-1 only_required">
          変更する
        </button>
      </div>
      {{ csrf_field() }}
    </form>
  </div>
</div>


@endsection
