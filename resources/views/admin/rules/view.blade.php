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
  「{{ $rule->name }}」の設定
</h1>

<hr />

<h2>アクションリスト</h2>


<hr />

<h2>設定</h2>

<form method="post" action="{{route('admin.rules.edit', ['bot' => $bot, 'senario' => $senario, 'rule' => $rule])}}">
  <table class="uk-table uk-table-small uk-table-striped uk-table-small uk-margin uk-table-middle">
    <tbody>
      <tr>
        <td class="uk-width-medium">
          <span class="uk-text-bold">
            ルール名
          </span>
        </td>
        <td>
          <div class="uk-width-large">
            @component("components.input.text", [
              "label" => null, "name" => "name", "type" => "text", "required" => true, "value" => $rule->name
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
              "label" => null, "name" => "priority", "type" => "number", "required" => true, "value" => $rule->priority
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
            "label" => null, "name" => "is_valid", "required" => true, "value" => $rule->is_valid, "options" => [
              [ "label" => "無効", "value" => 0 ],
              [ "label" => "有効", "value" => 1 ]
            ]
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
            "label" => null, "name" => "condition", "value" => $rule->condition
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
  <form method="post" action="{{route('admin.rules.delete', ['bot' => $bot, 'senario' => $senario, 'rule' => $rule])}}" onsubmit="return confirm('本当に削除しますか？');">
    <button class="uk-button uk-button-danger">
      ルールを削除する
    </button>
    @csrf
  </form>
</div>

@endsection
