@extends('layouts.app')

@section('sidebar')

@include("layouts.sidebar.bot")

@endsection


@section('content')
    
<h1>
  <span class="uk-text-small">{{ $bot->name }}</span><br/>
  シナリオ一覧
</h1>

<hr />

<table class="uk-table uk-table-striped uk-table-small uk-table-middle uk-margin">
  <thead>
    <tr>
      <th>#</th>
      <th>ステータス</th>
      <th>シナリオ名</th>
      <th>優先順位</th>
      <th class="uk-width-medium">action</th>
    </tr>
  </thead>
  <tbody>
  @foreach( $bot->senarios as $senario )
    <tr>
      <td>
        {{ $senario->id }}
      </td>
      <td>
        {{ $senario->is_valid }}
      </td>
      <td>
        {{ $senario->name }}
      </td>
      <td>
        {{ $senario->priority }}
      </td>
      <td>
        <a class="uk-icon-button uk-button-primary" href="{{route('admin.senarios.view', ['bot' => $bot, 'senario' => $senario])}}">
          <span uk-icon="file-edit"></span>
        </a>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>

<div class="uk-margin uk-text-right">
  <form method="post" action="{{route('admin.senarios.add', ['bot' => $bot])}}">
    <button class="uk-button uk-button-primary">
      新しいシナリオを作成する
    </button>
    {{ csrf_field() }}
  </form>
</div>


@endsection
