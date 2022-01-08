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
  シナリオ設定の変更
</h1>

<hr />

<form method="post" action="{{route('admin.senarios.edit', ['bot' => $bot, 'senario' => $senario])}}">
  <table class="uk-table uk-table-small uk-table-striped uk-table-small uk-margin uk-table-middle">
    <tbody>
      <tr>
        <td class="uk-width-medium">
          <span class="uk-text-bold">
            シナリオ名
          </span>
        </td>
        <td>
          <div class="uk-width-large">
            @component("components.input.text", [
              "label" => null, "name" => "name", "type" => "text", "required" => true, "value" => $senario->name
            ])@endcomponent
          </div>
        </td>
      </tr>
      <tr>
        <td class="uk-width-medium">
          <span class="uk-text-bold">
            優先順位(小さい方が優先)
          </span>
        </td>
        <td>
          <div class="uk-width-large">
            @component("components.input.text", [
              "label" => null, "name" => "priority", "type" => "number", "required" => true, "value" => $senario->priority
            ])@endcomponent
          </div>
        </td>
      </tr>
      <tr>
        <td class="uk-width-medium">
          <span class="uk-text-bold">
            ステータス
          </span>
        </td>
        <td>
          @component("components.input.radios", [
            "label" => null, "name" => "is_valid", "required" => true, "value" => $senario->is_valid, "options" => [
              [ "label" => "無効", "value" => 0 ],
              [ "label" => "有効", "value" => 1 ]
            ]
          ])@endcomponent
        </td>
      </tr>
      <tr>
        <td class="uk-width-medium">
          <span class="uk-text-bold">
            リッチメニュー
          </span>
        </td>
        <td>
          @component("components.input.code", [
            "label" => null, "name" => "rich_menu", "value" => $senario->rich_menu
          ])@endcomponent
        </td>
      </tr>
      <tr>
        <td class="uk-width-medium">
          <span class="uk-text-bold">
            ルール関数
          </span>
        </td>
        <td>
          @component("components.input.code", [
            "label" => null, "name" => "condition", "value" => $senario->condition
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
  <div class="uk-display-inline-block">
    <form method="post" action="{{route('admin.senarios.copy', ['bot' => $bot, 'senario' => $senario])}}" onsubmit="return confirm('本当にコピーしますか？')">
      <button class="uk-button uk-button-default">
        シナリオをコピーする
      </button>
      @csrf
    </form>
  </div>
  <div class="uk-display-inline-block">
    <form method="post" action="{{route('admin.senarios.delete', ['bot' => $bot, 'senario' => $senario])}}" onsubmit="return confirm('本当に削除しますか？');">
      <button class="uk-button uk-button-danger">
        シナリオを削除する
      </button>
      @csrf
    </form>
  </div>
</div>

@endsection
