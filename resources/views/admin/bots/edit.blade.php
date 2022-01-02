@extends('layouts.app')

@section('sidebar')

@include("layouts.sidebar.bot")

@endsection


@section('content')
    
<h1>
  <span class="uk-text-small">{{ $bot->name }}</span><br/>
  基本情報の編集
</h1>

<hr />

<form method="post" action="{{route('admin.bots.edit', ['bot' => $bot])}}">
  <table class="uk-table uk-table-small uk-table-striped uk-table-small uk-margin uk-table-middle">
    <tbody>
      <tr>
        <td class="uk-width-medium">
          <span class="uk-text-bold">
            ボット名
          </span>
        </td>
        <td>
          <div class="uk-width-large">
            @component("components.input.text", [
              "label" => null, "name" => "name", "type" => "text", "required" => true, "value" => $bot->name
            ])@endcomponent
          </div>
        </td>
      </tr>
      <tr>
        <td class="uk-width-medium">
          <span class="uk-text-bold">
            LINE アカウント名
          </span>
        </td>
        <td>
          <div class="uk-width-large">
            @component("components.input.text", [
              "label" => null, "name" => "line_account_name", "type" => "text", "required" => true, "value" => $bot->line_account_name
            ])@endcomponent
          </div>
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
          @component("components.input.textarea", [
            "label" => null, "name" => "rich_menu", "value" => $bot->rich_menu
          ])@endcomponent
        </td>
      </tr>
    </tbody>
  </table>
  <div class="uk-margin uk-text-center">
    <button class="uk-button uk-button-primary uk-width-large">
      更新する
    </button>
  </div>
  @csrf
</form>

<hr />

<div class="uk-margin uk-text-right">
  <form method="post" action="{{route('admin.bots.delete', ['bot' => $bot])}}" onsubmit="return confirm('本当に削除しますか？');">
    <button class="uk-button uk-button-danger">
      ボットを削除する
    </button>
    @csrf
  </form>
</div>

@endsection