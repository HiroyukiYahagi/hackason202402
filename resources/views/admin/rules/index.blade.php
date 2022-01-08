@extends('layouts.app')

@section('sidebar')
@include("layouts.sidebar.bot")
@endsection

@section('subbar')
@include("layouts.sidebar.senario")
@endsection

@section('content')
    
<h1>
  <span class="uk-text-small">{{ $senario->name }}</span><br/>
  ルール一覧
</h1>

<hr />

<table class="uk-table uk-table-striped uk-table-small uk-table-middle uk-margin">
  <thead>
    <tr>
      <th>#</th>
      <th>ステータス</th>
      <th>ルール名</th>
      <th>優先順位</th>
      <th>配信数</th>
      <th>エラー数</th>
      <th>ブロック数</th>
      <th class="uk-width-auto">-</th>
    </tr>
  </thead>
  <tbody>
  @foreach( $senario->rules as $rule )
    <tr>
      <td>
        {{ $rule->id }}
      </td>
      <td>
        {{ $rule->is_valid_label }}
      </td>
      <td>
        {{ $rule->name }}
      </td>
      <td>
        {{ $rule->priority }}
      </td>
      <td>
        {{ $rule->applied_count }}
      </td>
      <td>
        {{ $rule->error_count }}
      </td>
      <td>
        {{ $rule->blocked_count }}
      </td>
      <td>
        <a class="uk-icon-button uk-button-primary" href="{{route('admin.rules.view', ['bot' => $bot, 'senario' => $senario, 'rule' => $rule])}}">
          <span uk-icon="file-edit"></span>
        </a>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>

<div class="uk-margin uk-text-right">
  <form method="post" action="{{route('admin.rules.add', ['bot' => $bot, 'senario' => $senario])}}">
    <button class="uk-button uk-button-primary">
      新しいルールを作成する
    </button>
    {{ csrf_field() }}
  </form>
</div>


@endsection
