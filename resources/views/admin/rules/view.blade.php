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

<div id="action-list">
  <form method="post" action="{{route('admin.rules.actions', ['bot' => $bot, 'senario' => $senario, 'rule' => $rule])}}">
    <table class="uk-table uk-table-small uk-table-striped uk-table-middle uk-margin">
      <thead>
        <tr>
          <th class="uk-table-shrink">#</th>
          <th class="uk-width-medium">TTL</th>
          <th class="uk-table-expand">ACTION</th>
          <th class="uk-table-shrink">-</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(action, index) in actions">
          <td>
            <span v-text="index"></span>
            <input v-if="action.id != null" type="hidden" v-bind:name="'actions['+index+'][id]'" v-model="action.id" />
          </td>
          <td>
            <input class="uk-input" type="text" v-bind:name="'actions['+index+'][name]'" v-model="action.name" />
          </td>
          <td>
            <textarea class="uk-textarea uk-height-small" type="text" v-bind:name="'actions['+index+'][body]'" v-model="action.body"></textarea>
          </td>
          <td>
            <button type="button" class="uk-icon-button uk-button-danger" v-on:click="removeAction(index)">
              <span uk-icon="trash"></span>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="uk-margin uk-text-right">
      <button type="button" class="uk-button uk-button-muted" v-on:click="addAction()">
        アクションを追加する
      </button>
    </div>
    <div class="uk-margin uk-text-center">
      <button type="submit" class="uk-button uk-button-primary">
        更新する
      </button>
      @csrf
    </div>
  </form>
</div>

<script type="text/javascript">
let actionList = new Vue({
  el: '#action-list',
  data: function(){
    return {
      actions: @json($rule->actions )
    };
  },
  methods: {
    addAction: function(){
      this.actions.push( {
        id: null,
        title: "",
        body: "",
      });
    },
    removeAction: function(index){
      this.actions = this.actions.filter( function(action, idx){
        return index != idx;
      });
    }
  }
});
</script>

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
            ルール種別
          </span>
        </td>
        <td>
          @component("components.input.select", [
            "label" => null, "name" => "rule_type", "required" => true, "value" => $rule->rule_type, "options" => [
              [ "label" => "友達登録時", "value" => $rule::ADD_FRIEND ],
              [ "label" => "メッセージ受信時", "value" => $rule::REPLY ]
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