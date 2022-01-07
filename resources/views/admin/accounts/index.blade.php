@extends('layouts.app')

@section('sidebar')

@include("layouts.sidebar.bot")

@endsection


@section('content')
    
<h1>
  <span class="uk-text-small">{{ $bot->name }}</span><br/>
  アカウント一覧
</h1>

<hr />

<div class="uk-margin-medium">
  <ul uk-accordion="multiple: true" class="uk-margin">
    <li class="uk-margin-xsmall uk-background-muted {{ collect($param)->flatten()->filter( function($d) { return $d !== null && $d !== 'all'; } )->count() != 0 ? 'uk-open':null }}">
      <a class="uk-accordion-title uk-padding-small uk-link-reset" href="#">
        <span class="uk-h3">絞り込み検索 ({{ $accounts->total() }}件)</span>
      </a>
      <div class="uk-accordion-content uk-margin-remove uk-padding-small">
        <div>
          <form method="GET" action="{{route('admin.accounts.index', ['bot' => $bot])}}">
            <div class="uk-margin uk-grid-small uk-flex-bottom" uk-grid>
              <div class="uk-width-1-6">
                @include("components.input.text", [
                  "label" => "初回登録日時~", "name" => "created_at[from]", "type" => "date", "value" => isset($param["created_at"]["from"]) ? $param["created_at"]["from"] : null
                ])
              </div>
              <div class="uk-width-1-6">
                @include("components.input.text", [
                  "label" => "まで", "name" => "created_at[to]", "type" => "date", "value" => isset($param["created_at"]["to"]) ? $param["created_at"]["to"] : null
                ])
              </div>
              <div class="uk-width-1-6">
                @include("components.input.text", [
                  "label" => "ブロック日~", "name" => "blocked_at[from]", "type" => "date", "value" => isset($param["blocked_at"]["from"]) ? $param["blocked_at"]["from"] : null
                ])
              </div>
              <div class="uk-width-1-6">
                @include("components.input.text", [
                  "label" => "まで", "name" => "blocked_at[to]", "type" => "date", "value" => isset($param["blocked_at"]["to"]) ? $param["blocked_at"]["to"] : null
                ])
              </div>
              <div class="uk-width-1-6">
                @include("components.input.text", [
                  "label" => "アカウント名", "name" => "name", "type" => "text", "value" => isset($param["name"]) ? $param["name"] : null
                ])
              </div>
            </div>
            <div class="uk-margin uk-grid-small uk-flex-middle" uk-grid>
              <div class="uk-width-auto">
                @include("components.input.radios", [
                  "label" => "絞り込み", "name" => "status", "value" => isset($param["status"]) ? $param["status"] : null, "options" => [
                    [ "label" => "全て", "value" => "all" ], 
                    [ "label" => "アクティブのみ", "value" => "only_active" ], 
                    [ "label" => "ブロックのみ", "value" => "only_blocked" ]
                  ]
                ])
              </div>
              <div class="uk-width-small">
                <button class="uk-button uk-button-primary uk-width-1-1">
                  検索
                </button>
              </div>
              <div class="uk-width-small">
                <a class="uk-button uk-button-link" href="{{route('admin.accounts.index', ['bot' => $bot])}}">
                  検索をリセット
                </a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </li>
  </ul>
</div>


<table class="uk-table uk-table-striped uk-table-small uk-table-middle uk-margin">
  <thead>
    <tr>
      <th>#</th>
      <th>登録日</th>
      <th>ブロック日</th>
      <th>シナリオ名</th>
      <th class="uk-width-medium">action</th>
    </tr>
  </thead>
  <tbody>
  @foreach( $accounts as $account )
    <tr>
      <td>
        {{ $account->id }}
      </td>
      <td>
        {{ $account->created_at }}
      </td>
      <td>
        {{ $account->blocked_at }}
      </td>
      <td>
        {{ $account->name }}
      </td>
      <td>
        <a class="uk-icon-button uk-button-primary" href="{{route('admin.accounts.view', ['bot' => $bot, 'account' => $account])}}">
          <span uk-icon="file-edit"></span>
        </a>
      </td>
    </tr>
  @endforeach
  </tbody>
</table>

<div class="uk-margin uk-text-center">
  {{ $accounts->appends($param)->links() }}
</div>


@endsection
