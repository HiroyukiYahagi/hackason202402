@extends('layouts.app')

@section('sidebar')

@include("layouts.sidebar.bot")

@endsection


@section('content')
    
<h1>
  <span class="uk-text-small">{{ $bot->name }}</span><br/>
  LINEボット管理画面
</h1>

<hr />

<h2>アカウント統計</h2>

<div class="uk-margin uk-grid-small" uk-grid>
  <div class="uk-width-1-3">
    <div class="uk-card uk-card-small uk-card-default uk-card-body">
      <h4 class="uk-text-center">
        登録者
      </h4>
      <div class="uk-text-center uk-h3">
        {{ $bot->accounts_count }} / {{ $bot->accounts_count }}
      </div>
    </div>
  </div>
  <div class="uk-width-1-3">
    <div class="uk-card uk-card-small uk-card-default uk-card-body">
      <h4 class="uk-text-center">
        アクティブユーザー数
      </h4>
      <div class="uk-text-center uk-h3">
        {{ $bot->accounts_count }}
      </div>
    </div>
  </div>
  <div class="uk-width-1-3">
    <div class="uk-card uk-card-small uk-card-default uk-card-body">
      <h4 class="uk-text-center">
        メッセージ数
      </h4>
      <div class="uk-text-center uk-h3">
        {{ $bot->accounts_count }}
      </div>
    </div>
  </div>
</div>

<h2>基本設定</h2>
<table class="uk-table uk-table-small uk-table-striped uk-table-small uk-margin uk-table-middle">
  <tbody>
    <tr>
      <td class="uk-width-medium">
        <span class="uk-text-bold">
          ボット名
        </span>
      </td>
      <td>
        {{ $bot->name }}
      </td>
    </tr>
    <tr>
      <td class="uk-width-medium">
        <span class="uk-text-bold">
          LINE アカウント名
        </span>
      </td>
      <td>
        {{ $bot->line_account_name }}
      </td>
    </tr>
    <tr>
      <td class="uk-width-medium">
        <span class="uk-text-bold">
          Webhook URL
        </span>
      </td>
      <td>
        {{ $bot->webhook_url }}
      </td>
    </tr>
    <tr>
      <td class="uk-width-medium">
        <span class="uk-text-bold">
          デフォルトのリッチメニュー
        </span>
      </td>
      <td>
        {{ $bot->rich_menu }}
      </td>
    </tr>
  </tbody>
</table>

@endsection
